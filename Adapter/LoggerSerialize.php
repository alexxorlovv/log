<?php
namespace Sweetkit\Foundation\Log\Adapter;

use Sweetkit\Foundation\Log\{LoggerAdapter,Log,LoggerViewAdapter};


final class LoggerSerialize extends LoggerAdapter
{
	protected $data = [];
	protected $rawData = "";
	protected $path;



	public function __construct(string $path)
	{
		$this->path = $path;
		if(file_exists($this->path)) {
			$this->rawData = file_get_contents($path);
			if(strlen($this->rawData) > 0) {
				$this->data = $this->load($this->rawData);
			}
		}
	}
	public function load($data)
	{
		$result = [];
		$data = unserialize($data);
		for($i = 0; $i < sizeof($data);$i++) {
			$log = $data[$i];
			$result[] = new Log($log['level'],$log['message'],$log['loggerName'],strtotime($log['time']));
		}
		return $result;
	}

	public function formatter(Log $log)
	{
		$colums = ["time" => $log->getTime("Y-m-d H:i:s"),
				   "level" => $log->getLevel(),
				   "loggerName" => $log->getLoggerName(),
				   "message" => $log->getMessage()];

		return $colums;
	}

	public function save() : void
	{
		$size = sizeof($this->data);
		if($size == 0) {
			return;
		}

		$rows = [];
		for($i = 0; $i < $size; $i++) 
		{
			$rows[] = $this->formatter($this->data[$i]);
		}

		file_put_contents($this->path, serialize($rows));

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