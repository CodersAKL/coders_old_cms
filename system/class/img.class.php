<?
/**
 * Autorius: CodeRS www.coders.lt
 * Programavo: FDisk projektas@gmail.com
 * Data: 2007 03 22
 * 
 * Ši klasė atlieka pagrindines paveiksliuko apdorojimo funkcijas
 * 1. Gražina informaciją apie paveiksliuką/fotografiją
 * 2. Konvertuoja jpg, bmp, gif, bmp paveiksliukus į norimą formatą
 * 3. Sumažina arba sukompresuoja paveiksliuką
 * 4. Uždeda tekstą arba paveiksliuką ant nuotraukos (copyrightą)
 * 5. Paverčia paveiksliuką 90 laipsnių intervalais
 * 6. Apkerpa paveiksliuką
 * 7. Gražina paveiksliuko apdorojimo web interfeisą
 * 8. Ant fotografijos gali uždėti spec efektus (šešėlį, apkirpti kraštus pagal formą)
 * 
 * Be specialaus leidimo kopijuoti ar platinti šį kodą draudžiama
 */
class img {
	var $img;
	var $resource;
	var $info;
	var $debug = false;
	function __construct($img_url) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		$this->img = $img_url;
		if (!function_exists("gd_info")) { $this->klaida("Jūsų serveris nepalaiko GD"); }
		else { $this->tikrink(); }
	}
	function ext($file) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b> Failas: $file<br/>");
		$ext = explode(".",$file);
		return $ext[count($ext)-1];
	}

	/**
	 * Tikrinam ar failas yra ir jei yra paimam visą info apie jį
	 *
	 * @param return true arba klaidos pranesima $return
	 * @return true/false
	 */
	function tikrink($return=false) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b> --> Tikrinu failą: ".$this->img." <br/>");
		if(!$this->info = @getimagesize($this->img)) {
			if ($return) { return false; }
			else { $this->klaida("Neegzistuoja",$this->img); }
		}
		else {
			if (!$this->resource = @imagecreatefromjpeg($this->img)) { $this->klaida("nepavyko nuskaityti paveiksliuko".__LINE__,$this->img); }
			return true;
		}
	}

	/**
     * Konvertuoja i nespalvota
     *
     * @return void
     * @param  resource $im paveiksliukas
     * @access public
     */
	function pilka($im,$save,$quality=100) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		$im = @imagecreatefromjpeg($im);
		//$sx = $this->info[0];
		$sx = imagesx($im);
		$sy = imagesy($im);
		for ($x = 0; $x < $sx; $x++) {
			for ($y = 0; $y < $sy; $y++) {
				$rgb = $this->getPixelRGB($im, $x, $y);
				$colour = ($rgb[0] + $rgb[1] + $rgb[2]) / 3;
				imagesetpixel($im, $x, $y, imagecolorallocate($im, $colour, $colour, $colour));
			}
		}
		imagejpeg($im,$save,$quality);
	}

	/**
     * Grazina RGB spalvu reiksmes i array. Nurodyk tasko vieta
     *
     * Masyvas atrodo taip: array(0 => r, 1 => g, 2 => b)
     *
     * @return array
     * @param  resource $im paveiksliukas
     * @param  int $x kordinate
     * @param  int $y kordinate
     * @access public
     */
	function getPixelRGB($im, $x, $y) {
		$rgb = imagecolorat($im, $x, $y);
		return array(($rgb >> 16) & 0xFF, ($rgb >> 8) & 0xFF, $rgb & 0xFF);
	}

	/**
     * Konvertuoja i juodai balta paveiksliuka
     *
     * Kontrastas nuo 0 iki 255 (juoda/balta), and any
     * jei nurodytas pixelis bus mazesnis nei nurodyta bus paverstas i juoda
     * ir jei aukstesnis i balta
     *
     * @return void
     * @param  resource $im
     * @param  int $level
     * @access public
     */
	function juoda($im, $save,$quality=100, $level = 128) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		//$im = $this->resource;
		$im = @imagecreatefromjpeg($im);
		//$sx = $this->info[0];
		$sx = imagesx($im);
		$sy = imagesy($im);
		$black = imagecolorallocate($im, 0, 0, 0);
		$white = imagecolorallocate($im, 255, 255, 255);
		for ($x = 0; $x < $sx; $x++) {
			for ($y = 0; $y < $sy; $y++) {
				$rgb = img::getPixelRGB($im, $x, $y);
				$intensity = ($rgb[0] + $rgb[1] + $rgb[2]) / 3;
				imagesetpixel($im, $x, $y, ($intensity < $level ? $black : $white));
			}
		}
		imagejpeg($im,$save,$quality);
	}

	function mazinti($width,$height,$save,$quality=100) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		$width_orig = $this->info[0];
		$height_orig = $this->info[1];

		if ($width && ($width_orig < $height_orig)) {
			$width = ($height / $height_orig) * $width_orig;
		} else {
			$height = ($width / $width_orig) * $height_orig;
		}

		// Perpiesiam
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($this->img);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		imageinterlace($image_p);
		// saugojam
		imagejpeg($image_p,$save,$quality);

	}

	/**
	 * Suformuojam klaidos pranešimą
	 *
	 * @param Klaidos žinutė $msg
	 * @param Klaidos failas $what
	 */
	function klaida($msg="Nenustatyta klaida",$what=__FILE__) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		if (empty($what)) { $what = "Nenurodytas"; }
		exit("<center><h3 style='color:red'><img src='".basename(__FILE__)."?img=1'/> Klaida!</h3>Failas: <a href='".$what."' target='_blank'>".$what."</a><hr/><span style='color:red'><b>".$msg."</b></span></center>");
	}

	/**
	 * Gražinam suformuotą html paveiksliukui rodyti
	 *
	 * @return string
	 */
	function show($what,$extra=false) {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		if (isset($what) && !empty($what)) {
			$info = getimagesize($what);
			return "<img src=\"".$what."\" alt=\"".urlencode(basename($what,".".$this->ext($what)))."\" title=\"".(($extra)?"Pavadinimas:".basename($what,".".$this->ext($what))." Tipas:".$info["mime"]." Plotis:".$info[0]."px Aukštis:".$info[1]."px":'')."\" ".$info[3]."/>";
		}
		else {
			return "<img src=\"".$this->img."\" alt=\"".urlencode(basename($this->img,".".$this->ext($this->img)))."\" title=\"".(($extra)?"Pavadinimas:".basename($this->img,".".$this->ext($this->img))." Tipas:".$this->info["mime"]." Plotis:".$this->info[0]."px Aukštis:".$this->info[1]."px":'')."\" ".$this->info[3]."/>";
		}
	}

	function debug($msg) {
		if ($this->debug==true) { $this->debug .= $msg."\n"; }
	}

	function __destruct() {
		$this->debug("Nr.: <b>".__LINE__." funtion ".__FUNCTION__."()</b><br/>");
		if (!empty($this->debug)) {
			$this->debug .= "	<pre>".print_r($this->info,true)."</pre>";
			echo "<div style='border:solid 1px silver;background-color:#E8E8E8;color:silver;font-size:11px;font-family:verdana;padding:10px;margin:10px'>".$this->debug."</div>"; }
	}
}


