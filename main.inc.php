<?php
if (!class_exists('hpl_import')) {
	include (strtr(dirname(__FILE__), '\\', '/') . '/system/func_arg/main.inc.php');
	/**
	 * @about - import file.
	 */
	class hpl_import {
		/** Importing a file function for include.
		 * @access - public function
		 * @param - string $file (file path)
		 * @return - boolean|data
		 * @usage - hpl_import::from($file);
		 */
		public static function from($file = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				//note that the error is all access
				$result = include (strtr($file, '\\', '/'));
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
				//note that the error is all access
				$result = include_once (strtr($file, '\\', '/'));
				return $result;
			}
			return false;
		}
	}
}
?>