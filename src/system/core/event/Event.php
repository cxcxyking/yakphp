<?php

namespace Yak\System\Event;

class Event
{
	private $id;
	private $callback;
	private $boundArguments = [];

	public function __construct(callable $callback, array $arguments = [])
	{
		$this->id = uniqid('', true);
		$this->callback = $callback;
		$this->boundArguments = $arguments;
		Manager::registerEvent($this);
	}

	public function __invoke(Context $context, ...$arguments)
	{
		$this->invoke($context, $arguments);
	}

	public function getId()
	{
		return $this->id;
	}

	public function invoke(Context $context, array $arguments = [])
	{
		call_user_func_array($this->callback, array_merge([$context], $this->boundArguments, $arguments));
	}
}