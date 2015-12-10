<?php

class IssuuServiceConsoleEventManager
{
	private static $events = array();

	public static function attach($name, $callback, $priority = 10)
	{
		if (is_string($name) && is_callable($callback))
		{
			if (!is_int($priority))
			{
				$priority = 10;
			}

			if (!isset(self::$events[$name]))
			{
				self::$events[$name] = array();
			}
			self::$events[$name][$priority][] = $callback;
		}
		else
		{
			throw new InvalidArgumentException("Argument 'name' must be a string and 'callback' must be callable");
		}
	}

	public static function trigger($name, $target, array $data = array(), $trigerUntil = null)
	{
		$responseCollection = new IssuuServiceConsoleCollection();

		if (!isset(self::$events[$name]))
			return $responseCollection;

		$issuuEvent = new IssuuServiceConsoleEvent();
		$issuuEvent->setName($name)
			->setTarget($target)
			->setParams($data);
		$order = self::$events[$name];
		krsort($order);
		foreach ($order as $callbacks) {
			foreach ($callbacks as $callback) {
				try {
					$response = call_user_func($callback, $issuuEvent);
				} catch (Exception $e) {
					$response = $e;
				}
				$responseCollection->add($response);

				if (is_callable($trigerUntil))
				{
					$result = call_user_func($trigerUntil, $response);

					if (is_bool($result) && $result === true)
					{
						break;
					}
				}

				if ($issuuEvent->isStopped())
				{
					break;
				}
			}
		}

		return $responseCollection;
	}
}