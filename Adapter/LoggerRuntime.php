<?php
namespace Sweetkit\Foundation\Log\Adapter;

use Sweetkit\Foundation\Log\{LoggerAdapter,Log,LoggerViewAdapter};


final class LoggerRuntime extends LoggerAdapter
{
	protected $data = [];

	public function __construct(array $data = [])
	{
		$this->data = $data;		
	}

	public function load($data)
	{

	}

	public function formatter(Log $log)
	{

	}

	public function save() : void
	{

	}

	public function print(LoggerViewAdapter $view, array $filter = []) : void
	{
		$logger = $this;
		if(sizeof($filter) > 0) {
			$logger = $this->filter($filter);
		}

		echo $view->renderList($logger->getData());
	}
	public function last() : Log
	{
		if(sizeof($this->data) > 0) {
			return $this->data[0];
		}
	}
	public function first() : Log
	{
		if(sizeof($this->data) > 0) {
			return $this->data[sizeof($this->data) - 1];
		}
	}
	public function clear() : void
	{
		$this->data = [];
	}
	public function clearLast() : void
	{
		array_pop($this->data);
	}
}