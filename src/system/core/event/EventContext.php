<?php

namespace Yak\System\Event;

class EventContext
{
	private $event;
	private $group;
	private $eventName;

	public function __construct(EventUnit $event, EventGroup $group, string $eventName)
	{
		$this->event = $event;
		$this->group = $group;
		$this->eventName = $eventName;
	}

	public function getEvent()
	{
		return $this->event;
	}

	public function getGroup()
	{
		return $this->group;
	}

	public function getEventName()
	{
		return $this->eventName;
	}

	public function off()
	{
		$this->getGroup()->off($this->eventName, $this->event->getId());
	}

}