// Copyright © 2007 - pic2php
// http://www.coders.lt
function error_png() {
	header('Content-type: image/png');
	return base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIsSURBVDjLpVNLSJQBEP7+h6uu62vLVAJDW1KQTMrINQ1vPQzq1GOpa9EppGOHLh0kCEKL7JBEhVCHihAsESyJiE4FWShGRmauu7KYiv6Pma+DGoFrBQ7MzGFmPr5vmDFIYj1mr1WYfrHPovA9VVOqbC7e/1rS9ZlrAVDYHig5WB0oPtBI0TNrUiC5yhP9jeF4X8NPcWfopoY48XT39PjjXeF0vWkZqOjd7LJYrmGasHPCCJbHwhS9/F8M4s8baid764Xi0Ilfp5voorpJfn2wwx/r3l77TwZUvR+qajXVn8PnvocYfXYH6k2ioOaCpaIdf11ivDcayyiMVudsOYqFb60gARJYHG9DbqQFmSVNjaO3K2NpAeK90ZCqtgcrjkP9aUCXp0moetDFEeRXnYCKXhm+uTW0CkBFu4JlxzZkFlbASz4CQGQVBFeEwZm8geyiMuRVntzsL3oXV+YMkvjRsydC1U+lhwZsWXgHb+oWVAEzIwvzyVlk5igsi7DymmHlHsFQR50rjl+981Jy1Fw6Gu0ObTtnU+cgs28AKgDiy+Awpj5OACBAhZ/qh2HOo6i+NeA73jUAML4/qWux8mt6NjW1w599CS9xb0mSEqQBEDAtwqALUmBaG5FV3oYPnTHMjAwetlWksyByaukxQg2wQ9FlccaK/OXA3/uAEUDp3rNIDQ1ctSk6kHh1/jRFoaL4M4snEMeD73gQx4M4PsT1IZ5AfYH68tZY7zv/ApRMY9mnuVMvAAAAAElFTkSuQmCC');
}
if (isset($_GET['img'])) { exit(error_png()); }




