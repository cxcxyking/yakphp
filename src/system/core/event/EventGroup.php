<?php

namespace Yak\System\Event;

class EventGroup
{
	private $id;

	private $groups = [];

	public function __construct()
	{
		$this->id = uniqid('', true);
		EventManager::registerGroup($this);
	}

	public function __set($name, $value)
	{
		if (substr($name, 0, 2) === 'on') {
			$this->on(substr($name, 2), $value);
		}
	}

	public function __get($name)
	{
		if (substr($name, 0, 2) === 'on') {
			return $this->events[substr($name, 2)] ?? [];
		}
	}

	public function __call($name, $arguments)
	{
		if (substr($name, 0, 2) === 'on') {
			$this->emit(substr($name, 2), $arguments);
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function on(string $name, EventUnit $event)
	{
		if (!isset($this->groups[$name])) {
			$this->groups[$name] = [];
		}
		EventManager::registerEvent($event);
		$this->groups[$name][] = $event->getId();
	}

	public function emit(string $name, ...$arguments)
	{
		if (isset($this->groups[$name])) {
			$results = [];
			foreach ($this->groups[$name] as $id) {
				$event = EventManager::getEvent($id);
				$results[] = $event->invoke(new EventContext($event, $this, $name), ...$arguments);
			}
			return $results;
		} else {
			return [];
		}
	}

	public function off(string $name, string $id = '')
	{
		if (isset($this->groups[$name])) {
			if ($id === '') {
				foreach ($this->groups[$name] as $id) {
					EventManager::unregisterEvent($id);
				}
				unset($this->groups[$name]);
			} else {
				if (($index = array_search($id, $this->groups[$name])) !== false) {
					unset($this->groups[$name][$index]);
				}
			}
		}
	}
}