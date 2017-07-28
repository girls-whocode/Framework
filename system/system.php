<?php
defined('SITEKEY') or die('Direct access to this file is not allowed.');

# NUMBER FUNCTIONS
function clean_number($string, $flags='') {
	$comma = $decimal = $minus = true;
	$parsedFlags = (count(explode(' ', $flags)) > 0 ? explode(' ', $flags) : $flags);
	$allowed = array('NO_COMMA', 'NO_DECIMAL', 'NO_MINUS', 'NUMBERS_ONLY');

	if (is_array ($parsedFlags)) {
		foreach ($parsedFlags as $explodedflag) {
			if (in_array ($explodedflag, $allowed)) {
				switch (strtoupper ($explodedflag)) {
					case 'NO_COMMA':
						$comma = false;
						break;
					case 'NO_DECIMAL':
						$decimal = false;
						break;
					case 'NO_MINUS':
						$minus = false;
						break;
					case 'NUMBERS_ONLY':
						$comma = false;
						$decimal = false;
						$minus = false;
						break;
				}
			}
		}
	}
	$pattern = "/[^0-9".($comma ? "," : "").($decimal ? "." : "").($minus ? "-" : "")."]+/";
	return preg_replace ($pattern, "", $string);
}
function decimal_to_fraction($fraction) {
	$base = floor($fraction);
	$fraction -= $base;
	if( $fraction == 0 ) return $base;
	list($ignore, $numerator) = preg_split('/\./', $fraction, 2);
	$denominator = pow(10, strlen($numerator));
	$gcd = gcd($numerator, $denominator);
	$fraction = ($numerator / $gcd) . '/' . ($denominator / $gcd);
	if( $base > 0 ) {
		return $base . ' ' . $fraction;
	} else {
		return $fraction;
	}
}
function gcd($a, $b) {
	return ($a % $b) ? gcd($b,$a % $b) : $b;
}
function fraction_to_decimal ($fraction) {
	$wholenum = explode(" ", $fraction);
	#var_dump($wholenum);
	if (count($wholenum) == 1) {
		$wholenumber = '';
		$numbers = explode("/", $fraction);
		if ($numbers[0] >= $numbers[1]) {
			$wholenum = floor($numbers[0] / $numbers[1]);
			$decimal = (floor($numbers[0] - ($numbers[0] * $wholenum))) / $numbers[1];
		}
		else {
			$decimal = $numbers[0] / $numbers[1];
		}
	}
	else {
		$wholenumber = $wholenum[0];
		$numbers = explode("/", $wholenum[1]);
		if ($numbers[0] >= $numbers[1]) {
			$wholenum = floor($numbers[0] / $numbers[1]);
			$decimal = (floor($numbers[0] - ($numbers[0] * $wholenum))) / $numbers[1];
		}
		else {
			$decimal = $numbers[0] / $numbers[1];
		}

	}

	$cleaned = (explode(".", $decimal));
	$return = (isset($wholenumber) ? $wholenumber : '0').'.'.$cleaned[1];
	return $return;
}
function is_whole_number($num) {
	return (is_numeric($num)&&(intval($num)==floatval($num)));
}
function return_whole_number($num){
	return floor(clean_number($num));
}
function return_decimal_number($num){
	return fmod(clean_number($num), 1);
}
function ordinalize($num) {
	$number = floor(clean_number($num));
	$ordinal = array(1=>'st', 2=>'nd', 3=>'rd');
	$e = $number % 100;
	$x = $number % 10;
	return $number.(($x > 0 && $x < 4 && ($e < 11 || $e > 13)) ? $ordinal[$x] : 'th');
}
function parity($num) {
	return (is_numeric($num)&(!($num&1)));
}
function trim_num($num, $digits = 0){
	$shift = pow(10, $digits);
	return ((floor($num * $shift)) / $shift);
}
function roman_numerals($num){
	$c = 'IVXLCDM';
	for($a = 5, $b = $s = ''; $num; $b++, $a^=7) {
		for (@$o = $num % $a, $num = $num / $a ^ 0; @$o--; @$s = $c[$o > 2 ? $b + $num - ($num &= -2) + $o = 1 : $b] . $s) ;
	}
	return $s;
}

