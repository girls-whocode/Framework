<?php
	require("bin/fw.php");

	echo "You are using ".browserName." ver ".browserVer." on ".platformFamily." ".(is64bit ? "64 bit" : "32 bit");
	$arr = array("Defined Variables"=>get_defined_vars(), "Defined Constants"=>get_defined_constants());
	echo dump($arr, TRUE, TRUE);

/*
	$arr = get_defined_vars();
	$const = get_defined_constants(true);
	highlight_string("<?php\n\$data =\n" . var_export($arr, true) . ";\n?>\n");
	highlight_string("<?php\n\$data =\n" . var_export($const['user'], true) . ";\n?>");
*/