/**
 * thumbnail.inc.php
 * 
 * @author 		Ian Selby (ian@gen-x-design.com)
 * @copyright 	Copyright 2006
 * @version 	1.1 (PHP4)
 * 
 */

/**
 * PHP class for dynamically resizing, cropping, and rotating images for thumbnail purposes and either displaying them on-the-fly or saving them.
 *
 */
class Thumbnail {
	/**
	 * WaterMark
	 *
	 * @var unknown_type
	 */
	var $watermarkImg;
	/**
     * Error message to display, if any
     *
     * @var string
     */
	var $errmsg;
	/**
     * Whether or not there is an error
     *
     * @var boolean
     */
	var $error;
	/**
     * Format of the image file
     *
     * @var string
     */
	var $format;
	/**
     * File name and path of the image file
     *
     * @var string
     */
	var $fileName;
	/**
     * Image meta data if any is available (jpeg/tiff) via the exif library
     *
     * @var array
     */
	var $imageMeta;
	/**
     * Current dimensions of working image
     *
     * @var array
     */
	var $currentDimensions;
	/**
     * New dimensions of working image
     *
     * @var array
     */
	var $newDimensions;
	/**
     * Image resource for newly manipulated image
     *
     * @var resource
     * @access private
     */
	var $newImage;
	/**
     * Image resource for image before previous manipulation
     *
     * @var resource
     * @access private
     */
	var $oldImage;
	/**
     * Image resource for image being currently manipulated
     *
     * @var resource
     * @access private
     */
	var $workingImage;
	/**
     * Percentage to resize image by
     *
     * @var int
     * @access private
     */
	var $percent;
	/**
     * Maximum width of image during resize
     *
     * @var int
     * @access private
     */
	var $maxWidth;
	/**
     * Maximum height of image during resize
     *
     * @var int
     * @access private
     */
	var $maxHeight;

	/**
     * Class constructor
     *
     * @param string $fileName
     * @return Thumbnail
     */
	function Thumbnail($fileName) {
		//make sure the GD library is installed
		if(!function_exists("gd_info")) {
			echo 'You do not have the GD Library installed.  This class requires the GD library to function properly.' . "\n";
			echo 'visit http://us2.php.net/manual/en/ref.image.php for more information';
			exit;
		}
		//initialize variables
		$this->errmsg               = '';
		$this->error                = false;
		$this->currentDimensions    = array();
		$this->newDimensions        = array();
		$this->fileName             = $fileName;
		$this->imageMeta			= array();
		$this->percent              = 100;
		$this->maxWidth             = 0;
		$this->maxHeight            = 0;
		$this->watermarkImg 		= '';

		//check to see if file exists
		if(!file_exists($this->fileName)) {
			$this->errmsg = 'File not found';
			$this->error = true;
		}
		//check to see if file is readable
		elseif(!is_readable($this->fileName)) {
			$this->errmsg = 'File is not readable';
			$this->error = true;
		}

		//if there are no errors, determine the file format
		if($this->error == false) {
			$infos = getimagesize($this->fileName);
			if($infos[2] == 1 ) { $this->format = 'GIF'; }
			elseif($infos[2] == 2 ) { $this->format = 'JPG'; }
			elseif($infos[2] == 3 ) { $this->format = 'PNG'; }
			else { $this->errmsg = 'Unknown file format'; $this->error = true; }
		}

		//initialize resources if no errors
		if($this->error == false) {
			switch($this->format) {
				case 'GIF':
					$this->oldImage = ImageCreateFromGif($this->fileName);
					break;
				case 'JPG':
					$this->oldImage = ImageCreateFromJpeg($this->fileName);
					break;
				case 'PNG':
					$this->oldImage = ImageCreateFromPng($this->fileName);
					//imagealphablending(
					break;
			}

			$size = GetImageSize($this->fileName);
			$this->currentDimensions = array('width'=>$size[0],'height'=>$size[1]);
			$this->newImage = $this->oldImage;
			$this->gatherImageMeta();
		}

		if($this->error == true) {
			$this->showErrorImage();
			break;
		}
	}