# ADDRESS/GEOLOCATION
function getDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2) {
	$theta = $longitude1 - $longitude2;
	$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
	$miles = acos($miles);
	$miles = rad2deg($miles);
	$miles = $miles * 60 * 1.1515;
	$feet = $miles * 5280;
	$yards = $feet / 3;
	$kilometers = $miles * 1.609344;
	$meters = $kilometers * 1000;
	return compact('miles','feet','yards','kilometers','meters');
}
function getAddressFromPoints($latitude, $longitude)   {
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$status = $data->status;
	$address = array(
		"formatted_address"=>$data->results[0]->formatted_address,
		"street_number_long"=>$data->results[0]->address_components[0]->long_name,
		"street_number_short"=>$data->results[0]->address_components[0]->short_name,
		"street_name_long"=>$data->results[0]->address_components[1]->long_name,
		"street_name_short"=>$data->results[0]->address_components[1]->short_name,
		"street_type"=>$data->results[0]->address_components[1]->types[0],
		"city_name_long"=>$data->results[0]->address_components[3]->long_name,
		"city_name_short"=>$data->results[0]->address_components[3]->short_name,
		"county_name_long"=>$data->results[0]->address_components[4]->long_name,
		"county_name_short"=>$data->results[0]->address_components[4]->short_name,
		"state_name_long"=>$data->results[0]->address_components[5]->long_name,
		"state_name_short"=>$data->results[0]->address_components[5]->short_name,
		"country_name_long"=>$data->results[0]->address_components[6]->long_name,
		"country_name_short"=>$data->results[0]->address_components[6]->short_name,
		"zipcode_long"=>$data->results[0]->address_components[7]->long_name,
		"zipcode_short"=>$data->results[0]->address_components[7]->short_name,
		"zipcode_ext_long"=>$data->results[0]->address_components[8]->long_name,
		"zipcode_ext_short"=>$data->results[0]->address_components[8]->short_name
	);
	return ($status=="OK" ? $address : false);
}
function AddressToPoints($address){
	$prepAddr = str_replace(' ','+',$address);
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	return ($latitude.", ".$longitude);
}
/**
 *    Given an origin point of (0,0) and a destination point $x,$y
 *  somewhere on an axis grid, compass() determines the compass
 *  heading(direction) of the destination point from the origin
 *
 *  HOWEVER, atan2(y,x)'s natural compass thinks east is north,
 *
 *  {135}-------{ 90}-------{45}
 *      | +-----[ +y]-----+ |
 *      | |               | |
 *      | |               | |
 *  {180} [-x]  [0,0]  [+x] {0} <--------- North ?
 *      | |               | |
 *      | |               | |
 *      | +-----[ -y]-----+ |
 * {-135}-------{-90}-------{-45}
 *
 *
 *    SO, we simply transpose the (y,x) parameters to atan2(x,y)
 *     which will both rotate(left) and reflect(mirror) the compass.
 *
 *  Which gives us this compass
 *
 *  {-45}-------{ 0 }-------{45}
 *      | +-----[ +y]-----+ |
 *      | |               | |
 *      | |               | |
 *  {-90} [-x]  [0,0]  [+x] {90}
 *      | |               | |
 *      | |               | |
 *      | +-----[ -y]-----+ |
 * {-135}-------{180}-------{135}
 *
 *  FINALLY,` we check if param $x was indeed a negative number,
 *  if so we simply add 360 to the negative angle returned by atan2()
 *
 */
