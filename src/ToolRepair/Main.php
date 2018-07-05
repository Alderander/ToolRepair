<?php

namespace ToolRepair;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\{Utils, Config, TextFormat};
use pocketmine\command\{Command, CommandSender, CommandExecuter, CommandMap, ConsoleCommandSender};
use pocketmine\math\Vector3;
use pocketmine\{Player, Server};
use pocketmine\inventory\PlayerInventory;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Tool;
use pocketmine\item\Armor;

	class Main extends PluginBase implements Listener{
		
		public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->getLogger()->info("Version: 1.0.0 for API: 3.0.0");
		}
		
		public function onCommand(CommandSender $sender, Command $command, $label, array $args): bool {
			switch(strtolower($command->getName())){
			case "fix":
			if($sender instanceof Player){
				$item = $sender->getInventory()->getItemInHand();
				if($item instanceof Armor or $item instanceof Tool){
					/* remove damaged item */
					$id = $item->getId();
					$meta = $item->getDamage();
					$sender->getInventory()->removeItem(Item::get($id, $meta, 1));
					/* add repaired/clone item */
					$newitem = Item::get($id, 0, 1);
					if($item->hasCustomName()){
						$newitem->setCustomName($item->getCustomName());
						}
					if($item->hasEnchantments()){
						foreach($item->getEnchantments() as $enchants){
						$newitem->addEnchantment($enchants);
						}
						}
					$sender->getInventory()->addItem($newitem);
					$sender->sendMessage("§a" . $item->getName() . " repaired successfully.");
					return true;
					} else {
					$sender->sendMessage("§cCan't be repaired.");
					return false;
					}
				} else {
				$sender->sendMessage("§cYou're not online.");
				return false;
				}
				break;
			}
		}
	
	}