	/**
     * Must be called to free up allocated memory after all manipulations are done
     *
     */
	function destruct() {
		if(is_resource($this->newImage)) @ImageDestroy($this->newImage);
		if(is_resource($this->oldImage)) @ImageDestroy($this->oldImage);
		if(is_resource($this->workingImage)) @ImageDestroy($this->workingImage);
	}

	/**
     * Returns the current width of the image
     *
     * @return int
     */
	function getCurrentWidth() {
		return $this->currentDimensions['width'];
	}

	/**
     * Returns the current height of the image
     *
     * @return int
     */
	function getCurrentHeight() {
		return $this->currentDimensions['height'];
	}

	/**
     * Calculates new image width
     *
     * @param int $width
     * @param int $height
     * @return array
     */
	function calcWidth($width,$height) {
		$newWp = (100 * $this->maxWidth) / $width;
		$newHeight = ($height * $newWp) / 100;
		return array('newWidth'=>intval($this->maxWidth),'newHeight'=>intval($newHeight));
	}

	/**
     * Calculates new image height
     *
     * @param int $width
     * @param int $height
     * @return array
     */
	function calcHeight($width,$height) {
		$newHp = (100 * $this->maxHeight) / $height;
		$newWidth = ($width * $newHp) / 100;
		return array('newWidth'=>intval($newWidth),'newHeight'=>intval($this->maxHeight));
	}

	/**
     * Calculates new image size based on percentage
     *
     * @param int $width
     * @param int $height
     * @return array
     */
	function calcPercent($width,$height) {
		$newWidth = ($width * $this->percent) / 100;
		$newHeight = ($height * $this->percent) / 100;
		return array('newWidth'=>intval($newWidth),'newHeight'=>intval($newHeight));
	}

	/**
     * Calculates new image size based on width and height, while constraining to maxWidth and maxHeight
     *
     * @param int $width
     * @param int $height
     */
	function calcImageSize($width,$height) {
		$newSize = array('newWidth'=>$width,'newHeight'=>$height);

		if($this->maxWidth > 0) {

			$newSize = $this->calcWidth($width,$height);

			if($this->maxHeight > 0 && $newSize['newHeight'] > $this->maxHeight) {
				$newSize = $this->calcHeight($newSize['newWidth'],$newSize['newHeight']);
			}

			//$this->newDimensions = $newSize;
		}

		if($this->maxHeight > 0) {
			$newSize = $this->calcHeight($width,$height);

			if($this->maxWidth > 0 && $newSize['newWidth'] > $this->maxWidth) {
				$newSize = $this->calcWidth($newSize['newWidth'],$newSize['newHeight']);
			}

			//$this->newDimensions = $newSize;
		}

		$this->newDimensions = $newSize;
	}

	/**
     * Calculates new image size based percentage
     *
     * @param int $width
     * @param int $height
     */
	function calcImageSizePercent($width,$height) {
		if($this->percent > 0) {
			$this->newDimensions = $this->calcPercent($width,$height);
		}
	}

	/**
     * Displays error image
     *
     */
	function showErrorImage() {
		header('Content-type: image/png');
		$errImg = ImageCreate(220,25);
		$bgColor = imagecolorallocate($errImg,0,0,0);
		$fgColor1 = imagecolorallocate($errImg,255,255,255);
		$fgColor2 = imagecolorallocate($errImg,255,0,0);
		imagestring($errImg,3,6,6,'Error:',$fgColor2);
		imagestring($errImg,3,55,6,$this->errmsg,$fgColor1);
		imagepng($errImg);
		imagedestroy($errImg);
	}

