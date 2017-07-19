<?php
    $config = [
        "ENVIRONMENT"=>"DEVELOPMENT", # Options are DEVELOPMENT, DEBUG, PRODUCTION
        "DEFKEY"=>"upper", # Options are upper or lower
        "SITEKEY"=>"hdgjf6yehtrsbe5sgernys3ser674685tyudjfyty8tr6my5t6iunt6i8my8d54n68jm57mi", # Place a random string of letters and number here
		"LOADPLUGINS"=>TRUE,
	    "VERSION"=>"0.1.2",
	    "BUILD"=>"54",
	    "CODENAME"=>"Achelois",
    ];

    foreach ($config as $defkey=>$defval){
		(!defined($defkey) ? define((strtoupper($config["DEFKEY"]) == 'UPPER' ? strtoupper($defkey) : strtolower($defkey)), $defval) : "");
    }

    # These settings should not be changed:
	$rootPath = str_replace(basename(dirname(__FILE__)), '', basename(dirname(__FILE__)));
	define('BINDIR', 'bin');
	define('ETCDIR', 'etc');
	define('SYSDIR', 'system');
	define('DATADIR', SYSDIR.DS.'data');
	define('DS', DIRECTORY_SEPARATOR);
