<?php

namespace Crates;

use pocketmine\Player;

use pocketmine\utils\Config;

use pocketmine\level\Level;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\sound\EndermanTeleportSound;

use pocketmine\inventory\Inventory;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\math\Vector3;

use pocketmine\plugin\Plugin;

use CrateSystem\Main;

class Vote{

    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function Start($sender){
        $inv = $sender->getInventory();
        if($inv->contains(Item::get(131,2,1))){
            $level = $sender->getLevel();
            $x = $sender->getX();
            $y = $sender->getY();
            $z = $sender->getZ();
            $pos = new Vector3($x, $y + 2, $z);
            $pos1 = new Vector3($x, $y, $z);
            $name = $sender->getName();
            $Vote = new Config($this->plugin->getDataFolder() . "Vote.yml");
            $items = $Vote->getNested("Vote.items");
            $item = $items[array_rand($items)];
            $values = explode(":", $item);

            $level->addSound(new EndermanTeleportSound($pos1));
            $level->addParticle(new LavaParticle($pos1));
            $inv->removeItem(Item::get(131,2,1));
            $sender->addTitle("§eOpening Crate:", "§cVote!");
            $this->plugin->getServer()->broadcastMessage("§b$name §ajust opened §cVote §aCrate!");
            $result = mt_rand(1,1);
                 switch($result){
        case 1:
        $sender->getInventory()->addItem(Item::get($values[0], $values[1], $values[2])->setCustomName($values[3]));
             break;
                 }
        }else{
            $sender->sendMessage("§fYou don't have §cVote §fKey.");
        }
    }
}
