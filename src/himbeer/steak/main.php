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
               "steaks" => 10,
               "steak_msg" => "You got 10 free steak!",
               "hunger_fill_msg" => "Your hunger bar had been filled!",
               "hunger_and_steak_msg" => "You got 10 free steaks and your hunger bar had been filled!",
               "console_msg" => "The console isn't hunry!",
               "give_steaks" => true,
               "fill_hunger" => true,
          ));
          $this->saveResource("config.yml");
     }
     
     public function onCommand(CommandSender $sender, Command $command, $label, array $args){
          switch($command->getName()){
               case "steak":
                    if(!$sender instanceof Player){
                         $console_msg = $this->config->get("console_msg");
                         $sender->sendMessage($console_msg);
                    }else{
                         if($this->config->get("give_steaks") == true && $this->config->get("fill_hunger") == false){
                              $steaks = $this->config->get("steaks");
                              $sender->getInventory()->addItem(Item::get(364,0,$steaks));
                              $steak_msg = $this->config->get("steak_msg");
                              $sender->sendMessage($steak_msg);
                         }elseif($this->config->get("give_steaks") == false && $this->config->get("fill_hunger") == true){
                              $hunger_fill_msg = $this->config->get("hunger_fill_msg");
                              $sender->sendMessage($hunger_fill_msg);
                              $sender->setFood(20);
                         }elseif($this->config->get("give_steaks") == true && $this->config->get("fill_hunger") == true){
                              $hunger_and_steak_msg = $this->config->get("hunger_and_steak_msg");
                              $steaks = $this->config->get("steaks");
                              $sender->getInventory()->addItem(Item::get(364,0,$steaks));
                              $sender->setFood(20);
                              $sender->sendMessage($hunger_and_steak_msg);
                         }else{
                              $sender->sendMessage("Please set fill_hunger or give_steaks in config to true!");
                         }
                    }
          }
          return true;
     }
}
