<?php

namespace himbeersaftlp\steak;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener{
     public function onEnable(){
          $this->getServer()->getPluginManager()->registerEvents($this,$this);
          $this->getLogger()->info("Steak aktiviert!");
     }
     if($cmd->getName() == "steak"){
          if(!$sender instanceof Player){
               $sender->sendMessage("Dieser Befehl geht nur INGAME!");
          }else{
               $sender->getInventory()->addItem(Item::get(364,0,10));
               $sender->sendMessage("Du hast 10 gratis Steak bekommen!");
          }
      }
      return true;
}
