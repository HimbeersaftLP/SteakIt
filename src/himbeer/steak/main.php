<?php

namespace himbeer\steak;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
     
     public function onEnable(){
          $this->getServer()->getPluginManager()->registerEvents($this,$this);
          $this->getLogger()->info("SteakIt enabled!");
          @mkdir($this->getDataFolder());
          $this->config = new Config ($this->getDataFolder() . "config.yml" , Config::YAML, array(
               #     _____ _             _    _____ _   
               #    / ____| |           | |  |_   _| |  
               #   | (___ | |_ ___  __ _| | __ | | | |_ 
               #    \___ \| __/ _ \/ _` | |/ / | | | __|
               #    ____) | ||  __/ (_| |   < _| |_| |_ 
               #   |_____/ \__\___|\__,_|_|\_\_____|\__|
               # SteakIt configuration file:
               # 
               # Number of steaks to give to a player:
               "steaks" => 10,
          ));
          $this->saveResource("config.yml");
     }
     
     public function onCommand(CommandSender $sender, Command $command, $label, array $args){
          switch($command->getName()){
               case "steak":
                    if(!$sender instanceof Player){
                         $sender->sendMessage("The console isn't hungry!");
                    }else{
                         $steaks = $this->config->get("steaks");
                         $sender->getInventory()->addItem(Item::get(364,0,$steaks));
                         $sender->sendMessage("You got ",§steaks," free steaks!");
                    }
#               case "teststeaks":
#                    §sender->sendMessage("Steaks are set to ",§steaks);
          }
          return true;
     }
}
