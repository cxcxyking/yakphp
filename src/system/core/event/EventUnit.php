<?php

namespace Yak\System\Event;

class EventUnit
{
	private $id;
	private $callback;
	private $boundArguments = [];

	public function __construct(callable $callback, array $arguments = [])
	{
		$this->id = uniqid('', true);
		$this->callback = $callback;
		$this->boundArguments = $arguments;
		EventManager::registerEvent($this);
	}

	public function __invoke(EventContext $context, ...$arguments)
	{
		return $this->invoke($context, $arguments);
	}

	public function getId()
	{
		return $this->id;
	}

	public function invoke(EventContext $context, ...$arguments)
	{
		return call_user_func($this->callback, $context, ...$this->boundArguments, ...$arguments);
	}
}