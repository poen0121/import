<?php
if (!class_exists('hpl_import')) {
	include (str_replace('\\', '/', dirname(__FILE__)) . '/system/func_arg/main.inc.php');
	/**
	 * @about - import file.
	 */
	class hpl_import {
		private static $line;
		/** Error handler.
		 * @access - public function
		 * @param - integer $errno (error number)
		 * @param - string $message (error message)
		 * @param - string $file (file path)
		 * @param - integer $line (file line number)
		 * @return - boolean|null
		 * @usage - set_error_handler(__CLASS__.'::ErrorHandler');
		 */
		public static function ErrorHandler($errno = null, $message = null, $file = null, $line = null) {
			if (!(error_reporting() & $errno)) {
				// This error code is not included in error_reporting
				return;
			}
			//replace message target function
			if ($file == __FILE__ && $line == self :: $line) {
				$caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
				$caller = end($caller);
				$message = __CLASS__ . '::' . $caller['function'] . '(): ' . $message;
			}
			//response message
			$title = '';
			switch ($errno) {
				case E_PARSE :
				case E_ERROR :
				case E_CORE_ERROR :
				case E_COMPILE_ERROR :
				case E_USER_ERROR :
					if ($file == __FILE__ && $line == self :: $line) {
						hpl_error :: cast($message, $errno, 3);
					}
					$title = 'Fatal error';
					break;
				case E_WARNING :
				case E_USER_WARNING :
				case E_COMPILE_WARNING :
				case E_RECOVERABLE_ERROR :
					if ($file == __FILE__ && $line == self :: $line) {
						hpl_error :: cast($message, $errno, 3);
						return true;
					}
					$title = 'Warning';
					break;
				case E_NOTICE :
				case E_USER_NOTICE :
					if ($file == __FILE__ && $line == self :: $line) {
						hpl_error :: cast($message, $errno, 3);
						return true;
					}
					$title = 'Notice';
					break;
				case E_STRICT :
					if ($file == __FILE__ && $line == self :: $line) {
						hpl_error :: cast($message, $errno, 3);
						return true;
					}
					$title = 'Strict';
					break;
				case E_DEPRECATED :
				case E_USER_DEPRECATED :
					if ($file == __FILE__ && $line == self :: $line) {
						hpl_error :: cast($message, $errno, 3);
						return true;
					}
					$title = 'Deprecated';
					break;
				default :
					if ($file == __FILE__ && $line == self :: $line) {
						hpl_error :: cast($message, $errno, 3);
						return true;
					}
					$title = 'Error [' . $errno . ']';
					break;
			}
			$message = '<br /><b>' . $title . '</b>: ' . $message . ' in <b>' . $file . '</b> on line <b>' . $line . '</b><br />';
			if ((isset ($_SERVER['ERROR_STACK_TRACE']) ? preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', $_SERVER['ERROR_STACK_TRACE']) : false)) { //error stack trace
				$baseDepth = 1;
				$caller = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
				$rows = count($caller);
				if ($rows > $baseDepth) {
					$message .= PHP_EOL . 'Stack trace:' . PHP_EOL . '<br />';
					for ($i = $baseDepth; $i < $rows; $i++) {
						$argsList = ''; //args info
						if (isset ($caller[$i]['args'])) {
							foreach ($caller[$i]['args'] as $sort => $args) {
								$argsList .= ($sort > 0 ? ', ' : '');
								switch (gettype($args)) {
									case 'string' :
										$argsList .= '\'' . (mb_strlen($args, 'utf-8') > 20 ? mb_substr($args, 0, 17, 'utf-8') . '...' : $args) . '\'';
										break;
									case 'array' :
										$argsList .= 'Array';
										break;
									case 'object' :
										$argsList .= get_class($args) . ' Object';
										break;
									case 'resource' :
										$argsList .= get_resource_type($args) . ' Resource';
										break;
									case 'boolean' :
										$argsList .= ($args ? 'true' : 'false');
										break;
									case 'NULL' :
										$argsList .= 'NULL';
										break;
									default :
										$argsList .= $args;
										break;
								}
							}
						}
						$message .= '#' . ($i - $baseDepth) . ' ' . $caller[$i]['file'] . '(' . $caller[$i]['line'] . '):' . (isset ($caller[$i]['class']) ? ' ' . $caller[$i]['class'] . $caller[$i]['type'] : ' ') . $caller[$i]['function'] . '(' . $argsList . ')' . ($i < ($rows -1) ? PHP_EOL : '') . '<br />';
					}
				}
			}
			if (preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', ini_get('log_errors'))) {
				error_log('PHP ' . strip_tags($message), 0);
			}
			if (preg_match('/^(on|(\+|-)?[0-9]*[1-9]+[0-9]*)$/i', ini_get('display_errors'))) {
				echo PHP_EOL , (isset ($_SERVER['argc']) && $_SERVER['argc'] >= 1 ? strip_tags($message) : $message) , PHP_EOL;
			}
			if ($title == 'Fatal error') {
				exit;
			}
			/* Don't execute PHP internal error handler */
			return true;
		}
		/** Importing a file function for include.
		 * @access - public function
		 * @param - string $file (file path)
		 * @return - boolean|data
		 * @usage - hpl_import::from($file);
		 */
		public static function from($file = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				set_error_handler(__CLASS__ . '::ErrorHandler');
				//note that the error is all access
				self :: $line = __LINE__;
				$result = include (str_replace('\\', '/', $file)); //mark the line number
				restore_error_handler();
				return $result;
			}
			return false;
		}
		/** Importing a file function for include_once.
		 * @access - public function
		 * @param - string $file (file path)
		 * @return - boolean|data
		 * @usage - hpl_import::from_once($file);
		 */
		public static function from_once($file = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				set_error_handler(__CLASS__ . '::ErrorHandler');
				//note that the error is all access
				self :: $line = __LINE__;
				$result = include_once (str_replace('\\', '/', $file)); //mark the line number
				restore_error_handler();
				return $result;
			}
			return false;
		}
	}
}
?>