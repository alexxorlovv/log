<?php
namespace Sweetkit\Foundation\Log\Viewers;

use Sweetkit\Foundation\Log\{Log,LoggerViewAdapter};

final class LoggerViewHtml extends LoggerViewAdapter
{
	public function render(Log $log) : string 
	{
		$render = "<div class='log'>";
		$render .= "<span class='log_time'>".$log->getTime("Y-m-d H:i:s")."</span>";
		$render .= "<span class='log_level'>".$log->getLevel()."</span>";
		$render .= "<span class='log_loggerName'>".$log->getLoggerName()."</span>";
		$render .= "<span class='log_message'>".$log->getMessage()."</span>";
		$render .= '</div>';
		return $render;
	}
	public function renderList(array $logs) : string
	{
		$render = "<div class='logger'>";
		$size = sizeof($logs);
		for($i = 0; $i < $size; $i++) {
			$render .= $this->render($logs[$i]);
		}
		$render .= "</div>";
		return $render;
	}
}