	/**
     * Resizes image to maxWidth x maxHeight
     *
     * @param int $maxWidth
     * @param int $maxHeight
     */
	function resize($maxWidth = 0, $maxHeight = 0) {
		$this->maxWidth = $maxWidth;
		$this->maxHeight = $maxHeight;

		$this->calcImageSize($this->currentDimensions['width'],$this->currentDimensions['height']);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}
		else {
			$this->workingImage = ImageCreate($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}


		ImageCopyResampled(
		$this->workingImage,
		$this->oldImage,
		0,
		0,
		0,
		0,
		$this->newDimensions['newWidth'],
		$this->newDimensions['newHeight'],
		$this->currentDimensions['width'],
		$this->currentDimensions['height']
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newDimensions['newWidth'];
		$this->currentDimensions['height'] = $this->newDimensions['newHeight'];
	}

	/**
	 * Resizes the image by $percent percent
	 *
	 * @param int $percent
	 */
	function resizePercent($percent = 0) {
		$this->percent = $percent;

		$this->calcImageSizePercent($this->currentDimensions['width'],$this->currentDimensions['height']);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}
		else {
			$this->workingImage = ImageCreate($this->newDimensions['newWidth'],$this->newDimensions['newHeight']);
		}

		ImageCopyResampled(
		$this->workingImage,
		$this->oldImage,
		0,
		0,
		0,
		0,
		$this->newDimensions['newWidth'],
		$this->newDimensions['newHeight'],
		$this->currentDimensions['width'],
		$this->currentDimensions['height']
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $this->newDimensions['newWidth'];
		$this->currentDimensions['height'] = $this->newDimensions['newHeight'];
	}

	/**
	 * Crops the image from calculated center in a square of $cropSize pixels
	 *
	 * @param int $cropSize
	 */
	function cropFromCenter($cropSize) {
		if($cropSize > $this->currentDimensions['width']) $cropSize = $this->currentDimensions['width'];
		if($cropSize > $this->currentDimensions['height']) $cropSize = $this->currentDimensions['height'];

		$cropX = intval(($this->currentDimensions['width'] - $cropSize) / 2);
		$cropY = intval(($this->currentDimensions['height'] - $cropSize) / 2);

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($cropSize,$cropSize);
		}
		else {
			$this->workingImage = ImageCreate($cropSize,$cropSize);
		}

		imagecopyresampled(
		$this->workingImage,
		$this->oldImage,
		0,
		0,
		$cropX,
		$cropY,
		$cropSize,
		$cropSize,
		$cropSize,
		$cropSize
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $cropSize;
		$this->currentDimensions['height'] = $cropSize;
	}

	/**
	 * Advanced cropping function that crops an image using $startX and $startY as the upper-left hand corner.
	 *
	 * @param int $startX
	 * @param int $startY
	 * @param int $width
	 * @param int $height
	 */
	function crop($startX,$startY,$width,$height) {
		//make sure the cropped area is not greater than the size of the image
		if($width > $this->currentDimensions['width']) $width = $this->currentDimensions['width'];
		if($height > $this->currentDimensions['height']) $height = $this->currentDimensions['height'];
		//make sure not starting outside the image
		if(($startX + $width) > $this->currentDimensions['width']) $startX = ($this->currentDimensions['width'] - $width);
		if(($startY + $height) > $this->currentDimensions['height']) $startY = ($this->currentDimensions['height'] - $height);
		if($startX < 0) $startX = 0;
		if($startY < 0) $startY = 0;

		if(function_exists("ImageCreateTrueColor")) {
			$this->workingImage = ImageCreateTrueColor($width,$height);
		}
		else {
			$this->workingImage = ImageCreate($width,$height);
		}

		imagecopyresampled(
		$this->workingImage,
		$this->oldImage,
		0,
		0,
		$startX,
		$startY,
		$width,
		$height,
		$width,
		$height
		);

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $width;
		$this->currentDimensions['height'] = $height;
	}

	/**
	 * Outputs the image to the screen, or saves to $name if supplied.  Quality of JPEG images can be controlled with the $quality variable
	 *
	 * @param int $quality
	 * @param string $name
	 */
	function show($quality=100,$name = '') {
		switch($this->format) {
			case 'GIF':
				if($name != '') {
					ImageGif($this->newImage,$name);
				}
				else {
					header('Content-type: image/gif');
					ImageGif($this->newImage);
				}
				break;
			case 'JPG':
				if($name != '') {
					ImageJpeg($this->newImage,$name,$quality);
				}
				else {
					header('Content-type: image/jpeg');
					ImageJpeg($this->newImage,'',$quality);
				}
				break;
			case 'PNG':
				if($name != '') {
					ImagePng($this->newImage,$name);
				}
				else {
					header('Content-type: image/png');
					ImagePng($this->newImage);
				}
				break;
		}
	}

	/**
	 * Saves image as $name (can include file path), with quality of # percent if file is a jpeg
	 *
	 * @param string $name
	 * @param int $quality
	 */
	function save($name,$quality=100) {
		$this->show($quality,$name);
	}

	/**
	 * Creates Apple-style reflection under image, optionally adding a border to main image
	 *
	 * @param int $percent
	 * @param int $reflection
	 * @param int $white
	 * @param bool $border
	 * @param string $borderColor
	 */
	function createReflection($percent,$reflection,$white,$border = true,$borderColor = '#a4a4a4') {
		$width = $this->currentDimensions['width'];
		$height = $this->currentDimensions['height'];

		$reflectionHeight = intval($height * ($reflection / 100));
		$newHeight = $height + $reflectionHeight;
		$reflectedPart = $height * ($percent / 100);

		$this->workingImage = ImageCreateTrueColor($width,$newHeight);

		ImageAlphaBlending($this->workingImage,true);

		$colorToPaint = ImageColorAllocateAlpha($this->workingImage,255,255,255,0);
		ImageFilledRectangle($this->workingImage,0,0,$width,$newHeight,$colorToPaint);

		imagecopyresampled(
		$this->workingImage,
		$this->newImage,
		0,
		0,
		0,
		$reflectedPart,
		$width,
		$reflectionHeight,
		$width,
		($height - $reflectedPart));
		$this->imageFlipVertical();

		imagecopy($this->workingImage,$this->newImage,0,0,0,0,$width,$height);

		imagealphablending($this->workingImage,true);

		for($i=0;$i<$reflectionHeight;$i++) {
			$colorToPaint = imagecolorallocatealpha($this->workingImage,255,255,255,($i/$reflectionHeight*-1+1)*$white);
			imagefilledrectangle($this->workingImage,0,$height+$i,$width,$height+$i,$colorToPaint);
		}

		if($border == true) {
			$rgb = $this->hex2rgb($borderColor,false);
			$colorToPaint = imagecolorallocate($this->workingImage,$rgb[0],$rgb[1],$rgb[2]);
			imageline($this->workingImage,0,0,$width,0,$colorToPaint); //top line
			imageline($this->workingImage,0,$height,$width,$height,$colorToPaint); //bottom line
			imageline($this->workingImage,0,0,0,$height,$colorToPaint); //left line
			imageline($this->workingImage,$width-1,0,$width-1,$height,$colorToPaint); //right line
		}

		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $width;
		$this->currentDimensions['height'] = $newHeight;
	}

	/**
	 * Inverts working image, used by reflection function
	 * 
	 * @access	private
	 */
	function imageFlipVertical() {
		$x_i = imagesx($this->workingImage);
		$y_i = imagesy($this->workingImage);

		for($x = 0; $x < $x_i; $x++) {
			for($y = 0; $y < $y_i; $y++) {
				imagecopy($this->workingImage,$this->workingImage,$x,$y_i - $y - 1, $x, $y, 1, 1);
			}
		}
	}

	/**
	 * Converts hexidecimal color value to rgb values and returns as array/string
	 *
	 * @param string $hex
	 * @param bool $asString
	 * @return array|string
	 */
	function hex2rgb($hex, $asString = false) {
		// strip off any leading #
		if (0 === strpos($hex, '#')) {
			$hex = substr($hex, 1);
		} else if (0 === strpos($hex, '&H')) {
			$hex = substr($hex, 2);
		}

		// break into hex 3-tuple
		$cutpoint = ceil(strlen($hex) / 2)-1;
		$rgb = explode(':', wordwrap($hex, $cutpoint, ':', $cutpoint), 3);

		// convert each tuple to decimal
		$rgb[0] = (isset($rgb[0]) ? hexdec($rgb[0]) : 0);
		$rgb[1] = (isset($rgb[1]) ? hexdec($rgb[1]) : 0);
		$rgb[2] = (isset($rgb[2]) ? hexdec($rgb[2]) : 0);

		return ($asString ? "{$rgb[0]} {$rgb[1]} {$rgb[2]}" : $rgb);
	}

	/**
     * Reads selected exif meta data from jpg images and populates $this->imageMeta with appropriate values if found
     *
     */
	function gatherImageMeta() {
		//only attempt to retrieve info if exif exists
		if(function_exists("exif_read_data") && $this->format == 'JPG') {
			$imageData = exif_read_data($this->fileName);
			if(isset($imageData['Make']))
			$this->imageMeta['make'] = ucwords(strtolower($imageData['Make']));
			if(isset($imageData['Model']))
			$this->imageMeta['model'] = $imageData['Model'];
			if(isset($imageData['COMPUTED']['ApertureFNumber'])) {
				$this->imageMeta['aperture'] = $imageData['COMPUTED']['ApertureFNumber'];
				$this->imageMeta['aperture'] = str_replace('/','',$this->imageMeta['aperture']);
			}
			if(isset($imageData['ExposureTime'])) {
				$exposure = explode('/',$imageData['ExposureTime']);
				$exposure = round($exposure[1]/$exposure[0],-1);
				$this->imageMeta['exposure'] = '1/' . $exposure . ' second';
			}
			if(isset($imageData['Flash'])) {
				if($imageData['Flash'] > 0) {
					$this->imageMeta['flash'] = 'Yes';
				}
				else {
					$this->imageMeta['flash'] = 'No';
				}
			}
			if(isset($imageData['FocalLength'])) {
				$focus = explode('/',$imageData['FocalLength']);
				$this->imageMeta['focalLength'] = round($focus[0]/$focus[1],2) . ' mm';
			}
			if(isset($imageData['DateTime'])) {
				$date = $imageData['DateTime'];
				$date = explode(' ',$date);
				$date = str_replace(':','-',$date[0]) . ' ' . $date[1];
				$this->imageMeta['dateTaken'] = date('m/d/Y g:i A',strtotime($date));
			}
		}
	}

	/**
     * Rotates image either 90 degrees clockwise or counter-clockwise
     *
     * @param string $direction
     */
	function rotateImage($direction = 'CW') {
		if($direction == 'CW') {
			$this->workingImage = imagerotate($this->workingImage,-90,0);
		}
		else {
			$this->workingImage = imagerotate($this->workingImage,90,0);
		}
		$newWidth = $this->currentDimensions['height'];
		$newHeight = $this->currentDimensions['width'];
		$this->oldImage = $this->workingImage;
		$this->newImage = $this->workingImage;
		$this->currentDimensions['width'] = $newWidth;
		$this->currentDimensions['height'] = $newHeight;
	}

	/**
	 * Enter description here...
	 *
	 */
	function watermark() {
		$this->workingImage = imagecreatefrompng($this->watermarkImg); // Would you really want to use anything other than a png?
		imagealphablending($this->workingImage, false);
		imagesavealpha($this->workingImage, true);
		$sourcefile_width=imageSX($this->oldImage);
		$sourcefile_height=imageSY($this->oldImage);
		$watermarkfile_width=imageSX($this->workingImage);
		$watermarkfile_height=imageSY($this->workingImage);
		$dest_x = ( $sourcefile_width / 2 ) - ( $watermarkfile_width / 2 );
		$dest_y = ( $sourcefile_height / 2 ) - ( $watermarkfile_height / 2 );
		// if a gif, we have to upsample it to a truecolor image
		if($this->format == 'GIF') {
			$tempimage = imagecreatetruecolor($sourcefile_width,$sourcefile_height);
			imagecopy($tempimage, $this->oldImage, 0, 0, 0, 0,$sourcefile_width, $sourcefile_height);
			$this->workingImage = $tempimage;
		}
		imagecopy($this->newImage, $this->workingImage, $dest_x, $dest_y, 0, 0,$watermarkfile_width, $watermarkfile_height);
	}
}
?> 
