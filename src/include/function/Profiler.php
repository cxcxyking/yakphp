<?php

class YakProfiler {
	private $enabled = false;
	private $snapshots = [];

	public function enabled(bool $enabled) {
		$this->enabled = $enabled;
	}

	public function capture(string $tag = 'default') {
		$this->prepareSnapshot($tag);
		$this->pushSnapshot($tag, $this->takeSnapshot());
	}

	public function statistics() {
		
	}



	private function prepareSnapshot(string $tag) {
		if(!isset($this->snapshots[$tag])) {
			$this->snapshots[$tag] = [];
		}
	}

	private function pushSnapshot(string $tag, array $snapshotData) {
		$this->snapshots[$tag][] = $snapshots;
	}

	private function takeSnapshot(): array {
		$snapshot = [];
		$snapshot['time'] = microtime(true);
		$snapshot['memory_usage'] = memory_get_usage(false);
		$snapshot['memory_allocated'] = memory_get_usage(true);
		return $snapshot;
	}

	

}