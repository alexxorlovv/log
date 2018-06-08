<?php
namespace Sweetkit\Foundation\Log\Adapter;

use Sweetkit\Foundation\Log\{LoggerAdapter,Log,LoggerViewAdapter};


final class LoggerText extends LoggerAdapter
{
	protected $delimiter_column = " | ";
	protected $delimiter_row = PHP_EOL;
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
		$rows = explode($this->delimiter_row,$data);
		$result = [];
		for($i = 0; $i < sizeof($rows);$i++) {
			$colums = explode($this->delimiter_column,$rows[$i]);
		
			$result[] = new Log($colums[1],$colums[3],$colums[2],strtotime($colums[0]));
			// time : logLevel : logClass : message 
		}
		return $result;
	}

	public function formatter(Log $log)
	{
		$colums = [$log->getTime("Y-m-d H:i:s"),
				   $log->getLevel(),
				   $log->getLoggerName(),
				   str_replace(trim($this->delimiter_column), '', $log->getMessage())];

		return implode($this->delimiter_column, $colums);
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

		file_put_contents($this->path, implode($this->delimiter_row, $rows));

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