function compass($x,$y) {
	if($x==0 AND $y==0) return 0;
	return ($x < 0) ? rad2deg(atan2($x,$y))+360	: rad2deg(atan2($x,$y));
}
function polar($x,$y) {
	$N = ($y>0)?'N':'';
	$S = ($y<0)?'S':'';
	$E = ($x>0)?'E':'';
	$W = ($x<0)?'W':'';
	return $N.$S.$E.$W;
}
function show_compass($x,$y) {
	return polar($x,$y).' compass( x='.$x.', y='.$y.' )= '.number_format(compass($x,$y),3).'&deg';
}
function get_degree($x, $y) {
	if($x == 0) $x = 1 / 10000;
	$deg = rad2deg(atan(abs($y / $x)));
	if($y >= 0) $deg = $x < 0 ? 180 - $deg : $deg;
	else        $deg = $x < 0 ? 180 + $deg : 360 - $deg;
	return $deg;
}

# DATE FUNCTIONS
function isvaliddate($date, $format = 'Y-m-d H:i:s') {
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}
function days_month($month, $year = 'NaN') {
	if ($year == 'NaN') $year = date('Y');
	if (!is_whole_number($month)){
		$months = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec', 'january', 'february', 'march', 'april', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
		$month_arr = date_parse(wordMatch($months, strtolower($month), 2));
		$month = $month_arr['month'];
	}
	$return = ($month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year %400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31));
	return $return;
}
function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()) {
	$first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
	$day_names = array();
	for ($n=0, $t=(3+$first_day)*86400; $n<7; $n++, $t+=86400)
		$day_names[$n] = ucfirst(gmstrftime('%A',$t));

	list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));
	$weekday = ($weekday + 7 - $first_day) % 7;
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;

	@list($p, $pl) = each($pn);
	@list($n, $nl) = each($pn);

	if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
	if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';

	$calendar = '<table class="calendar">'."\n".'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

	if($day_name_length) {
		foreach($day_names as $d)
			$calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';

		$calendar .= "</tr>\n<tr>";
	}

	if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>';
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++) {
		if($weekday == 7) {
			$weekday   = 0;
			$calendar .= "</tr>\n<tr>";
		}

		if(isset($days[$day]) and is_array($days[$day])) {
			@list($link, $classes, $content) = $days[$day];
			if(is_null($content))  $content  = $day;

			$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
		}
		else $calendar .= "<td>$day</td>";
	}

	if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>';

	return $calendar."</tr>\n</table>\n";
}
function minutestohours($minutes) {
	return ($minutes > 0 ? sprintf('%02d:%02d', floor($minutes/60), floor($minutes%60)) : 'invalid time');
}
function _ago($tm, $rcs = 0) {
	$cur_tm = time();
	$dif = $cur_tm-$tm;
	$pds = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
	$lngh = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
	for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--);
	if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

	$no = floor($no);
	if($no <> 1) $pds[$v] .='s';
	$x = sprintf("%d %s ", $no, $pds[$v]);
	if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
	return $x;
}
function remainingTime($time){
	$rem = strtotime($time) - time();
	$year = floor($rem / 31536000);
	$month = floor(($rem % 31536000) / 2628000);
	$week = floor(($rem % 2628000) / 604800);
	$day = floor(($rem % 604800) / 86400);
	$hr  = floor(($rem % 86400) / 3600);
	$min = floor(($rem % 3600) / 60);
	$sec = ($rem % 60);
	$output = '';
	if($year) $output .= $year.pluralize($year, ' year ', ' years ');
	if($month) $output .= $month.pluralize($month, ' month ', ' months ');
	if($week) $output .= $week.pluralize($week, ' week ', ' weeks ');
	if($day) $output .= $day.pluralize($day, ' day ', ' days ');
	if($hr) $output .= $hr.pluralize($hr, ' hour ', ' hours ');
	if($min) $output .= $min.pluralize($min, ' minute ', ' minutes ');
	if($sec) $output .= $sec.pluralize($sec, ' second ', ' seconds ');
	$output .= "remaining ";
	return $output;
}
function secstostr($secs) {
	if($secs >= 86400) {
		$days = floor($secs / 86400);
		$secs = $secs % 86400;
		$r = $days.pluralize($days, ' day', ' days');
	}
	if($secs >= 3600) {
		$r = (isset($r) ? $r : '');
		$hours = floor($secs/3600);
		$secs = $secs % 3600;
		$r .= $hours.pluralize($hours, ' hour', ' hours');
	}
	if($secs >= 60) {
		$r = (isset($r) ? $r : '');
		$minutes = floor($secs/60);
		$secs = $secs % 60;
		$r .= $minutes.pluralize($minutes, ' minute', ' minutes');
	}
	$r = (isset($r) ? $r : '');
	$r .= $secs.pluralize($secs, ' second', ' seconds');
	return $r;
}

