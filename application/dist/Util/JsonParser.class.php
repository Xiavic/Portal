<?php

class JsonParser {

	public $isDirty;
	public $jsonCache;

	public $expiredJson;

	/*
	 * Returns raw json in string format
	 */
	public function getRawJson() {
		return json_encode($this->jsonCache);
	}

	/*
	 * $expire set to 0 means never expire.
	 */
	public function fetchJson($dir, $filename, $expire=0) {
		if (file_exists($dir) || $dir === null) {
			$file = $dir . $filename;
			if (file_exists($file)) {
				$this->jsonCache = json_decode(file_get_contents($file), true);
				if ($expire > 0) {
					if ((filemtime($file)+($expire*60)) <= time()) { //cache has expired, should have it fetch a new one
						$this->expiredJson = $this->jsonCache;
						$this->jsonCache = null;
						return null;
					}
				}

				return $this->jsonCache;
			}
		}
		else {
			mkdir($dir);
		}
		return null;
	}

	public function saveJson($dir, $filename) {
		if ($this->isDirty) {
			$file = $dir . $filename;
			$fh = fopen($file, "w");
			fwrite($fh, json_encode($this->jsonCache));
			fclose($fh);
		}
	}
}

?>
