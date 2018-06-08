<?php

namespace Sweetkit\Foundation\Log;

class Log 
{
	protected $message;
	protected $level;
	protected $loggerName;
	protected $time;

	public function __construct(string $level, string $message, string $loggerName, int $time  = 0, array $context = [])
	{
		$this->setLevel($level);
		$this->setMessage($this->formatter($message,$context));
		$this->setLoggerName($loggerName);
		$this->setTime($time); 
	}

	public function formatter(string $message, array $context = []) : string
	{
		if(sizeof($context) == 0) {
			return $message;
		}
		return str_replace(array_map([$this,"formatContext"], array_keys($context)), array_values($context), $message);

	}

	public function getMessage() : string
	{
		return $this->message;
	}

	public function getLevel() : string
	{
		return $this->level;
	}

	public function getLoggerName() : string 
	{
		return $this->loggerName;
	}

	public function getTime(string $mask) : string
	{
		return date($mask,$this->time);
	}
	public function getRawTime()
	{
		return $this->time;
	}


	protected function formatContext(string $elem) : string
	{
		return "{".$elem."}";
	}

	public function setLevel($level) : void
	{
		$this->level = $level;
	}

	public function setMessage(string $message) : void
	{
		$this->message = $message;
	}

	public function setLoggerName(string $loggerName) : void
	{
		$this->loggerName = $loggerName;
	}
	public function setTime(int $time) :void
	{
		$this->time = $time;
	}


}