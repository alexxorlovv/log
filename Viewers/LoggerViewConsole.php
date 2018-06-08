<?php
namespace Sweetkit\Foundation\Log\Viewers;

use Sweetkit\Foundation\Log\{Log,LoggerViewAdapter};

final class LoggerViewConsole extends LoggerViewAdapter
{
	public function render(Log $log) : string 
	{
		$render = "";
		$render .= $log->getTime("Y-m-d H:i:s")." | ";
		$render .= $log->getLevel()." | ";
		$render .= $log->getLoggerName()." | ";
		$render .= $log->getMessage();
		$render .= "\r\n";
		return $render;
	}
	public function renderList(array $logs) : string
	{
		$render = "======= LOGGER =======\r\n";
		$size = sizeof($logs);
		for($i = 0; $i < $size; $i++) {
			$render .= $this->render($logs[$i]);
		}
		return $render;
	}
}