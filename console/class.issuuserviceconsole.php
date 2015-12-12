<?php

class IssuuServiceConsole
{
	private $params = array();

	private $actions = array(
		// Document
		'issuu.documents.list',
		'issuu.document.upload',
		'issuu.document.url_upload',
		'issuu.document.update',
		'issuu.document.delete',
		// Folder
		'issuu.folders.list',
		'issuu.folder.add',
		'issuu.folder.update',
		'issuu.folder.delete',
		// Bookmark
		'issuu.bookmarks.list',
		'issuu.bookmark.add',
		'issuu.bookmark.delete',
		// Document Embed
		'issuu.document_embeds.list',
		'issuu.document_embed.add',
		'issuu.document_embed.update',
		'issuu.document_embed.get_html_code',
		'issuu.document_embed.delete',
	);

	private $types = array(
		'send-request',
		'calculate-signature',
	);

	private $aliases = array(
		'--type' => 'type',
		'-t' => 'type',
		'--action' => 'action',
		'-ac' => 'action',
		'--apiKey' => 'apiKey',
		'-ak' => 'apiKey',
		'--apiSecret' => 'apiSecret',
		'-as' => 'apiSecret',
	);

	private $defaultValues = array(
		'type' => 'send-request',
		'apiKey' => ISSUU_SERVICE_CONSOLE_API_KEY,
		'apiSecret' => ISSUU_SERVICE_CONSOLE_API_SECRET,
	);

	private $type;

	public function __construct($argc, $argv)
	{
		if (in_array('help', $argv) || in_array('-h', $argv) || in_array('--help', $argv))
		{
			echo "\nParameters\n",
				"\n--type | -t\t\t\tAccepted values: send-request, calculate-signature. Default value is send-request",
				"\n--action | -ac\t\t\tAction that will be triggered",
				"\n--apiKey | -ap\t\t\tIssuu account Api Key",
				"\n--apiSecret | -as\t\tIssuu account Api Secret",
				"\n\n";
			exit;
		}
		else
		{
			$this->parseArgvToParams($argc, $argv);
		}
	}

	public static function run($argc, $argv)
	{
		$fileLog = ISSUU_SERVICE_LIBRARY_DIR . '/console/log.txt';

		if (!is_file($fileLog))
		{
			file_put_contents($fileLog, '');
			chmod($fileLog, 0755);
		}
		$instance = new IssuuServiceConsole($argc, $argv);
		$instance->setDefaultValues();
		$listener = new IssuuServiceConsoleListener();

		if (!$instance->hasParam('action'))
		{
			die("\nParameter 'action' is required\n");
		}

		$collection = IssuuServiceConsoleEventManager::trigger(
			$instance->getParam('action'),
			$instance,
			$instance->getParams(),
			array($instance, 'triggerEventUntil')
		);
		$last = $collection->last();

		if ($last instanceof Exception)
		{
			$trace = $last->getTraceAsString();
			echo sprintf("\nException Message: %s\n\n", $last->getMessage());
			die($trace . "\n");
		}
		$str = print_r($last, true);
		$datetime = date('Y-m-d H:i:s');
		file_put_contents($fileLog, "[$datetime]: $str\n", FILE_APPEND);
		echo "\n$str\n";
		exit;
	}

	private function parseArgvToParams($argc, $argv)
	{
		for ($i = 0; $i < $argc; $i++) {
			$arg = $argv[$i];

			if (strpos($arg, '--') === 0 && strpos($arg, '=') !== false)
			{
				$str = strtr($arg, array('--' => ''));
				$arr = explode('=', $str);
				$this->setParam($arr[0], $arr[1]);
			}
			else if (strpos($arg, '-') === 0 && isset($this->aliases[$arg]))
			{
				if (isset($argv[$i + 1]))
				{
					$posArg = $argv[$i + 1];
					$position = strpos($posArg, '-');

					if ($position === false || $position > 0)
					{
						$this->setParam($this->aliases[$arg], $posArg);
						++$i;
					}
				}
			}
		}
	}

	private function setDefaultValues()
	{
		foreach ($this->defaultValues as $name => $value) {
			if (!$this->hasParam($name))
			{
				$this->setParam($name, $value);
			}
		}
	}

	public function getParam($name, $default = null)
	{
		if (!is_string($name))
			return $default;

		return isset($this->params[$name])? $this->params[$name] : $default;
	}

	public function setParam($name, $value)
	{
		if (!is_string($name))
			return $this;

		$this->params[$name] = $value;
		return $this;
	}

	public function hasParam($name)
	{
		return isset($this->params[$name]);
	}

	public function getParams()
	{
		return $this->params;
	}

	public function triggerEventUntil($response)
	{
		return $response instanceof Exception;
	}
}