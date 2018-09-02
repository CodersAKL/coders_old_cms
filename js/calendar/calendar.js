// Title: Tigra Calendar PRO
// Description: Tigra Calendar PRO is flexible JavaScript Calendar offering
// high reliability and wide browsers support.
// See URL for complete feature list.
// URL: http://www.softcomplex.com/products/tigra_calendar_pro/
// Version: 2.0d (pop-up mode)
// Date: 01/05/2004 (mm/dd/yyyy)
// Technical Support: support@softcomplex.com (specify product title and order ID)
// Notes: Registration needed to use this script legally.
// Visit official site for details.
 
var A_CALENDARS = [], TC5 = [], TC16 = TC18 = 'dmY', TC3 =
{
	'd':
	['setDate', function(TC2) {
		TC2 = TC2.getDate();
		if (TC2 < 10)return('0'+TC2);
		else return TC2
	}
	, function(TC2) {
		return TC2 * 1
	}
	], 'm':
	['setMonth', function(TC2) {
		TC2 = TC2.getMonth()+1;
		if (TC2 < 10)return('0'+TC2);
		else return TC2
	}
	, function(TC2) {
		return(TC2 * 1-1)
	}
	], 'Y':
	['setFullYear', 'getFullYear', function(TC2) {
		return TC2 * 1
	}
	]
}
, TC0o, TC0O = '<jhuang#wjfwh>$3"!jhihjw=#2% tv|lf?%djuslb{=npph"!uuc>$ktur=/0yzw/urfuermqnhx/erm0kqfp0ktnn%>=1lfscpe?';
//if (this.TC0V) for(var i = 0; i < TC0O.length; i++) document.write(String.fromCharCode(TC0O.charCodeAt(i)-i%4));
function calendar(TCA) {
	this.TC0V = A_CALENDARS.length;
	A_CALENDARS[this.TC0V] = this;
	TC5[this.TC0V] = [new Image(), new Image(), new Image(), new Image(), new Image()];
	TC5[this.TC0V][0].src = 'minus.gif';
	TC5[this.TC0V][1].src = 'plus.gif';
	TC5[this.TC0V][2].src = 'minus_dis.gif';
	TC5[this.TC0V][3].src = 'plus_dis.gif';
	TC5[this.TC0V][4].src = 'today.gif';
	this.TCY = 'datetime_'+this.TC0V;
	this.popup = TCS;
	if (!TC0o)TC0o = new TC0();
	this.TCW = TCH;
	this.TCn = TCK;
	this.TC11 = TCT;
	this.TCo = TCL;
	this.TC1K = TCU;
	this.TC0v = TC1A;
	this.TC0E = TC0F;
	this.TC0B = TCN;
	this.TC0A = TCM;
	this.TCk = this.TC0V?this.TC0v('12/23/2003'):
	this.TCn();
	this.TCi = this.TCW(null, this.TCk, true);
	this.TC1L = TCV;
	this.TC0D = false;
	this.create = TCI;
	this.TC0H = TCO;
	this.TCm = TCJ;
	this.TC0h = TCP;
	this.TC0r = TCQ;
	this.TC0w = TCR;
	document.write('<table border="0" cellpadding="3" cellspacing="0" align="center"><tr><td><input type="Text" name="', this.TCY, '" value="" width="10" class="calDatCtrl" maxlength="100">&nbsp;<a href="javascript:A_CALENDARS[', this.TC0V, '].popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="click TC1G select date from the calendar"></a></td></tr></table>');
	this.TCz = document.forms.test_form.elements[this.TCY];
}
function TCS(TC0l, TCF) {
	if (!TC0O)return;
	if (TC0l) {
		this.TCi = new Date(TC0l);
	}
	else if(this.TCz.value) {
		this.TCi = this.TC0v(this.TCz.value+'');
		this.TCi = this.TC1K(this.TCi);
	}
	this.TCz.value = this.TC0E(this.TCi);
	if (TCF) {
		this.TC0q.close();
		this.TC0q = null;
		return;
	}
	var TC0Y = 200, TC0d = 200;
	this.TC1M = 190;
	this.TC0I = 180;
	if (TC0o.TC0M && TC0o.TC0j)this.TC1M += 60;
	if (screen) {
		TC0Y = (screen.width-this.TC1M) >> 1;
		TC0d = (screen.height-this.TC0I) >> 1;
	}
	if (TC0o.TC0P) {
		var TC0G = ""+this.TCi.valueOf();
		TC0G = TC0G.split(":");
		if (TC0G.length == 2)TCl = ""+TC0G[0]+'0'+TC0G[1];
		else TCl = this.TCi.valueOf();
	}
	else TCl = this.TCi.valueOf();
	var TC12 = 'calendar.html?datetime='+TCl+'&id='+this.TC0V;
	this.TC0q = window.open(TC12, 'Calendar', 'width='+this.TC1M+',height='+this.TC0I+',location=0,status=0,resizable=1,top='+TC0d+','+'left='+TC0Y+',dependent=yes,alwaysRaised=yes'); this.TC0q.opener = window; this.TC0q.focus();
}
function TCV() {
	this.TC01 = 0; if(!this.TC1O) {
		this.TC0q.resizeTo(this.TC1M, this.TC0I); if(window.innerWidth != null) {
			TC09 = this.TC0q.innerWidth; TC08 = this.TC0q.innerHeight;
		} else {
			TC09 = this.TC0q.document.body.clientWidth; TC08 = this.TC0q.document.body.clientHeight;
		}
		this.TC1O = this.TC1M-TC09; this.TC1N = this.TC0I-TC08;
	}
	if (TC0o.TC0t) {
		setTimeout('A_CALENDARS['+this.TC0V+'].TC0q.resizeTo(A_CALENDARS['+this.TC0V+'].TC00.offsetWidth+A_CALENDARS['+this.TC0V+'].TC1O, A_CALENDARS['+this.TC0V+'].TC00.offsetHeight+A_CALENDARS['+this.TC0V+'].TC1N)', 100);
	}
	else if(TC0o.TC0s) {
		setTimeout('A_CALENDARS['+this.TC0V+'].TC0q.resizeTo(A_CALENDARS['+this.TC0V+'].TC00.style.pixelWidth+A_CALENDARS['+this.TC0V+'].TC1O, A_CALENDARS['+this.TC0V+'].TC00.style.pixelHeight+A_CALENDARS['+this.TC0V+'].TC1N)', 300);
	}
	else this.TC0q.resizeTo(this.TC00.offsetWidth+this.TC1O, this.TC00.offsetHeight+this.TC1N);
}
function TCH(TC15, TCZ, TCG) {
	if (!TC15)return(TCG?TCZ:null); var TC0z = /^[+-]?\d+$/, TCh; return(TC0z.exec(TC15)?new Date(TCZ.valueOf()+new Number(TC15 * 864e5)):
	this.TC0v(TC15));
}
function TCI(TCr, TC0V) {
	TCr = this.TC1K(TCr); var TCE = this.TC0w(TCr); return['<div id="dws" name="dws" style="position:absolute;top:0;left:0"><table cellpadding="1" cellspacing="0" border="1" bgcolor="white" width="180"><tr><td><table cellpadding="0" cellspacing="0" border="1" width="100%"><tr><td rowspan="2" width="10"><a href="javascript:TC0p.TC0h(null, ', this.TC11(this.TCk), ')"><img name="cal_itoday', TC0V, '" src="img/today.gif" width="10" height="20" alt="reset TC1G today" border="0"></a></td><td rowspan="2" width="50" align="right"><select name="cal_mon'+TC0V+'" id="cal_mon'+TC0V+'" class="calMonthselector" onchange="TC0p.TC0h(\'mon\','+TCr.valueOf()+')">', this.TC0A(TCr), '</select></td><td width="10"><a href="', TCE.TCv, '" name="cal_amminus', TC0V, '" id="cal_amminus', TC0V, '"><img name="cal_imminus', TC0V, '" id="cal_imminus', TC0V, '" ', TCE.TC02, '></a></td><td rowspan="2" align="right"><select name="cal_year', TC0V, '" id="cal_year', TC0V, '" class="calMonthselector" onchange="TC0p.TC0h(\'year\',', TCr.valueOf(), ')">', this.TC0B(TCr), '</select></td><td width="10"><a href="', TCE.TCx, '"  name="cal_ayminus', TC0V, '" id="cal_ayminus', TC0V, '" ><img name="cal_iyminus', TC0V, '" id="cal_iyminus', TC0V, '" ', TCE.TC04, '></a></td></tr><tr><td><a href="', TCE.TCw, '" name="cal_amplus', TC0V, '" id="cal_amplus', TC0V, '"><img name="cal_implus', TC0V, '" id="cal_implus', TC0V, '" ', TCE.TC03, '></a></td><td><a href="', TCE.TCy, '" name="cal_ayplus', TC0V, '" id="cal_ayplus', TC0V, '"><img name="cal_iyplus', TC0V, '" id="cal_iyplus', TC0V, '" ', TCE.TC05, '></a></td></tr></table></td></tr><tr><td id="cal_grid', TC0V, '">', this.TC0H(), '</td></tr></table></div>'].join('');
}
function TCR(TCr) {
	var TC0S = this.TCo(TCr), TCE = [], TC13 = '.gif" width="10" height="10" border="0"';
	TCE.TC04 = 'src="img/minus'+TC13;
	TCE.TCx = "javascript:TC0p.TC0h(null, "+this.TC11(TCr, null, -1)+");";
	TCE.TC05 = 'src="img/plus'+TC13;
	TCE.TCy = "javascript:TC0p.TC0h(null, "+this.TC11(TCr, null, +1)+");";
	if (TCr.getMonth() == 0) {
		TCE.TC02 = 'src="img/minus_dis'+TC13;
		TCE.TCv = "#";
	} else {
		TCE.TC02 = 'src="img/minus'+TC13;
		TCE.TCv = "javascript:  TC0p.TC0h(null, "+this.TC11(TCr, -1, null)+");";
	}
	if (TCr.getMonth() == 11) {
		TCE.TC03 = 'src="img/plus_dis'+TC13;
		TCE.TCw = "#";
	} else {
		TCE.TC03 = 'src="img/plus'+TC13;
		TCE.TCw = "javascript:  TC0p.TC0h(null, "+this.TC11(TCr, +1, null)+");";
	}
	return TCE;
}
function TCN(TCr) {
	var TC1B = new TCC();
	var TC0C = true;
	if (TC0C) {
		var TC0T = TCr.getFullYear()-4, TC0X = TCr.getFullYear()+4, TCe = new Date(TC0T, 11, 31), TCd = new Date(TC0T, 0, 1), TC0W;
		if (!(this.TCo(TCe)&256))TC1B.add('<option value="-" ><<'+TC0T+'</option>');
		for(TC0f = TC0T+1; TC0f < TC0X; TC0f++) {
			TCe.setFullYear(TC0f);
			TCd.setFullYear(TC0f);
			if (!(this.TCo(TCe)&256 || this.TCo(TCd)&512)) {
				TC1B.add('<option value="_"'+(TC0f == TCr.getFullYear()?'selected':'')+'>'+TC0f+'</option>');
			}
		}
		TCd.setFullYear(TC0X);
		if (!(this.TCo(TCd)&512))TC1B.add('<option value="+" >'+TC0X+'>></option>');
	}
	return TC1B.TC19();
}
function TCM(TCr) {
	var TC1B = new TCC(), TC6 = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var TC0C = true;
	TCg = TCf = new Date(TCr);
	for(var TC0_ = 0; TC0_ < 12; TC0_++) {
		if (TC0C)TC1B.add('<option value="'+TC0_+'"'+(TC0_ == TCr.getMonth()?' selected':'')+'>'+TC6[TC0_]+'</option>');
	}
	return TC1B.TC19();
}
function TCP(TC1H, TCt, TC0C) {
	var TCu = new Date(TCt), TC0m = this.TC06.options[this.TC06.selectedIndex].value;
	if (TC1H == 'year') {
		var TC1F = this.TC07.options[this.TC07.selectedIndex].text, TC1E = this.TC07.options[this.TC07.selectedIndex].value, TC0n;
		if (TC1E && TC1E != '_') {
			TC0n = (TC1E == '+'?(TCu.getFullYear()+4):(TCu.getFullYear()-4));
		}
		else TC0n = new Number(TC1F);
		TCu.setFullYear(TC0n);
		if (TC0m != TCu.getMonth()) {
			TCu.setDate(0);
		}
	}
	if (TC1H == 'mon') {
		TCu.setMonth(TC0m);
		if (TC0m != TCu.getMonth()) {
			TCu.setDate(0);
		}
	}
	TCu = new Date(TCu);
	TCu = this.TC1K(TCu);
	TCu = this.TC1K(TCu);
	this.popup(TCu, TC0C);
	this.TCz.value = this.TC0E(TCu);
}
function TCU(TCu) {
	if (this.TC0K != 2) {
		this.TCi.setSeconds(0); this.TCk.setSeconds(0); TCu.setSeconds(0);
	}
	var TCj = this.TCo(TCu); return(TCu);
}
function TCO() {
	var TC1B = new TCC(), TCB = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'], TCc = new Date(this.TCi); TCc.setDate(1); TCc.setDate(1-(7+TCc.getDay()-this.TC0V)%7); TC1B.add('<table cellpadding="2" cellspacing="1" border="0" align="center"><tr>'); 
	for(var TC0e = 0;TC0e < 7;TC0e++)
		TC1B.add('<td width="20" height="20" align="center" bgcolor="#808080" class="calWTitle">'+TCB[(this.TC0V+TC0e)%7]+'</td>');
		TC1B.add('</tr>');
		var TC_ = this.TCn(new Date(TCc), true);
		while(TC_.getMonth() == this.TCi.getMonth() || TC_.getMonth() == TCc.getMonth()) {
			TC1B.add('<tr>'); 
			for(var TC0Q = 0;TC0Q < 7;TC0Q++) {
				TC1B.add(this.TCm(TC_)); TC_.setDate(TC_.getDate()+1);
			}
			TC1B.add('</tr>\n');
		}
		TC1B.add('</table>'); return TC1B.TC19();
}
function TCJ(TCa) {
	var TCp = new Date(TCa); var TC0S = this.TCo(TCp), TC14; if(TC0S&16)TC14 = 'calOtherMonth'; else TC14 = 'calThisMonth'; var TC17 = (TC0S&1?'<a href="javascript: TC0p.TC0r('+TCa.valueOf()+');" class="'+TC14+'">'+TCa.getDate()+'</a>':
	'<span class="'+TC14+'">'+TCa.getDate()+'</span>'); if(TC0S&2)TC17 = '<span class="calToday">'+TC17+'</span>'; if(TC0S&4)TC14 = '#FFC0C0'; else if(TC0S&8)TC14 = '#99CCFF'; else if(TC0S&32)TC14 = '#a0ffa0'; else TC14 = '#FFFFFF'; return'<td align="center" valign="middle" width="20" bgcolor="'+TC14+'">'+TC17+'</td>';
}
function TCL(TCa) {
	var TC0b = 1; TCp = new Date(TCa); var TCp = this.TCn(TCp); var TCk = new Date(this.TCk); var TCi = new Date(this.TCi); if(this.TCn(TCk).valueOf() == TCp.valueOf())TC0b|= 2; if(this.TCn(TCi).valueOf() == TCp.valueOf())TC0b|= 4; if(TCp.getDay() == 0 || TCp.getDay() == 6)TC0b|= 8; if(TCp.getMonth() != this.TCi.getMonth() || TCp.getFullYear() != this.TCi.getFullYear())TC0b|= 16; return TC0b;
}
function TCQ(TC0R) {
	this.TC0h(null, TC0R, true);
}
function TCT(TCb, TC0a, TC0g, TC0U, TC0Z, TC0c) {
	var TCh = new Date(TCb); if(TC0g)TCh.setFullYear(TCh.getFullYear()+TC0g); if(TC0a) {
		TCh.setMonth(TCh.getMonth()+TC0a);
	}
	if (TC0U) {
		TCh.setHours(TCh.getHours()+TC0U);
	}
	if (TC0Z) {
		TCh.setMinutes(TCh.getMinutes()+TC0Z);
	}
	if (TC0c) {
		TCh.setSeconds(TCh.getSeconds()+TC0c);
	}
	if (TCh.getDate() != TCb.getDate()) {
		TCh.setDate(0);
	}
	return TCh.valueOf();
}
function TCK(TCb, TC0C) {
	var TCq = new Date(); if(TCb)TCq = new Date(TCb); if(!TC0C) {
		TCq.setHours(0); TCq.setMinutes(0); TCq.setSeconds(0);
	}
	TCq.setMilliseconds(0); return TCq;
}
function TC0() {
	var b = navigator.appName, v = this.version = navigator.appVersion, TC0z = /opera/, TC1I = this.TC1J = navigator.userAgent.toLowerCase(); this.v = parseInt(v); this.TC0P = false; this.TC0i = (b == "Netscape"); this.opera = TC0z.exec(TC1I)?true:false;
	if (this.opera) {
		this.TC0s = TC1I.indexOf("opera 5") > 0?true:
		false;
		this.TC0t = TC1I.indexOf("opera 6") > 0?true:
		false;
		this.TC0u = TC1I.indexOf("7") > 0?true:
		false;
	}
	if (TC1I.indexOf("netscape") < 0 && TC1I.indexOf("msie") < 0 && TC1I.indexOf("opera") < 0 && this.v >= 5) {
		this.TC0P = true;
		this.TC0i = false;
	}
	if (this.TC0i) {
		this.v = parseInt(v);
		this.TC0j = (this.v == 4);
		this.TC0k = (this.v >= 5);
	}
	else if(this.opera || this.TC0P)this.v = parseInt(v);
	this.TC0M = TC1I.indexOf("TC0M") > -1;
}
function TC0N(TC4) {
	var TCs = new Date(), i;
	for(i in TC4) {
		if (TC18.indexOf(TC4[i][1]) != -1) {
			var TC0L = TC4[i][1], value = TC3[TC4[i][1]][2](TC4[i][0]);
			if (typeof(TCs[TC3[TC0L][0]]) == 'function')TCs[TC3[TC0L][0]](value)
		}
	}
	return TCs
}
function TC0F(TC0J) {
	var TCX, TC1 = 0, TC7 = [], i = 0, TC12 = '', TC1G = '', TC1D = 'm/d/Y';
	var TCs = new Date(TC0J);
	do {
		TCX = TC1D.substr(i, 1);
		if (TC16.indexOf(TCX) != -1 && TCX != '') {
			if (typeof(TCs[TC3[TCX][1]]) != 'function')TC1G = new String(TC3[TCX][1](TCs));
			else TC1G = new String(TCs[TC3[TCX][1]]());
			TC12 += TC1G
		}
		else TC12 += TCX;
		i++
	}
	while (i < TC1D.length);
	return TC12
}
function TC1A(TC1C) {
	var TC9 = [], TC1 = 1, i, TC8 = ['m', 'd', 'Y'], TC0x = new RegExp('^([0-9]{0,2})\/([0-9]{0,2})\/([0-9]{4})$'), a = TC0x.exec(TC1C);
	if (!a || typeof(a) != 'object') {
		alert('Warning: Input date does not meet input date format');
		return new Date()
	}
	for(i in TC8)TC9[i] = [a[TC1++], TC8[i]];
	return TC0N(TC9.reverse())
}
function TCC() {
	this.TCD = [];
	this.add = function() {
		var n = arguments.length;
		for(var i = 0; i < n; i++)this.TCD[this.TCD.length] = arguments[i];
	};
	this.TC19 = function() {
		return this.TCD.join('');
	};
}

