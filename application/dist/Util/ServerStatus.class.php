<?php
	use xPaw\MinecraftQuery;
	use xPaw\MinecraftQueryException;

	//Error_Reporting( E_ALL | E_STRICT );
	//Ini_Set( 'display_errors', true );

	require_once __DIR__ . '/Config.class.php';
	require_once __DIR__ . '/JsonParser.class.php';
	require_once __DIR__ . '/mcQuery/src/MinecraftQuery.php';
	require_once __DIR__ . '/mcQuery/src/MinecraftQueryException.php';
	require_once __DIR__ . '/MojangAPI/mojang-api.class.php';

	class ServerStatus {
		/* an array of the servers
		 * the "key" is the name of the server
		 * first value is the ip, second is the port, the third is "want to display the port on pages"
		 * the fourth is the description.
		 * The fifth is an array of "operators"
		 * Note: Consider writing json as config files?
		 */
		const cacheDir = "cache/";
		const fileName = "serverStatus.json";
		const cacheExpire = 100; //in minutes

		private $servers;
		private $jsonParser;

		public function __construct() {
			$this->jsonParser = new JsonParser();
			$this->servers = Config::getInstance()->getValue("servers");
		}

		public function getServers() {
			return $this->servers;
		}
        
		public function getIpWithPort($name, $andPort) {
			if ($andPort && $this->servers[$name]["displayPort"]) {
				return $this->getFriendlyIp($name).":".$this->getPort($name);
			}
			return $this->getFriendlyIp($name);
		}
		
		public function getFriendlyIp($name) {
            return $this->servers[$name]["friendly_ip"] ?: $this->servers[$name]['ip'];
        }
        
        public function getIp($name) {
            return $this->servers[$name]["ip"];
        }
        
        public function getPort($name) {
            return $this->servers[$name]["port"];
        }
        
		public function getStatus($name) {
			if ($this->jsonParser->jsonCache == null) {
				$this->fetchAllStatus();
			}
			//var_dump($this->jsonParser->jsonCache);
			return $this->jsonParser->jsonCache[$name];
		}

		private function getPlayersUUID($playerNames) {
			$players = [];
			if ($playerNames) {		
				foreach($playerNames as $pn) {
					$players[$pn] = MojangAPI::getUuid($pn);
				}
			}

			return $players;
		}

		public function fetchAllStatus() {
			//try the cache first
			$this->jsonParser->jsonCache = $this->jsonParser->fetchJson(ServerStatus::cacheDir, ServerStatus::fileName, ServerStatus::cacheExpire);
            
			$tempJson = array();

			$query = new MinecraftQuery();
            
			foreach ($this->servers as $key => $value) {
				if (!isset($this->jsonParser->jsonCache[$key]) || $this->jsonParser->jsonCache == null) {
				//json is expired or is missing. Or possiblly the server array list was changed during cache cycle?
					$this->jsonParser->isDirty = true;
					try {
						$query->Connect($value['ip'], $value['port'], 3);
						
						//process players
						$players = $this->getPlayersUUID($query->GetPlayers());
						
						$tempJson[$key] = array("online" => true, "info" => $query->GetInfo(), "players" => $players);
					}
					catch(MinecraftQueryException $e)
					{
                        $s = Config::getInstance()->getValue("settings");
                        if ($s["codeType"] == "dev") {
                            print $e;
                        }
						$tempJson[$key] = array("online" => false, "info" => $this->jsonParser->expiredJson[$key]["info"]);
					}

				}
				else {
					$tempJson[$key] = $this->jsonParser->jsonCache[$key];
				}

			}  
			//var_dump($tempJson);

			$this->jsonParser->jsonCache = $tempJson;
			$this->jsonParser->saveJson(ServerStatus::cacheDir, ServerStatus::fileName);
		}
	}