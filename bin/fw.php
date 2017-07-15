<?php
    # Check for system files needed to operate
    if (file_exists('bin/config.php')) {
        require_once ("bin/config.php");
    }
    else {
    	if (file_exists ('install/install.php')) {
    		require_once ("install/install.php");
	    }
	    else {
    		SysError ('critical', 'No config file was found and the installation file does not exists, please reinstall framework', '200');
	    }
    }

    # Check the environment
    switch (ENVIRONMENT) {
        case "PRODUCTION":{
            break;
        }
        case "DEBUG":{
            break;
        }
        case "DEVELOPMENT":{
            break;
        }
        default:{
            break;
        }
    }

    # Test server for resources needed to operate
    # Check for any new updates

    # Test etc folder for any modules, plugins and components that was added
	$dirs = array_filter(glob(ETCDIR.DS.'*'), 'is_dir');
	foreach ($dirs as $dir) {
		switch (substr($dir, strlen(ETCDIR)+1, 3)){
			case 'plg':{
				$plgName = substr($dir, strlen(ETCDIR)+5, strlen($dir));
				(LOADPLUGINS ? loadPlugin ($plgName, $dir) : '');
				break;
			}
			case 'mod':{
				# Future use
				break;
			}
			case 'cmp':{
				# Future use
				break;
			}
		}
	}

	function loadPlugin($plgName, $plgDir){
		if (! file_exists ($plgDir.DS.'plg_'.$plgName.'.php')) {
			$message = 'Loading plugin <span style="color: blue;">' . $plgName . '</span> from the Plugin Directory <span style="color: blue;">' . $plgDir . '</span> ';
			$message .= 'looking for file <span style="color: blue;">' . $plgDir . DS . 'plg_' . $plgName . '.php' . '</span> is ' . (file_exists ($plgDir . DS . 'plg_' . $plgName . '.php') ? '<span style="color: green;">found</span>' : '<span style="color: red;">not found</span>');
			SysError ('warning', $message, '100');
		}

		if (file_exists ($plgDir.DS.'plg_'.$plgName.'.php')) {
			include ($plgDir . DS . 'plg_' . $plgName . '.php');
		}
	}
	function SysError($level, $message, $errno){
		$backtrace = debug_backtrace();
		$file = $backtrace['file'];
		$function = $backtrace['function'];
		$errFrom = '';
		switch (strtolower ($level)){
			case 'warning':{

				if (ENVIRONMENT == 'production') {
					# Log this to an error file only
				}
				else {
					if (ob_get_level() == 0) ob_start();
					echo str_pad ('', 4096);
					echo 'There is a warning from '.$errFrom.' error number ['.$errno.'] - '.$message.'<br />';
					ob_flush ();
					flush ();
					ob_end_flush ();
				}
				break;
			}
			case 'notify':{
				break;
			}
			case 'critical':{
				die('Unable to continue with critical error number ['.$errno.'] - '.$message.'<br />');
				break;
			}
			case 'deprecated':{
				break;
			}
			case 'recoverable':{
				break;
			}
		}
	}
