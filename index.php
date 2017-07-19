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
	echo days_month('2', '2014').BR;
	echo generate_calendar('2017', '01').BR;
	echo minutestohours(494).BR;
	echo _ago(45).BR;
	echo remainingTime(date('Y-m-d', strtotime('+5 years +4 month +2 weeks +5 days +18 hours +43 minutes +31 seconds'))).BR;
	echo secstostr(269).BR;
	echo BR.BRN;
	echo 'String Functions:'.BR.BRN;
	echo string_continue('Today is the day for all good men to come to the aid of their country.', 30).BR;
	echo string_trim('Today is the day for all good men to come to the aid of their country.', 5).BR;
	echo string_mid_trim('Today is the day for all good men to come to the aid of their country.', 30).BR;
	echo random_passwd(12).BR;
	echo pluralize(3, 'box', 'boxes').BR;
	echo makeLink('JBrowns', 'JBrowns').BR;
	echo getCloud(array('PHP', 'Framework', 'GitHub', 'JBrowns.com', 'Diablos', 'NEAT')).BR;
	echo isemail('jessica@jbrowns.com').BR;
	echo encode_email('jessica@jbrowns.com').BR;
	echo highlighter_text('Today is the day for all good men to come to the aid of their country', 'good men').BR;
	echo qr_code('http://www.jbrowns.com').BR;
	echo wordMatch('hello, today, aid', 'Today is the day for all good men to come to the aid of their country.', '2').BR;

