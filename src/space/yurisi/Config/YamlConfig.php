<?php


namespace space\yurisi\Config;



use pocketmine\item\Durable;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\Config;
use space\yurisi\Trade;

class YamlConfig extends Config {

	public function __construct() {
		parent::__construct(Trade::getInstance()->getDataFolder() . "trade.yml", Config::YAML);
	}

	public function registerItem(Item $item, int $amount, int $price, Player $player, bool $bool) {
		$id = $this->getRegisterId();
		$this->set($id, array(
			"id" => $id,
			"itemid" => $item->getId(),
			"itemdamage" => $item->getDamage(),
			"amount" => $amount,
			"price" => $price,
			"player" => $player->getName(),
			"public" => $bool
		));
		$this->save();
	}

	public function removeItem(int $id) {
		if($this->exists($id)) {
			$this->remove($id);
			$this->save();
		}
	}

	private function getRegisterId(): int {
		$id = 0;
		if (count($this->getAll()) > 0) {
			$data = $this->getAll();
			$id = ++end($data)["id"];
		}
		return $id;
	}

	public function getLastId(): int {
		$id = 0;
		if (count($this->getAll()) > 0) {
			$data = $this->getAll();
			$id = end($data)["id"];
		}
		return $id;
	}

	public function editMarketItem(int $id,int $price,bool $option){
		if($this->exists($id)){
			$this->set($id,array(
				"id" => $id,
				"itemid" => $this->get($id)["itemid"],
				"itemdamage" => $this->get($id)["itemdamage"],
				"amount" => $this->get($id)["amount"],
				"price" => $price,
				"player" => $this->get($id)["player"],
				"public" => $option
			));
			$this->save();
		}

	}

	public function getMarketItem(int $id, int $damage = 0): array {
		$adata = $this->getAll();
		$items = [];
		foreach ($adata as $data) {
			if (isset($data["id"])) {
				if ($data["itemid"] == $id) {
					if (!$data["public"]) {
						if (self::isTools($id)) {
							$items[] = $data["id"];
						} else {
							if ($data["itemdamage"] == $damage) {
								$items[] = $data["id"];
							}
						}
					}
				}
			}
		}
		return $items;
	}

	public function getAllMarket():array{
		$adata = $this->getAll();
		$items = [];
		foreach ($adata as $data) {
			if (!$data["public"]) {
				$items[] = $data["id"];
			}
		}
		return $items;
	}

	public function getPrivateAllMarket():array{
		$adata = $this->getAll();
		$items = [];
		foreach ($adata as $data) {
				$items[] = $data["id"];
		}
		return $items;
	}

	public function getMarketPlayer(string $name):array {
		$adata = $this->getAll();
		$items = [];
		foreach ($adata as $data) {
			if ($data["player"]==$name) {
				$items[] = $this->getMarketData($data["id"]);
			}
		}
		return $items;
	}

	public function getMarketData(int $id): array {
		if (!$this->exists($id)) return [];
		return $this->get($id);
	}


	public static function isTools(int $id) {
		$item = Item::get($id, 0, 1);
		if ($item instanceof Durable) {
			return true;
		}
		return false;
	}
}