<?php
	require("bin/fw.php");
	define('N', "\n");
	define('BR', "<br />");
	define('BRN', "<br />\n");

# plg_visitor
	#echo "There has been ".hitcounter ()." ".pluralize (hitcounter (), 'hit', 'hits')." to this site. You are using ".browserName." ver ".browserVer." on ".platformFamily." ".(is64bit ? "64 bit" : "32 bit")." from ".getIP().BRN;

# plg_dump
	#$arr = array("Defined Variables"=>get_defined_vars(), "Defined Constants"=>get_defined_constants());
	#echo dump($arr, TRUE, TRUE).BRN;

# plg_system
	echo 'Framework Functions:'.BRN;
	echo 'Numeric Functions:'.BR.BRN;
	echo 'echo clean_number(\'4f32k91025\'); <span style="color: orange; font-style: italic"># will output '.clean_number('4f32k91025').'</span>'.BRN;
	echo 'echo decimal_to_fraction(0.125); <span style="color: orange; font-style: italic"># will output '.decimal_to_fraction (0.125).'</span>'.BRN;
	echo 'echo fraction_to_decimal(\'1/8\'); <span style="color: orange; font-style: italic"># will output '.fraction_to_decimal ('1/8').'</span>'.BRN;
	echo 'echo (is_whole_number(45) ? "TRUE" : "FALSE"); <span style="color: orange; font-style: italic"># will output '.(is_whole_number (45) ? "TRUE" : "FALSE").'</span>'.BRN;
	echo 'echo return_whole_number(45.34); <span style="color: orange; font-style: italic"># will output '.return_whole_number (45.34).'</span>'.BRN;
	echo 'echo return_decimal_number(45.34); <span style="color: orange; font-style: italic"># will output '.return_decimal_number (45.34).'</span>'.BRN;
	echo 'echo ordinalize(3); <span style="color: orange; font-style: italic"># will output '.ordinalize (3).'</span>'.BRN;
	echo 'echo parity(3); <span style="color: orange; font-style: italic"># will output '.parity (3).'</span>'.BRN;
	echo BR.BRN;
	echo 'Address Functions:'.BR.BRN;
	echo 'echo getDistanceBetweenPoints(39.103119, -84.512016, 36.850769, -76.285873); <span style="color: orange; font-style: italic"># Example is Cincinnati, OH to Norfolk, VA -- will output Array</span>'.BRN;
	print_r(getDistanceBetweenPoints (39.103119, -84.512016,  36.850769, -76.285873));
	echo BR.BRN;
	echo 'echo getAddressFromPoints (39.103119, -84.512016)<span style="color: orange; font-style: italic"># Example is Cincinnati, OH -- will output Array</span>'.BRN;
	print_r(getAddressFromPoints (39.103119, -84.512016));
	echo BR.BRN;
	echo 'echo AddressToPoints (\'10 Fountain Square, Cincinnati, OH 45202\')<span style="color: orange; font-style: italic"># will output '.AddressToPoints ('10 Fountain Square, Cincinnati, OH 45202').'</span>'.BRN;
	echo BR.BRN;
	echo 'Date Functions:'.BR.BRN;
	echo 'echo days_month(\'2\', \'2014\');<span style="color: orange; font-style: italic;"># will output '.days_month('2', '2014').'</span>'.BR;
	echo 'echo generate_calendar(\'2017\', \'01\');<span style="color: orange; font-style: italic;"># will output '.BRN.generate_calendar('2017', '01').'</span>'.BR;
	echo 'echo minutestohours(494);<span style="color: orange; font-style: italic;"># will output '.minutestohours(494).'</span>'.BR;
	echo 'echo _ago(45);<span style="color: orange; font-style: italic;"># will output '._ago(45).'</span>'.BR;
	echo 'echo remainingTime(date(\'Y-m-d\', strtotime(\'+5 years +4 month +2 weeks +5 days +18 hours +43 minutes +31 seconds\')));<span style="color: orange; font-style: italic;"># will output '.remainingTime(date('Y-m-d', strtotime('+5 years +4 month +2 weeks +5 days +18 hours +43 minutes +31 seconds'))).'</span>'.BR;
	echo 'echo secstostr(269);<span style="color: orange; font-style: italic;"># will output '.secstostr(269).'</span>'.BR;
	echo BR.BRN;
	echo 'String Functions:'.BR.BRN;
	echo 'echo string_continue(\'Today is the day for all good men to come to the aid of their country.\', 30);<span style="color: orange; font-style: italic;"># will output '.string_continue('Today is the day for all good men to come to the aid of their country.', 30).'</span>'.BR;
	echo 'echo string_trim(\'Today is the day for all good men to come to the aid of their country.\', 5);<span style="color: orange; font-style: italic;"># will output '.string_trim('Today is the day for all good men to come to the aid of their country.', 5).'</span>'.BR;
	echo 'echo string_mid_trim(\'Today is the day for all good men to come to the aid of their country.\', 30);<span style="color: orange; font-style: italic;"># will output '.string_mid_trim('Today is the day for all good men to come to the aid of their country.', 30).'</span>'.BR;
	echo 'echo random_passwd(12);<span style="color: orange; font-style: italic;"># will output '.random_passwd(12).'</span>'.BR;
	echo 'echo pluralize(3, \'box\', \'boxes\');<span style="color: orange; font-style: italic;"># will output '.pluralize(3, 'box', 'boxes').'</span>'.BR;
	echo 'echo makeLink(\'JBrowns\', \'JBrowns\');<span style="color: orange; font-style: italic;"># will output '.makeLink('JBrowns', 'JBrowns').'</span>'.BR;
	echo 'echo getCloud(array(\'PHP\', \'Framework\', \'GitHub\', \'JBrowns.com\', \'Diablos\', \'NEAT\'));<span style="color: orange; font-style: italic;"># will output '.getCloud(array('PHP', 'Framework', 'GitHub', 'JBrowns.com', 'Diablos', 'NEAT')).'</span>'.BR;
	echo 'echo isemail(\'jessica@jbrowns.com\');<span style="color: orange; font-style: italic;"># will output '.isemail('jessica@jbrowns.com').'</span>'.BR;
	echo 'echo encode_email(\'jessica@jbrowns.com\');<span style="color: orange; font-style: italic;"># will output '.encode_email('jessica@jbrowns.com').'</span>'.BR;
	echo 'echo highlighter_text(\'Today is the day for all good men to come to the aid of their country\', \'good men\');<span style="color: orange; font-style: italic;"># will output '.highlighter_text('Today is the day for all good men to come to the aid of their country', 'good men').'</span>'.BR;
	echo 'echo qr_code(\'http://www.jbrowns.com\');<span style="color: orange; font-style: italic;"># will output '.qr_code('http://www.jbrowns.com').'</span>'.BR;
	echo 'echo wordMatch(\'hello, today, aid\', \'Today is the day for all good men to come to the aid of their country.\', \'2\');<span style="color: orange; font-style: italic;"># will output '.wordMatch('hello, today, aid', 'Today is the day for all good men to come to the aid of their country.', '2').'</span>'.BR;

