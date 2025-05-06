<?php

namespace NurAzliYT\QuickCash\api;

use pocketmine\player\Player;
use pocketmine\utils\Config;

class QuickCashAPI {
    private Config $playerData;

    public function __construct(string $dataFolder) {
        $this->playerData = new Config($dataFolder . "player_cash.yml", Config::YAML);
    }

    /**
     * Get the cash balance of a player.
     *
     * @param Player $player
     * @return int
     */
    public function getCash(Player $player): int {
        return (int) $this->playerData->get($player->getUniqueId()->toString(), 0);
    }

    /**
     * Set the cash balance of a player.
     *
     * @param Player $player
     * @param int $amount
     */
    public function setCash(Player $player, int $amount): void {
        $this->playerData->set($player->getUniqueId()->toString(), $amount);
        $this->playerData->save();
    }

    /**
     * Add cash to a player's balance.
     *
     * @param Player $player
     * @param int $amount
     */
    public function addCash(Player $player, int $amount): void {
        $this->setCash($player, $this->getCash($player) + $amount);
    }

    /**
     * Remove cash from a player's balance.
     *
     * @param Player $player
     * @param int $amount
     */
    public function removeCash(Player $player, int $amount): void {
        $this->setCash($player, max(0, $this->getCash($player) - $amount));
    }

    /**
     * Reset a player's cash balance to zero.
     *
     * @param Player $player
     */
    public function resetCash(Player $player): void {
        $this->setCash($player, 0);
    }
}
