<?php
namespace Sweetkit\Foundation\Log;

use Psr\Log\AbstractLogger;
use Sweetkit\Foundation\Log\{LoggerAdapter,Log, LoggerViewAdapter};

class Logger extends AbstractLogger
{
	protected $adapter;
	function __construct(LoggerAdapter $adapter)
	{
		$this->adapter = $adapter;
	}

	public function log($level, $message, array $context = [])
	{

		$log = new Log($level, $message, get_called_class(), time(), $context);
		$this->adapter->add($log);
		$this->adapter->save();
	}

	public function print(LoggerViewAdapter $viewer, array $filter = [])
	{
		$this->adapter->print($viewer, $filter);
	}
}