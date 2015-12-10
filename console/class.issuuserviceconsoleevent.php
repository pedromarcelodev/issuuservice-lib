<?php

class IssuuServiceConsoleEvent
{
	private $params = array();

	private $name;

	private $target;

	private $stopPropagation = false;

	public function setName($name)
	{
		if (!is_string($name))
			return $this;

		$this->name = $name;
		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setTarget($target)
	{
		$this->target = $target;
		return $this;
	}

	public function getTarget()
	{
		return $this->target;
	}

	public function setParam($name, $value)
	{
		if (!is_string($name))
			return $this;

		$this->params[$name] = $value;
		return $this;
	}

	public function getParam($name, $default = null)
	{
		if (!is_string($name))
			return $default;

		return isset($this->params[$name])? $this->params[$name] : $default;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function setParams(array $params)
	{
		foreach ($params as $name => $value) {
			$this->setParam($name, $value);
		}

		return $this;
	}

	public function stopPropagation($value = true)
	{
		if (!is_bool($value))
			return;

		$this->stopPropagation = $value;
	}

	public function isStopped()
	{
		return $this->stopPropagation == true;
	}
}