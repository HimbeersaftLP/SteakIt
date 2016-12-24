<?php

/*
 *     $$$$$$\    $$\                         $$\       $$$$$$\ $$\
 *    $$  __$$\   $$ |                        $$ |      \_$$  _|$$ |
 *    $$ /  \__|$$$$$$\    $$$$$$\   $$$$$$\  $$ |  $$\   $$ |$$$$$$\
 *    \$$$$$$\  \_$$  _|  $$  __$$\  \____$$\ $$ | $$  |  $$ |\_$$  _|
 *     \____$$\   $$ |    $$$$$$$$ | $$$$$$$ |$$$$$$  /   $$ |  $$ |
 *    $$\   $$ |  $$ |$$\ $$   ____|$$  __$$ |$$  _$$<    $$ |  $$ |$$\
 *    \$$$$$$  |  \$$$$  |\$$$$$$$\ \$$$$$$$ |$$ | \$$\ $$$$$$\ \$$$$  |
 *     \______/    \____/  \_______| \_______|\__|  \__|\______| \____/
 * 
 * by HimbeersaftLP
 * 
 */

namespace himbeer\steak;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\utils\Config;

class main extends PluginBase implements Listener{
     
     public function onEnable(){
          $this->getServer()->getPluginManager()->registerEvents($this,$this);
          $this->getLogger()->info("SteakIt by HimbeersaftLP enabled!");
          $this->saveResource("config.yml");
          $this->config = new Config($this->getDataFolder(). "config.yml", Config::YAML);
     }

     public function giveSteak($player){
          $count = $this->config->get("steak_count");
          $player->getInventory()->addItem(Item::get(364,0,$count));
          return true;
     }

     public function fillHunger($player){
          $player->setFood(20);
          return true;
     }

     public function onCommand(CommandSender $sender, Command $command, $label, array $args){
          switch($command->getName()){
               case "steak":
                    if(!$sender instanceof Player){
                         $msg = $this->config->get("console_msg");
                         $sender->sendMessage($msg);
                         break;
                    }else{
                         if(!isset($args[0])){
                              $gsteak = $this->config->get("give_steak");
                              $fhunger = $this->config->get("fill_hunger");
                              if($gsteak == true){
                                   $this->giveSteak($sender);
                              }
                              if($fhunger == true){
                                   $this->fillHunger($sender);
                              }
                              if($gsteak == false && $fhunger == false){
                                   $sender->sendMessage("Please set fill_hunger or give_steak in config to true!");
                                   break;
                              }
                              $msg = $this->config->get("maincmd_msg");
                              $sender->sendMessage($msg);
                              break;
                         }else{
                              switch($args[0]){
                                   case "steak":
                                        $this->giveSteak($sender);
                                        $msg = $this->config->get("subcmd_steak");
                                        $sender->sendMessage($msg);
                                        break;
                                   case "hunger":
                                        $this->fillHunger($sender);
                                        $msg = $this->config->get("subcmd_hunger");
                                        $sender->sendMessage($msg);
                                        break;
                                   case "both":
                                        $this->giveSteak($sender);
                                        $this->fillHunger($sender);
                                        $msg = $this->config->get("subcmd_both");
                                        $sender->sendMessage($msg);
                                        break;
                                   default:
                                        $msg = $this->config->get("subcmd_not_found");
                                        $sender->sendMessage($msg);
                                        break;
                              }
                              break;
                         }
                         break;
                    }
          }
          return true;
     }
}
