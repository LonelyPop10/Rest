<?php

declare(strict_types=1);

namespace fly;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class FlyPlugin extends PluginBase {

    public function onEnable(): void {
        $this->getLogger()->info("FlyPlugin enabled!");
    }

    public function onDisable(): void {
        $this->getLogger()->info("FlyPlugin disabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (strtolower($command->getName()) === "fly") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("flyplugin.command.fly")) {
                    if ($sender->getAllowFlight()) {
                        $sender->setAllowFlight(false);
                        $sender->setFlying(false);
                        $sender->sendMessage("Fly mode disabled.");
                    } else {
                        $sender->setAllowFlight(true);
                        $sender->sendMessage("Fly mode enabled.");
                    }
                } else {
                    $sender->sendMessage("You don't have permission to use this command.");
                }
            } else {
                $sender->sendMessage("This command can only be used in-game.");
            }
            return true;
        }
        return false;
    }
}
