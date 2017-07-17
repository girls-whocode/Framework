<?php
	require("bin/fw.php");
	define('N', "\n");
	define('BR', "<br />");
	define('BRN', "<br />\n");

# plg_visitor
	echo "You are using ".browserName." ver ".browserVer." on ".platformFamily." ".(is64bit ? "64 bit" : "32 bit")." from ".getIP().BRN;

# plg_dump
	$arr = array("Defined Variables"=>get_defined_vars(), "Defined Constants"=>get_defined_constants());
	echo dump($arr, TRUE, TRUE).BRN;

# plg_system
	echo 'echo clean_number(\'4f32k91025\'); <span style="color: orange; font-style: italic"># will output '.clean_number('4f32k91025').'</span>'.BRN;
	echo 'echo decimal_to_fraction(\'.675\'); <span style="color: orange; font-style: italic"># will output </span>'.decimal_to_fraction ('.675').'</span>'.BRN;
