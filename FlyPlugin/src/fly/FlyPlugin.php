<?php

declare(strict_types=1);

namespace fly;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

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
                    $this->sendFlyForm($sender);
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

    public function sendFlyForm(Player $player): void {
        $form = new SimpleForm(function (Player $player, $data) {
            if ($data === null) {
                return;
            }
            switch ($data) {
                case 0:
                    $player->setAllowFlight(true);
                    $player->sendMessage("Fly mode enabled.");
                    break;
                case 1:
                    $player->setAllowFlight(false);
                    $player->setFlying(false);
                    $player->sendMessage("Fly mode disabled.");
                    break;
            }
        });
        $form->setTitle("Fly Control");
        $form->setContent("Choose an option:");
        $form->addButton("Enable Fly");
        $form->addButton("Disable Fly");
        $player->sendForm($form);
    }
}
