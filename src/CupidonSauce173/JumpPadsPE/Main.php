<?php

namespace CupidonSauce173\JumpPadsPE;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener{

	public function onEnable(){
		$this->makeSaveFiles();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	private function makeSaveFiles(){
		$this->saveResource("config.yml");
		$this->getConfig()->save();
	}

	public function onPlayerMove(PlayerMoveEvent $event){
		$player = $event->getPlayer();
		$block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
		if($this->getConfig()->get($block->getId()) !== false){
			$distance = $this->getConfig()->get($block->getId());
			$from = $event->getFrom();
			$to = $event->getTo();
			if(!is_numeric($distance)) $distance = 5;
			$player->setMotion((new Vector3(($to->x - $from->x) * ($distance / 5), 0.5, ($to->z - $from->z) * ($distance / 5))));
		}
	}
}
