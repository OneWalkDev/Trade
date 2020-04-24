<?php


namespace space\yurisi\Form;


use pocketmine\form\Form;
use pocketmine\Player;
use space\yurisi\Form\Buy\BuyForm;
use space\yurisi\Form\Sell\SellForm;

class MainForm implements Form {

	/**
	 * Handles a form response from a player.
	 *
	 * @param Player $player
	 * @param mixed $data
	 *
	 */
	public function handleResponse(Player $player, $data): void {
		if(!is_numeric($data)) return;
		if($data===0){
			$player->sendForm(new BuyForm());
			return;
		}
		if(empty($player->getInventory()->getContents())){
			$player->sendMessage("[§aTRADE§r] Error:インベントリにアイテムが存在しません");
			return;
		}
		$player->sendForm(new SellForm($player));
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize() {
		$buttons[]=['text'=>"ものを買う"];
		$buttons[]=['text'=>"出品する"];
		return [
			"type"=>'form',
			"title"=>'§l§aTRADESTATION.com',
			"content"=>"フリーマーケットメニューです！",
			"buttons"=>$buttons,
		];
	}
}