<?php
	require_once('3rdParty'.DS.'BrowserDetection.php');
	$browser = new BrowserDetection();

	# These are Ternary Operators, please do not modify them unless you know what you are doing! Here is a break down of the operator:
	# $browser->function DOES NOT EQUAL '' then check to see if the name is defined, if it is not, then define it. If it is, send it to the error reporting system, anything else just null it.

	($browser->getUserAgent() != '' ? (! defined('userAgent') ? define ('userAgent', $browser->getUserAgent ()) : SysError('Warning', 'userAgent already defined, this error has been recovered, although it may not function correctly', '101')) : '');
	($browser->getName () != '' ? (! defined('browserName') ? define('browserName', $browser->getName ()) : SysError('Warning', 'browserName already defined, this error has been recovered, although it may not function correctly', '102')) : '');
	($browser->getVersion () != '' ? (! defined('browserVer') ? define('browserVer', $browser->getVersion ()) : SysError('Warning', 'browserVer already defined, this error has been recovered, although it may not function correctly', '103')) : '');
	($browser->getPlatform () != '' ? (! defined('platformFamily') ? define('platformFamily', $browser->getPlatform ()) : SysError('Warning', 'platformFamily already defined, this error has been recovered, although it may not function correctly', '104')) : '');
	($browser->getPlatformVersion (true) != '' ? (! defined('platformVer') ? define('platformVer', $browser->getPlatformVersion (true)) : SysError('Warning', 'platformVer already defined, this error has been recovered, although it may not function correctly', '105')) : '');
	($browser->getAolVersion() != '' ? (! defined('aolVer') ? define('aolVer', $browser->getAolVersion()) : SysError('Warning', 'aolVer already defined, this error has been recovered, although it may not function correctly', '106')) : '');
	(! defined('is64bit') ? define('is64bit', $browser->is64bitPlatform ()) : SysError('Warning', 'is64bit already defined, this error has been recovered, although it may not function correctly', '107'));
	(! defined('isMobile') ? define('isMobile', $browser->isMobile ()) : SysError('Warning', 'isMobile already defined, this error has been recovered, although it may not function correctly', '108'));
	(! defined('isRobot') ? define('isRobot', $browser->isRobot()) : SysError('Warning', 'isRobot already defined, this error has been recovered, although it may not function correctly', '109'));
	(! defined('isIECompat') ? define('isIECompat', $browser->isInIECompatibilityView()) : SysError('Warning', 'isIECompat already defined, this error has been recovered, although it may not function correctly', '110'));
	(! defined('isChromeFrame') ? define('isChromeFrame', $browser->isChromeFrame()) : SysError('Warning', 'isChromeFrame already defined, this error has been recovered, although it may not function correctly', '111'));
	(! defined('isAOL') ? define('isAOL', $browser->isAol()) : SysError('Warning', 'isAOL already defined, this error has been recovered, although it may not function correctly', '112'));

	$loaded = TRUE;
	($loaded && !defined('plg_visitor') ? define('plg_visitor', TRUE) : define('plg_visitor', FALSE));
