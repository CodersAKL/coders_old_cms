<?php
class epastas
{
    var $to = array();
    var $bcc = array();
    var $cc = array();
    var $priorities = array('1 (Highest)','2 (High)','3 (Normal)','4 (Low)','5 (Lowest)');
    var $confirmation = 0;
    var $headers = array();
    var $attachment = array();
    var $charset = "windows-1257";
    var $encoding = "8bit";

    function epastas()
    {
        $this->boundary = "--" . md5(uniqid("abcdefghij"));
    }

    function Error($metodas, $tekstas, $line, $klase = "epastas")
    {
        echo "<font color=\"red\"><b>Klaida!</b><br>";
        echo "Klase: " . $klase . ", Metodas: " . $metodas . ", Eilute: " . $line . "<br>";
        echo $tekstas;
        exit;
    }

    function Subject($subject)
    {
        $this->headers['Subject'] = str_replace("\r\n", "  ", $subject);
    }

    function From($from)
    {
        if (!is_string($from))
            $this->Error("From", "FROM privalo buti String tipo", __LINE__);
    
        $this->headers['From'] = $from;
        
    }

    function ReplyTo($rto)
    {
        if(!is_string($rto)) 
            $this->Error("ReplyTo", "ReplyTo privalo buti String tipo", __LINE__);
        $this->headers["Reply-To"] = $rto;
    }

    function Confirmation($conf = 1)
    {
        if ($conf != 0 && $conf != 1)
            $this->Error("Confirmation", "Confirmation privalo buti 0 arba 1", __LINE__);
        $this->confirmation = $conf;
    }

    function To($tto)
    {
        if (is_array($tto))
            $this->to = $tto;
        else
            $this->to[] = $tto;    
        $this->Check($this->to);
    }

    function Cc($tcc)
    {
        if (is_array($tcc))
            $this->cc = $tcc;
        else
            $this->cc[] = $tcc;
        $this->Check($this->cc);
    }

    function Bcc($tbcc)
    {
        if (is_array($tbcc))
            $this->bcc = $tbcc;
        else
            $this->bcc[]= $tbcc;
        $this->Check($this->bcc);
    }

    function Body($body, $charset="")
    {
        $this->body = $body;
        if ($charset != "")
        {
            $this->charset = strtolower($charset);
            if ($this->charset == "us-ascii")
                $this->encoding = "7bit";
        }
    }
    
    function Organization($org)
    {
        if (trim($org != ""))
            $this->headers['Organization'] = $org;
    }
    
    function Priority($priority)
    {
        if (!intval ($priority) || !isset($this->priorities[$priority-1]))
            $this->Error("Priority", "Priority privalo Integer nuo 1 iki 5", __LINE__);
        $this->headers["X-Priority"] = $this->priorities[$priority-1];
    }

    function Attach($filename, $filetype = "", $disposition = "inline")
    {
        if ($filetype == "")
            $filetype = "application/x-unknown-content-type";
        $this->attachment[] = $filename;
        $this->actype[] = $filetype;
        $this->adispo[] = $disposition;
    }

    function BuildMail()
    {
        $this->headers_real = "";
        if (count($this->cc)>0)
            $this->headers['CC'] = implode (", ", $this->cc);
        if (count($this->bcc)>0) 
            $this->headers['BCC'] = implode (", ", $this->bcc);
        if ($this->confirmation)
        {
            if (isset($this->headers["Reply-To"]))
                $this->headers["Disposition-Notification-To"] = $this->headers["Reply-To"];
            else
                $this->headers["Disposition-Notification-To"] = $this->headers['From'];
        }
        if ($this->charset != "")
        {
            $this->headers["Mime-Version"] = "1.0";
            $this->headers["Content-Type"] = "text/plain; charset=$this->charset";
            $this->headers["Content-Transfer-Encoding"] = $this->encoding;
        }
        $this->headers["X-Mailer"] = "PHP ".phpversion();
        if (count($this->attachment)>0)
            $this->_build_attachement();
        else
            $this->fullBody = $this->body;
        reset($this->headers);
        while (list($hdr,$value) = each($this->headers))
        {
            if ($hdr != "Subject")
                $this->headers_real .= "$hdr: $value\n";
        }
    }

    function Send()
    {
        $this->BuildMail();
        $this->strTo = implode( ", ", $this->to );
        $res = @mail($this->strTo, $this->headers['Subject'], $this->fullBody, $this->headers_real);
    }

    function Get()
    {
        $this->BuildMail();
        $mail = "To: " . $this->strTo . "\n";
        $mail .= $this->headers_real . "\n";
        $mail .= $this->fullBody;
        return $mail;
    }

    function ValidEmail($adresas)
    {
        $email_regexp = "^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~ ])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~ ]+\\.)+[a-zA-Z]{2,4}\$";
        return (eregi($email_regexp, $adresas) != 0);
    }

    function Check($adresai)
    {
        for ($i=0; $i<count($adresai); $i++)
        {
            if(!$this->ValidEmail($adresai[$i]) )
                $this->Error("Check", "nekorekti?kas elektroninio pa?to adresas: " . $adresai[$i], __LINE__);
        }
    }

    function _build_attachement()
    {
        $this->headers["Content-Type"] = "multipart/mixed;\n boundary=\"$this->boundary\"";
        $this->fullBody = "This is a multi-part message in MIME format.\n--$this->boundary\n";
        $this->fullBody .= "Content-Type: text/plain; charset=$this->charset\nContent-Transfer-Encoding: $this->encoding\n\n" . $this->body ."\n";
        $sep = chr(13) . chr(10);
        $ata= array();
        $k=0;
        for ($i=0; $i<count($this->attachment); $i++)
        {
            $filename = $this->attachment[$i];
            $basename = basename($filename);
            $ctype = $this->actype[$i];
            $disposition = $this->adispo[$i];
            if (!file_exists($filename))
                $this->Error("_build_attachement", "failas $filename nerastas", __LINE__);
            $subhdr= "--$this->boundary\nContent-type: $ctype;\n name=\"$basename\"\nContent-Transfer-Encoding: base64\nContent-Disposition: $disposition;\n  filename=\"$basename\"\n";
            $ata[$k++] = $subhdr;
            $linesz = filesize($filename)+1;
            $fp = fopen($filename, 'r');
            $ata[$k++] = chunk_split(base64_encode(fread($fp, $linesz)));
            fclose($fp);
        }
        $this->fullBody .= implode($sep, $ata);
    }

} // class epastas PABAIGA

?> 
