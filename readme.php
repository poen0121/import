<?php
/*
>> Information

	Title		: hpl_import function
	Revision	: 2.10.2
	Notes		:

	Revision History:
	When			Create		When		Edit		Description
	---------------------------------------------------------------------------
	03-23-2016		Poen		03-23-2016	Poen		Create the program.
	08-01-2016		Poen		08-02-2016	Poen		Reforming the program.
	09-29-2016		Poen		11-21-2016	Poen		Debug the program error messages.
	12-05-2016		Poen		06-30-2017	Poen		Improve the program.
	03-10-2017		Poen		03-10-2017	Poen		Modify the program to add error stack trace.
	04-20-2017		Poen		04-20-2017	Poen		Support CLI normal error output.
	06-21-2017		Poen		06-21-2017	Poen		Fix error log time and line breaks.
	06-22-2017		Poen		06-22-2017	Poen		PHP System error log recovery can only access system files.
	---------------------------------------------------------------------------

>> About

	Import file.

	Handling Returns: include returns FALSE on failure and raises a warning. Successful includes,
	unless overridden by the included file, return 1.

	It is possible to execute a return statement inside an included file in order to terminate processing in
	that file and return to the script which called it.

	Also, it's possible to return values from included files.

>> Error Stack Trace

	Switch variable parameter is $_SERVER['ERROR_STACK_TRACE'] , stack trace calls will consume memory.

	Stack trace grab file and line echo location.

	Enable : $_SERVER['ERROR_STACK_TRACE']=1;

	Disable : $_SERVER['ERROR_STACK_TRACE']=0;

>> Usage Function

	==============================================================
	Include file
	Usage : include('import/main.inc.php');
	==============================================================

	==============================================================
	Importing a file function for include.
	Usage : hpl_import::from($file);
	Param : string $file (file path)
	Return : boolean|data
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	hpl_import::from('C:\\test.php');
	==============================================================

	==============================================================
	Importing a file function for include_once.
	Usage : hpl_import::from_once($file);
	Param : string $file (file path)
	Return : boolean|data
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example :
	hpl_import::from_once('C:\\test.php');
	==============================================================

*/
?>