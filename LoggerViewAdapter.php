<?php
namespace Sweetkit\Foundation\Log;

use Sweetkit\Foundation\Log\Log;

abstract class LoggerViewAdapter
{
	abstract public function render(Log $log);
	abstract public function renderList(array $logs);
}