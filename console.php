<?php

define('ISSUU_SERVICE_CONSOLE_API_KEY', 'jil7ll5cg2cwm93kg6xlsc1x9apdeyh7');
define('ISSUU_SERVICE_CONSOLE_API_SECRET', '8agoiu10igdyw7azj9b8rvi0otyja6gj');

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