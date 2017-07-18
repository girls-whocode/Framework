<?php
	defined('SITEKEY') or die('Direct access to this file is not allowed.');
	function dump(&$var, $autohide = TRUE, $collaspe = TRUE) {
		$format = array('N'=>"\n", 'T'=>"\t", 'BR'=>"<br />", 'BRN'=>"<br />\n");
		$css  = ".content-wrapper {font-family:Verdana, Arial; font-size:12px; width: 100%; list-style:none; margin:0; padding:0; outline:0; text-decoration:none; box-sizing:border-box!important; -webkit-box-sizing:border-box!important;-moz-box-sizing:border-box!important;-ms-box-sizing:border-box!important}";
		$css .= ".dumpnotify{font-family:Verdana; font-size:12px; -webkit-border-radius:5px; -moz-border-radius:3px; border-radius:3px; border:1px solid #000; width:97%; margin:15px; display: block; position: static;}";
		$css .= "div.dumpnotify .content-wrapper, div.dumpnotify .header-wrapper{font-family:Verdana; -moz-box-shadow:inset 0 2px 0 -1px rgba(255,255,255,.2); -webkit-box-shadow:inset 0 2px 0 -1px rgba(255,255,255,.2); box-shadow:inset 0 2px 0 -1px rgba(255,255,255,.2)}";
		$css .= "div.dumpnotify .header-wrapper{font-family:Verdana; width:100%; display:table; border-bottom:1px solid #000; background:#464646; background:-moz-linear-gradient(top,#464646 0,#3f3f3f 50%,#3f3f3f 51%,#3d3d3d 100%); background:-webkit-gradient(linear,left top,left bottom,color-stop(0,#464646),color-stop(50%,#3f3f3f),color-stop(51%,#3f3f3f),color-stop(100%,#3d3d3d));background:-webkit-linear-gradient(top,#464646 0,#3f3f3f 50%,#3f3f3f 51%,#3d3d3d 100%);background:-o-linear-gradient(top,#464646 0,#3f3f3f 50%,#3f3f3f 51%,#3d3d3d 100%);background:-ms-linear-gradient(top,#464646 0,#3f3f3f 50%,#3f3f3f 51%,#3d3d3d 100%);background:linear-gradient(to bottom,#464646 0,#3f3f3f 50%,#3f3f3f 51%,#3d3d3d 100%);filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#464646', endColorstr='#3d3d3d', GradientType=0 )}";
		$css .= "div.dumpnotify .header-wrapper .title{font-family:Verdana; padding: 8px; font-size:18px; font-weight:100;color:#e6e6e6;float:left}div.notify .header-wrapper .notifications{font-family:verdana;font-size:13px;padding-left:30px;padding-top:2px;padding-bottom:2px;color:#e6e6e6;float:right}";
		$css .= "div.dumpnotify .content-wrapper{display:table; padding-left:15px; background-color:#84413B; width:100%} div.notify .content-wrapper .number{font-family:Helvetica; float:right; font-size:30pt; color:#fff; font-weight:500; background:#773d3d; padding:25px 15px; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; -moz-box-shadow:inset 0 1px 0 0 rgba(0,0,0,.3),inset 0 -1px 0 0 rgba(255,255,255,.3);-webkit-box-shadow:inset 0 1px 0 0 rgba(0,0,0,.3),inset 0 -1px 0 0 rgba(255,255,255,.3);box-shadow:inset 0 1px 0 0 rgba(0,0,0,.3),inset 0 -1px 0 0 rgba(255,255,255,.3)}";
		$css .= ".fa-user{color:#fff!important;font-size:4em;display:inline-block}.floatleft{float:left;padding:11px 6px;text-shadow:0 1px 1px #000;font-size:1em;color:#fff}.pdtop{padding-top:5px;line-height:18px}";
		$css .= ".toggle-box{display:none}.toggle-box+label{cursor:pointer;display:block;font-weight:700;line-height:16px;margin-top:5px;margin-bottom:5px}";
		$css .= ".toggle-box+label+div{display:none;margin-bottom:10px}.toggle-box+label::after{color:#FFF;font-weight:700;font-size: 12px;content:'...}'}";
		$css .= ".toggle-box:checked+label+div{display:block;-webkit-animation:fadein 2s;-moz-animation:fadein 2s;-ms-animation:fadein 2s;-o-animation:fadein 2s;animation:fadein 2s}";
		$css .= ".toggle-box+label:before{background-color:#4F5150;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;color:#FFF;content:\"+\";display:inline-block;font-weight:700;height:15px;line-height:15px;margin-right:5px;text-align:center;width:15px}";
		$css .= ".toggle-box:checked+label:before{content:\"-\"}.toggle-box:checked+label:after{content:\"    \"}.maindiv{display:block; background:#000; color:#FFF; font-family:Verdana; font-size:14px; line-height:13px; padding:5px 5px 5px 20px}";
		$css .= ".version{color:#FFF;font-family:Verdana;font-size:12px; line-height:10px;margin:0 0 10px;padding:5px}";
		$css .= "@keyframes fadein{from{opacity:0}to{opacity:1}}@-moz-keyframes fadein{from{opacity:0}to{opacity:1}}@-webkit-keyframes fadein{from{opacity:0}to{opacity:1}}@-ms-keyframes fadein{from{opacity:0}to{opacity:1}}@-o-keyframes fadein{from{opacity:0}to{opacity:1}}";
		$css .= ".dumpicon{font-family:Verdana; display: block;z-index:999999;position:static;}";

		if ($autohide) {
			$css .= ".diagdumpbox {font-family:Verdana; font-size:12px; text-align: left; position: fixed; top: 5px; left: 5px; width: 32px; height: 32px; z-index: 999999;}.diagdumpbutton {cursor: pointer;transition: all 0.3s ease-out;}";
			$css .= ".diagdumpoverlay {font-family:Verdana; font-size:12px; position: absolute; z-index: 9999; top: 0; bottom: 0; left: 0; right: 0; transition: opacity 500ms; visibility: hidden; opacity: 0; width: 100%} .diagdumpoverlay:target {visibility: visible;opacity: 1;}";
			$css .= ".diagdumppopup {font-family:Verdana; font-size:12px; margin: 70px auto; padding: 20px; background: #fff; border-radius: 5px; width: 50%; position: relative; transition: all 5s ease-in-out; -webkit-box-shadow: 0px 0px 12px 6px #444; -moz-box-shadow: 0px 0px 12px 6px #444; box-shadow: 0px 0px 12px 6px #444;}";
			$css .= ".diagdumppopup h2 {font-family:Verdana; font-size:12px; margin-top: 0;color: #333;font-family: Tahoma, Arial, sans-serif;}.diagdumppopup .close {position: absolute;top: 15px;right: 15px;transition: all 200ms;font-size: 25px;font-weight: bold;text-decoration: none;color: #333;background: #FFF;border: 1px solid black;border-radius: 25px;height: 27px;width: 27px;text-align: center;}.diagdumppopup .close:hover {color: #773d3d;}";
			$css .= ".diagdumppopup .content {font-family:Verdana; font-size:12px; max-height: 30%;overflow: auto;}@media screen and (max-width: 700px){.diagdumpbox{width: 70%;}.diagdumppopup{width: 70%;}}";
		}

		$output = $format['T'].'<style type="text/css">'.$format['N'].$css.$format['N'].$format['T'].'</style>'.$format['N'];
		$size = (function_exists('mb_strlen') ? mb_strlen(serialize($var), '8bit') : strlen(serialize($var)));
		$arrayCount = number_format(count($var, COUNT_RECURSIVE));
		$scope = false;
		$dumpver = "2.3.2";
		$prefix = 'unique';
		$suffix = 'value';
		$vals = ($scope ? $scope : $GLOBALS);
		$collaspe = ($collaspe == TRUE ? TRUE : FALSE);
		$old = $var;
		$var = $new = $prefix.rand().$suffix;
		$vname = FALSE;
		$unit = array('b','kb','mb','gb','tb','pb');
		$memusage = @round(memory_get_usage(TRUE)/pow(1024,($i=floor(log(memory_get_usage(TRUE),1024)))),2).' '.$unit[$i];
		$memory_limit = @round((ini_get('memory_limit')*1000000)/pow(1024,($i=floor(log((ini_get('memory_limit')*1000000),1024)))),2).' '.$unit[$i];
		$file_paths = debug_backtrace();

		foreach($vals as $key => $val) if($val === $new) $vname = $key;
		$var = $old;
		foreach($file_paths AS $file_path) {
			$fileCalled = basename($file_path['file']);
			$fileLineCalled = $file_path['line'];
		}
		if ($autohide) {
			$output .= '<div class="diagdumpbox">';
			$output .= '<a class="diagdumpbutton" href="#diagdumppopup1"><img width="32" height="32" alt="dump" class="dumpicon" src="data:image/png;base64,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" /></a>';
			$output .= '</div>';
			$output .= '<div id="diagdumppopup1" class="diagdumpoverlay">';
			$output .= '<div class="diagdumppopup">';
		}
		$info  = '<div class="dumpnotify"><div class="header-wrapper"><span class="title">Dump Information Panel<span class="version">ver '.$dumpver.'</span></span>'.($autohide ? '<a class="close" href="#">&times;</a>' : '').'</div>';
		$info .= '<div class="content-wrapper"><div class="floatleft pdtop">';
		$info .= 'Total Array Size: <strong>'.@round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i].'</strong>'.$format['BRN'];
		$info .= 'Total Array Elements: <strong>'.$arrayCount.'</strong>'.$format['BRN'];
		$info .= 'Memory Usage: <strong>'.$memusage.'</strong>'.$format['BRN'];
		$info .= 'Total Memory: <strong>'.$memory_limit.'</strong>'.$format['BRN'];
		$info .= 'Function Called: <strong>'.$fileCalled.'</strong><span style="font-size: 9px;"> (line :'.$fileLineCalled.')</span>'.$format['BRN'];
		$info .= 'Script\'s Current inode: <strong>'.getmyinode().'</strong>'.$format['BRN'];
		$info .= 'File\'s Last Modified: <strong>'.date("M d Y H:i:s", getlastmod()).'</strong>'.$format['BRN'];
		$info .= '</div>';
		$info .= '<div>';
		# $info .= '<span class="number">'.$arrayCount.'</span>';
		$info .= '</div>';
		$info .= '</div>';
		$output .= $format['T']."".$info."".$format['N'];
		$output .= $format['T']."<div class='maindiv'>".$format['N'];
		$output .= do_dump($var, '$'.$vname, NULL, 20, NULL, $collaspe);
		$output .= "</div></div>";
		if ($autohide) {
			$output .= "</div></div>";
		}
		return $output;
	}
	function do_dump(&$var, $var_name = NULL, $indent = NULL, $divpad = 20, $reference = NULL, $collaspe) {
		$format = array('N'=>"\n", 'T'=>"\t", 'BR'=>"<br />", 'BRN'=>"<br />\n");
		$reference = $reference.$var_name;
		$keyvar = 'the_do_dump_recursion_protection_scheme';
		$keyname = 'referenced_object_name';

		if (is_array($var) && isset($var[$keyvar])) {
			$real_var = &$var[$keyvar];
			$real_name = &$var[$keyname];
			$type = ucfirst(gettype($real_var));
			$output = $format['T'].$format['T'].$format['T']."$indent$var_name <span style='color:#a2a2a2; font-size: 12px;'>$type</span> = <span style='color:#e87800;'>&$real_name</span>".$format['N'];
		} else {
			$var = array($keyvar => $var, $keyname => $reference);
			$avar = &$var[$keyvar];
			$type = ucfirst(gettype($avar));
			if($type == "String") {
				$type_color = "<span style='color:green'>";
			}
			elseif($type == "Integer") {
				$type_color = "<span style='color:red'>";
			}
			elseif($type == "Double") {
				$type_color = "<span style='color:#0099c5'>";
				$type = "Float";
			}
			elseif($type == "Boolean") {
				$type_color = "<span style='color:#92008d'>";
			}
			elseif($type == "NULL") {
				$type_color = "<span style='color:black'>";
			}
			if (is_array($avar)) {
				$count = count($avar);
				$uuid = uniqid();
				$output = ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$var_name ? $format['T'].$format['T'].($collaspe == TRUE ? "<input class='toggle-box' id=\"$uuid\" type='checkbox' />".$format['N'].$format['T'].$format['T']."<label for=\"$uuid\">".$format['N'] : "").$format['T'].$format['T'].$format['T']."$var_name => " : "")."<span style='color:#a2a2a2; font-size: 9px;'>$type ($count) </span><span style='color: #FFF; font-size: 12px;font-weight: 700'> {</span>".($collaspe == TRUE ? "</label>" : "").$format['N'];
				$keys = array_keys($avar);
				$output .= $format['T'].$format['T'].'<div style="padding-left: '.$divpad.'px">'.$format['N'];
				foreach($keys as $name) {
					$value = &$avar[$name];
					$divpad = 20;
					$output .= do_dump($value, "['$name']", $indent, $divpad, $reference, $collaspe);
				}
				$output .= '<span style="color: #FFF;font-weight: 700">}</span>'.$format['N'];
				$output .= '</div>'.$format['N'];
			}
			elseif(is_object($avar)) {
				$output = $format['T'].$format['T'].$format['T']."$indent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name <span style='color:#a2a2a2; font-size: 12px;'>$type</span>".$format['N'].$format['T'].$format['T'].$format['T']."$indent(".$format['N'];
				$divpad = $divpad + 20;
				foreach($avar as $name=>$value) {
					$output .= do_dump($value, "$name", $indent, $divpad, $reference, $collaspe);
				}
				$output .= "$indent)".$format['N'];
			}
			elseif(is_int($avar)) {
				$output = $format['T'].$format['T'].$format['T'].$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name = <span style='color:#a2a2a2; font-size: 12px;'>$type(".strlen($avar).")</span> $type_color$avar</span>".$format['BRN'];
			}
			elseif(is_string($avar)) {
				$output = $format['T'].$format['T'].$format['T'].$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name = <span style='color:#a2a2a2; font-size: 12px;'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span>".$format['BRN'];
			}
			elseif(is_float($avar)) {
				$output = $format['T'].$format['T'].$format['T'].$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name = <span style='color:#a2a2a2; font-size: 12px;'>$type(".strlen($avar).")</span> $type_color$avar</span>".$format['BRN'];
			}
			elseif(is_bool($avar)) {
				$output = $format['T'].$format['T'].$format['T'].$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name = <span style='color:#a2a2a2; font-size: 12px;'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span>".$format['BRN'];
			}
			elseif(is_null($avar)) {
				$output = $format['T'].$format['T'].$format['T'].$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name = <span style='color:#a2a2a2; font-size: 12px;'>$type(".strlen($avar).")</span> {$type_color}NULL</span>".$format['BRN'];
			}
			else {
				$output = $format['T'].$format['T'].$format['T'].$indent."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$var_name = <span style='color:#a2a2a2; font-size: 12px;'>$type(".strlen($avar).")</span> $avar".$format['BRN'];
			}
			$var = $var[$keyvar];
		}
		return $output;
	}
