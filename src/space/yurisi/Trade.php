<?php
declare(strict_types=1);

namespace space\yurisi;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use space\yurisi\Commands\tradeCommand;

class Trade extends PluginBase {

  private static Trade $trade;

  public function onEnable(): void {
    $this->getServer()->getCommandMap()->register("trade", new tradeCommand());
    if (!(file_exists($this->getDataFolder()))) @mkdir($this->getDataFolder(), 0777);
    new Config($this->getDataFolder() . "trade.yml", Config::YAML, array());
    self::$trade = $this;
  }

  public static function getInstance(): self {
    return self::$trade;
  }

}