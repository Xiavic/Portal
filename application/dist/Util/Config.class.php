<?php
require_once __DIR__ . '/JsonParser.class.php';

class Config {
	const dir = "Util/";
	const filename = "config.json";

	public static $Config;

	/* create a global instance of the config */
	public static function getInstance() {
		if (Config::$Config == null) {
			Config::$Config = new Config();
		}
		return Config::$Config;
	}

	private $jsonParser;

	public function __construct() {
		$this->jsonParser = new JsonParser();
		$this->jsonParser->fetchJson(Config::dir, Config::filename);
	}

	//returns an array from json
	public function getValue($value) {
		return $this->jsonParser->jsonCache[$value];
	}
}