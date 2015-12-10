<?php

define('ISSUU_SERVICE_CONSOLE_API_KEY', '');
define('ISSUU_SERVICE_CONSOLE_API_SECRET', '');

require(dirname(__FILE__) . '/bootstrap.php');
require(ISSUU_SERVICE_LIBRARY_DIR . '/console/class.issuuserviceconsolecollection.php');
require(ISSUU_SERVICE_LIBRARY_DIR . '/console/class.issuuserviceconsoleevent.php');
require(ISSUU_SERVICE_LIBRARY_DIR . '/console/class.issuuserviceconsoleeventmanager.php');
require(ISSUU_SERVICE_LIBRARY_DIR . '/console/class.issuuserviceconsolelistener.php');
require(ISSUU_SERVICE_LIBRARY_DIR . '/console/class.issuuserviceconsole.php');

/**
*	Additional files to include
*/
$additionalFiles = array();

foreach ($additionalFiles as $glob) {
	$files = glob($glob, GLOB_BRACE);

	if (is_array($files))
	{
		foreach ($files as $file) {
			require($file);
		}
	}
}

IssuuServiceConsole::run($argc, $argv);