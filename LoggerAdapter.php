<?php
namespace Sweetkit\Foundation\Log;

use Sweetkit\Foundation\Log\Log;
use Sweetkit\Foundation\Log\LoggerViewAdapter;

abstract class LoggerAdapter
{
	abstract public function formatter(Log $log);
	abstract public function save();
	abstract public function load($data);
	abstract public function print(LoggerViewAdapter $view, array $filter = []);
	abstract public function last();
	abstract public function first();
	abstract public function clear();
	abstract public function clearLast();

	public function setData($data)
	{
		$this->data = $data;
	}

	public function add(Log $log) : void
	{
		$this->data[] = $log;
	}

	public function filter(array $criteria) : LoggerAdapter
	{
		$logger = clone $this;
		$result = [];
		$size = sizeof($this->data);
		if($size == 0) {
			$logger->setData($result);
			return $logger;
		}

		$date_in = false;
		$date_out = false;
		$limit = false;
		$level = false;

		if(isset($criteria['date_in'])) {
			$date_in = strtotime($criteria['date_in']);
		}
		if(isset($criteria['date_out'])) {
			$date_out = strtotime($criteria['date_out']);
		}
		if(isset($criteria['limit'])) {
			$limit = (int) $criteria['limit'];
		}
		if(isset($criteria['level'])) {
			$level = $criteria['level'];
		}	
		
	
		for($i = 0; $i < $size; $i++) {
			$log = $this->data[$i];
			if($limit) {
				if($limit < sizeof($result)) {
					break;
				}
			}
			if($level) {
				if($level !== $log->getLevel()) {
					continue;
				}
			}
			if($date_in) {
				if($log->getRawTime() < $date_in) {
					continue;
				}
			}
			if($date_out) {

				if($log->getRawTime() > $date_out) {
					continue;
				}
			}
			$result[] = $log;

		}
		$logger->setData($result);
		return $logger;
	}

	public function getData()
	{
		return $this->data;
	}
}