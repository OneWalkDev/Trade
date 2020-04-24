<?php

namespace space\yurisi;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use space\yurisi\Commands\tradeCommand;

class Trade extends PluginBase {

	/**
	 * @var Trade
	 */
	private static $trade;

	public function onEnable() {
		$this->getServer()->getCommandMap()->register("trade",new tradeCommand());
		if (!(file_exists($this->getDataFolder()))) @mkdir($this->getDataFolder(), 0777);
		new Config($this->getDataFolder()."trade.yml",Config::YAML,array());
		self::$trade=$this;
	}

	public static function getInstance():Trade{
		return self::$trade;
	}

}