# STRING FUNCTIONS
function string_continue($text, $len=80) {
	$string = (strlen($text) > $len ? preg_replace('/[\s\.,][^\s\.,]*$/u', '', substr($text, 0, $len-3)).'...' : $text);
	return $string;
}
function string_trim($text, $count){
	$trimed = '';
	$count = $count - 1;
	$string = explode(" ", str_replace("  ", " ", $text));
	if ($count > count($string)) SysError ('warning', 'Using string_trim has a count of more then the number of words', '101');
	for ($wordCounter = 0; $wordCounter <= $count; $wordCounter++ ){
		$trimed .= $string[$wordCounter];
		if ($wordCounter < $count) $trimed .= " ";
		else {
			if (substr($trimed, '-1') == ","){
				$trimed = substr($trimed, '0', '-1');
			}
			$trimed .= "...";
		}
	}
	return trim($trimed);
}
function string_mid_trim($string, $max = 50, $rep = '[...]') {
	$strlen = strlen($string);

	if ($strlen <= $max)
		return $string;

	$lengthtokeep = $max - strlen($rep);
	$start = 0;
	$end = 0;

	if (($lengthtokeep % 2) == 0) {
		$start = $lengthtokeep / 2;
		$end = $start;
	} else {
		$start = intval($lengthtokeep / 2);
		$end = $start + 1;
	}

	$i = $start;
	$tmp_string = $string;
	while ($i < $strlen) {
		if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
			$tmp_string = substr($tmp_string, 0, $i) . $rep;
			$return = $tmp_string;
		}
		$i++;
	}

	$i = $end;
	$tmp_string = strrev ($string);
	while ($i < $strlen) {
		if (isset($tmp_string[$i]) and $tmp_string[$i] == ' ') {
			$tmp_string = substr($tmp_string, 0, $i);
			$return .= strrev ($tmp_string);
		}
		$i++;
	}
	return $return;
	return substr($string, 0, $start) . $rep . substr($string, - $end);
}
function random_passwd($len = 10, $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
	$string = '';
	$pool = $char;
	for($i = 1; $i <= $len; $i ++) {
		$string .= substr($pool, rand(0, strlen($char)-1), 1);
	}
	return $string;
}
function pluralize($quantity, $singular, $plural) {
	if ($quantity == 1 || !strlen($singular)) return $singular;
	if ($plural !== null) return $plural;
}
function makeLink($text, $label=NULL) {
	if ($label==NULL){
		$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)','<a href="\1">\1</a>', $text);
		$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)','\1<a href="http://\2">\2</a>', $text);
		$text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})','<a href="mailto:\1">\1</a>', $text);
		return $text;
	} else {
		$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)','<a href="\1">'.$label.'</a>', $text);
		$text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)','\1<a href="http://\2">'.$label.'</a>', $text);
		$text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})','<a href="mailto:\1">'.$label.'</a>', $text);
		return $text;
	}
}
function getCloud($data = array(), $minFontSize = 12, $maxFontSize = 30){
	$minimumCount = min($data);
	$maximumCount = max($data);
	$spread       = $maximumCount - $minimumCount;
	$cloudHTML    = '';
	$cloudTags    = array();
	$spread == 0 && $spread = 1;
	foreach($data as $tag => $count) {
		$size = $minFontSize + ($count - $minimumCount) * ( $maxFontSize - $minFontSize ) / $spread;
		$size = $size.'px';
		$cloudTags[] = '<a style="font-size: '.floor( $size ).'" class="tag_cloud" href="#" title="\''.$tag.'\' returned a count of '.$count.'">'.htmlspecialchars(stripslashes($tag)).'</a>';
	}
	return join( "\n", $cloudTags ) . "\n";
}
function isemail($email, $test_mx = false){
	if(preg_match("^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+)(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$", $email))
		if ($test_mx) {
			list($username, $domain) = explode("@", $email);
			return getmxrr($domain, $mxrecords);
		}
		else return true;
	else return false;
}
function encode_email($email='info@domain.com', $linkText='Contact Us', $attrs ='class="emailencoder"'){
	$email = str_replace('@', '&#64;', $email);
	$email = str_replace('.', '&#46;', $email);
	$email = str_split($email, 5);

	$linkText = str_replace('@', '&#64;', $linkText);
	$linkText = str_replace('.', '&#46;', $linkText);
	$linkText = str_split($linkText, 5);

	$part1 = '<a href="ma';
	$part2 = 'ilto&#58;';
	$part3 = '" '. $attrs .' >';
	$part4 = '</a>';

	$encoded = '<script type="text/javascript">';
	$encoded .= "document.write('$part1');";
	$encoded .= "document.write('$part2');";
	foreach($email as $e) $encoded .= "document.write('$e');";

	$encoded .= "document.write('$part3');";
	foreach($linkText as $l) $encoded .= "document.write('$l');";

	$encoded .= "document.write('$part4');";
	$encoded .= '</script>';

	return $encoded;
}
function highlighter_text($text, $words) {
	$fontcolor = "#4285F4";

	preg_match_all('~\w+~', $words, $m);
	if(!$m) return $text;
	$re = '~\\b(' . implode('|', $m[0]) . ')\\b~';
	return preg_replace($re, '<span style="color:'.$fontcolor.';font-weight: 700;">$0</span>', $text);
}
function qr_code($data, $type = "TXT", $size ='150', $ec='L', $margin='0') {
	$types = array('URL', 'EMAIL', 'TEL', 'MECARD', 'VCARD', 'SMS', 'MMS', 'GEO', 'PLAY', 'WIFI', 'YOUTUBE', 'FACEBOOK', 'TWITTER', 'INSTAGRAM', 'TXT');
	$errorimg = '';

	if (in_array(strtoupper($type), $types)){
		switch(strtoupper($type)){
			case 'URL':{
				$data = (preg_match('/^http:\/\//', $data) || preg_match('/^https:\/\//', $data) ? $data : 'http://'.$data);
				break;
			}
			case 'EMAIL':{
				$data = (preg_match('/^mailto:/', $data) ? $data : 'mailto:'.$data);
				break;
			}
			case 'TEL':{
				$data = (preg_match('/^tel:/', $data) ? $data : 'tel:'.$data);
				break;
			}
			case 'MECARD':{
				if (is_array($data)){

				} else {
					return $errorimg;
				}
				break;
			}
			case 'VCARD':{
				if (is_array($data)){
					$data = 'BEGIN:VCARD'."\n".'VERSION:3.0'."\n".'N:'.$data[0]." ".$data[1]."\n".'ORG:'.$data[2]."\n".'TITLE:'.$data[3]."\n".'TEL:'.$data[4]."\n".'URL:'.$data[5]."\n".'EMAIL:'.$data[6]."\n".'ADR:'.$data[7]."\n".'NOTE:'.$data[8]."\n"."END:VCARD";
				} else {
					return $errorimg;
				}
				break;
			}
			case 'CAL':{
				if (is_array($data)){
					$data = 'BEGIN:VEVENT'."\n".'VERSION:3.0'."\n".'SUMMARY:'.$data[0]."\n".'DTSTART:'.$data[2]."\n".'DTEND:'.$data[4]."\n".'LOCATION:'.$data[3]."\n".'DESCRIPTION:'.$data[5]."\n"."END:VEVENT";
					/*
						BEGIN:VEVENT
						SUMMARY:Test
						DTSTART:20170219T230000Z
						DTEND:20170221T030000Z
						LOCATION:Visalia, California
						DESCRIPTION:Meeting with someone
						END:VEVENT
					*/
				} else {
					return $errorimg;
				}
				break;
			}
			case 'SMS':{
				if (is_array($data)){
					$data = 'smsto:'.$data[0].':'.$data[1];
				} else {
					return $errorimg;
				}
				break;
			}
			case 'MMS':{
				if (is_array($data)){
					$data = 'mmsto:'.$data[0].':'.$data[1];
				} else {
					return $errorimg;
				}
				break;
			}
			case 'GEO':{
				if (is_array($data)){

				} else {
					return $errorimg;
				}
				break;
			}
			case 'WIFI':{
				if (is_array($data)){

				} else {
					return $errorimg;
				}
				break;
			}
			case 'PLAY':{
				if (is_array($data)){

				} else {
					return $errorimg;
				}
				break;
			}
			case 'YOUTUBE':{
				$data = (preg_match('/^youtube:/', $data) ? 'https://www.youtube.com/watch?v='.preg_replace("/^youtube:/i", '', $data) : 'https://www.youtube.com/watch?v='.$data);
				break;
			}
			case 'FACEBOOK':{
				$data = (preg_match('/^facebook:/', $data) ? 'https://www.facebook.com/'.preg_replace("/^facebook:/i", '', $data) : 'https://www.facebook.com/'.$data);
				break;
			}
			case 'TWITTER':{
				$data = (preg_match('/^twitter:/', $data) ? 'https://www.twitter.com/'.preg_replace("/^twitter:/i", '', $data) : 'https://www.twitter.com/'.$data);
				break;
			}
			case 'INSTAGRAM':{
				$data = (preg_match('/^instagram:/', $data) ? 'https://www.instagram.com/watch?v='.preg_replace("/^instagram:/i", '', $data) : 'https://www.instagram.com/'.$data);
				break;
			}
			case 'TXT':{
				if (is_array($data)){

				} else {
					return $errorimg;
				}
				break;
			}
		}
	}
	#$types = array("URL" => "http://", "TEL" => "TEL:", "TXT"=>"", "EMAIL" => "MAILTO:");
	#if(!in_array($type, array("URL", "TEL", "TXT", "EMAIL"))) {
	#    $type = "TXT";
	#}
	#if (!preg_match('/^'.$types[$type].'/', $data)) {
	#    $data = str_replace("\\", "", $types[$type]).$data;
	#}

	$data = urlencode($data);
	$response = 'http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&chld='.$ec.'|'.$margin.'&chl='.$data;
	return $response;
}
function wordMatch($words, $input, $sensitivity) {
	$shortest = -1;
	foreach ($words as $word) {
		$lev = levenshtein($input, $word);
		if ($lev == 0) {
			$closest = $word;
			$shortest = 0;
			break;
		}
		if ($lev <= $shortest || $shortest < 0) {
			$closest  = $word;
			$shortest = $lev;
		}
	}
	if($shortest <= $sensitivity){
		return $closest;
	} else {
		return 0;
	}
}

