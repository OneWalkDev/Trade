<?php

namespace space\yurisi\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use space\yurisi\Form\MainForm;

class tradeCommand extends Command {

	public function __construct() {
		parent::__construct("trade","フリマを開く","/trade");
	}

	/**
	 * @param string[] $args
	 *
	 * @return mixed
	 * @throws CommandException
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		$sender->sendForm(new MainForm());
		return true;
	}
}