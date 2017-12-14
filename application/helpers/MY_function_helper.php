<?php
function d($var, $message = false) {
	if (isset($_SERVER['REMOTE_ADDR'])) {
		if (!in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '212.40.66.1', '212.40.66.130', '94.248.136.156'))) {
			return FALSE;
		}
	}
	return debugVar($var, $message, 1);
}


function de($var, $message = false) {
	if (isset($_SERVER['REMOTE_ADDR'])) {
		if (!in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '212.40.66.1', '109.61.66.130', '94.248.136.156'))) {
			return FALSE;
		}
	}
	debugVar($var, $message, 1);
	exit;
}


function dee($var, $message = false) {
	if (isset($_SERVER['REMOTE_ADDR'])) {
		if (!in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '212.40.66.1', '212.40.66.130', '94.248.136.156'))) {
			de($var, $message);
		}
	}
}
function debugVar($var, $message = false, $deep = 0) {
	global $engine;
	if (is_string($var)) {
		$strlen = strlen($var);
	}
	$var = arrayHtmlSpecialChars($var);
	ob_start();
	$debug = debug_backtrace();
	$debugText = $debug[$deep]["file"]." on line ".$debug[$deep]["line"];
	echo "<fieldset class=\"debugvar\"><legend>$message - <span>$debugText</span></legend>";
	echo "\n\n<!-- DEBUG_VAR_DUMP -->\n";
			echo "<pre style=\"text-align: left;\">\n";
					if (is_string($var) && (strlen($var) != $strlen)) {
					echo "<b>ORIGINAL SIZE:</b> string($strlen)\n";
					}
					var_dump($var);
					echo "\n<!-- DEBUG BACKTRACE ".str_repeat("-=", 40)."\n";
					debugVarPrintBacktrace();
					echo str_repeat("-=", 50)." -->\n";
					echo "</pre>\n";
							echo "<!-- DEBUG_VAR_DUMP end -->\n";
    echo "</fieldset>";
							$tmp=ob_get_contents();
							ob_end_clean();
							echo ($engine->config->cmdline) ? strip_tags_c($tmp) : $tmp;
}

function arrayHtmlSpecialChars($input) {
	if (is_array($input)) {
		foreach ($input as &$item) {
			$item = arrayHtmlSpecialChars($item);
		}
	} else {
		if (is_string($input)) {
			$input = htmlspecialchars($input);
		}
	}
	return $input;
}