# SYSTEM FUNCTIONS
function getIP(){
	$bestIP = '';
	$bestLocalIP = '';
	$ipvars = array('HTTP_X_FORWARDED_FOR','HTTP_NS_CLIENT_IP','HTTP_CLIENT_IP','REMOTE_ADDR');
	foreach($ipvars as $ipvar){
		$ip = isset($_SERVER[$ipvar]) ? $_SERVER[$ipvar] : null;
		if($ip && stripos($ip,'unknown')!==0 && strpos($ip,'127.')!==0 && strpos($ip,'10.')!==0 && strpos($ip,'172.16.')!==0 && strpos($ip,'192.168.')!==0 && stripos($ip,'localhost')!==0){
			$bestIP = $bestIP=='' ? $ip : $bestIP;
		} elseif($ip && (strpos($ip,'127.')===0 || strpos($ip,'10.')===0 || strpos($ip,'172.16.')===0 || strpos($ip,'192.168.')===0 || stripos($ip,'localhost')===0)){
			$bestLocalIP = $bestLocalIP=='' ? $ip : $bestLocalIP;
		}
	}

	$ip = ($bestIP != '' ? $bestIP : ($bestLocalIP != '' ? $bestLocalIP : 'unknown'));
	return $ip;
}
function zip($files = array(), $destination = '', $overwrite = false){
	if(file_exists($destination) && !$overwrite) return false;

	$valid_files = array();

	if(is_array($files)) {
		foreach($files as $file) if(file_exists($file)) $valid_files[] = $file;
	}

	if(count($valid_files)) {
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}

		foreach($valid_files as $file) $zip->addFile($file,$file);

		$zip->close();

		return file_exists($destination);
	}
	else return false;
}
function unzip($file, $destination){
	$zip = new ZipArchive() ;
	if ($zip->open($file) !== TRUE) die ("Could not open archive");
	$zip->extractTo($destination);
	$zip->close();
	echo 'Archive extracted to directory';
}
function get_client_language($availableLanguages, $default='en'){
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$langs=explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

		foreach ($langs as $value){
			$choice=substr($value,0,2);
			if(in_array($choice, $availableLanguages)){
				return $choice;
			}
		}
	}
	return $default;
}
function strip_xss($val) {
	$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for ($i = 0; $i < strlen($search); $i++) {
		$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
		$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
	}

	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);

	$found = true;
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(&#0{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
			$val = preg_replace($pattern, $replacement, $val);
			if ($val_before == $val) {
				$found = false;
			}
		}
	}
	return $val;
}
function safe_redirect($url, $exit=true) {

	// Only use the header redirection if headers are not already sent
	if (!headers_sent()){

		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $url);

		// Optional workaround for an IE bug (thanks Olav)
		header("Connection: close");
	}

	// HTML/JS Fallback:
	// If the header redirection did not work, try to use various methods other methods

	print '<html>';
	print '<head><title>Redirecting you...</title>';
	print '<meta http-equiv="Refresh" content="0;url='.$url.'" />';
	print '</head>';
	print '<body onload="location.replace(\''.$url.'\')">';

	// If the javascript and meta redirect did not work,
	// the user can still click this link
	print 'You should be redirected to this URL:<br />';
	print "<a href=".$url.">$url</a><br /><br />";

	print 'If you are not, please click on the link above.<br />';

	print '</body>';
	print '</html>';

	// Stop the script here (optional)
	if ($exit) exit;
}
function autoglobals(){
	$ArrayList = array("_POST", "_GET", "_SESSION", "_COOKIE", "_SERVER"); // create an array of the autoglobal arrays we want to process
	foreach ($ArrayList as $gblArray) {
		$prefx = strtolower(substr($gblArray,1,3))."_"; // derive the prepend string

		// from the autoglobal type name
		$tmpArray = $$gblArray;
		$keys = array_keys($tmpArray); // extract the keys from the array being processed
		foreach($keys as $key) {
			$arcnt = count($tmpArray[$key]);
			if ($arcnt > 1) {
				// Break down passed arrays and
				// process each element seperately
				$lcount = 0;
				foreach ($tmpArray[$key] as $dval) {
					$prkey = $prefx.$key; // create a new key string
					// with the prepend string added
					$prdata['$prkey'] = $dval; // this step could be eliminated
					${$prkey}[$lcount] = $prdata['$prkey']; //create new key and insert the data
					$lcount++;
				}
			} else { // process passed single variables
				$prkey = $prefx.$key; // create a new key string

				// with the prepend string added
				$prdata['$prkey'] = $tmpArray[$key]; // insert the data from
				// the old array into the new one
				$$prkey = $prdata['$prkey']; // create the newly named
				// (prepended) key pair using variable variables :-)
			}
		}
	}
}
function hitcounter(){
	$filename = DATADIR.DS.'count.log';
	$data = fopen($filename,"w+");
	$count = fgets($data,1000);
	fclose($data);
	$count = $count + 1;
	$data = fopen($filename,"w");
	fwrite($data, $count);
	fclose($data);
	return $count;
}
function convBase($numberInput, $fromBaseInput, $toBaseInput) {
	if ($fromBaseInput==$toBaseInput) return $numberInput;
	$fromBase = str_split($fromBaseInput,1);
	$toBase = str_split($toBaseInput,1);
	$number = str_split($numberInput,1);
	$fromLen=strlen($fromBaseInput);
	$toLen=strlen($toBaseInput);
	$numberLen=strlen($numberInput);
	$retval='';
	if ($toBaseInput == '0123456789')
	{
		$retval=0;
		for ($i = 1;$i <= $numberLen; $i++)
			$retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
		return $retval;
	}
	if ($fromBaseInput != '0123456789')
		$base10=convBase($numberInput, $fromBaseInput, '0123456789');
	else
		$base10 = $numberInput;
	if ($base10<strlen($toBaseInput))
		return $toBase[$base10];
	while($base10 != '0')
	{
		$retval = $toBase[bcmod($base10,$toLen)].$retval;
		$base10 = bcdiv($base10,$toLen,0);
	}
	return $retval;
}

