<?php

if (!is_file('vendor/autoload.php'))
	die("Dependencies are not installed. Please run the command \"php composer.phar update\"");

require('bootstrap.php');
require('vendor/autoload.php');