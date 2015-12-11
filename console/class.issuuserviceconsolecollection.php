<?php

class IssuuServiceConsoleCollection
{
	private $collection = array();

	private $count = 0;

	private $current = 0;

	public function add($item)
	{
		$this->collection[] = $item;
		$this->count++;
	}

	public function remove($index = -1)
	{
		if (!is_int($index) || $index < 0)
			$index = 0;

		if ($this->count > 0)
		{
			$value = $this->collection[$index];
			unset($this->collection[$index]);
			$this->count--;
			return $value;
		}

		return null;
	}

	public function next()
	{
		$this->current++;
	}

	public function current()
	{
		return isset($this->collection[$this->current])? $this->collection[$this->current] : null;
	}

	public function prev()
	{
		$this->current--;
	}

	public function first()
	{
		if ($this->count == 0)
			return null;
		
		return $this->collection[0];
	}

	public function last()
	{
		if ($this->count == 0)
			return null;
		
		return $this->collection[$this->count - 1];
	}

	public function toArray()
	{
		$arr = array();

		foreach ($this->collection as $value) {
			if (is_object($value))
			{
				if (method_exists($value, 'toArray'))
				{
					$value = $value->toArray();
				}
				else if (method_exists($value, 'getArrayCopy'))
				{
					$value = $value->getArrayCopy();
				}
			}
			$arr[] = $value;
		}
		return $arr;
	}
}