# IMAGE FUNCTIONS
function resize_image($filename, $tmpname, $xmax, $ymax){
	$ext = explode(".", $filename);
	$ext = $ext[count($ext)-1];

	if($ext == "jpg" || $ext == "jpeg")
		$im = imagecreatefromjpeg($tmpname);
	elseif($ext == "png")
		$im = imagecreatefrompng($tmpname);
	elseif($ext == "gif")
		$im = imagecreatefromgif($tmpname);

	$x = imagesx($im);
	$y = imagesy($im);

	if($x <= $xmax && $y <= $ymax)
		return $im;

	if($x >= $y) {
		$newx = $xmax;
		$newy = $newx * $y / $x;
	}
	else {
		$newy = $ymax;
		$newx = $x / $y * $newy;
	}

	$im2 = imagecreatetruecolor($newx, $newy);
	imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);
	return $im2;
}
function show_gravatar($email, $size, $default, $rating){
	return '<img src="http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).'&default='.$default.'&size='.$size.'&rating='.$rating.'" width="'.$size.'px" height="'.$size.'px" />';
}
function Hex2RGB($color){
	$color = str_replace('#', '', $color);
	if (strlen($color) != 6){ return array(0,0,0); }
	$rgb = array();
	for ($x=0;$x<3;$x++){
		$rgb[$x] = hexdec(substr($color,(2*$x),2));
	}
	return $rgb;
}

# ARRAY FUNCTIONS
function values2keys($arr, $value=1){
	$new = array();
	while (list($k,$v) = each($arr)){
		$v = trim($v);
		if ($v != ''){
			$new[$v] = $value;
		}
	}
	return $new;
}
function strReplaceAssoc(array $replace, $subject) {
	return str_replace(array_keys($replace), array_values($replace), $subject);
}
function is_numeric_array($array) {
	foreach ($array as $key => $value)
		if (!is_numeric($value)) return false;
		else return true;
}
function array_changecase($array, $case = 'lower'){
	return array_change_key_case($array, ($case == 'upper') ? CASE_UPPER : CASE_LOWER);
}

# DATABASE FUNCTIONS
function SQLclean($input) {
	if (is_array($input)) {
		foreach ($input as $key => $val) {
			$output[$key] = clean($val);
			// $output[$key] = $this->clean($val);
		}
	}
	else {
		$output = (string) $input;
		if (get_magic_quotes_gpc()) {
			$output = stripslashes($output);
		}
		// $output = strip_tags($output);
		$output = htmlentities($output, ENT_QUOTES, 'UTF-8');
	}
	// return the clean text
	return $output;
}
