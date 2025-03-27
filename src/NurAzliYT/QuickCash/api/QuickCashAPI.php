<?php

namespace NurAzliYT\QuickCash\api;

use pocketmine\player\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\plugin\Plugin;

class QuickCashAPI {

    private const CASH_TAG = "quickcash_balance";
    private Plugin $plugin;

    /**
     * QuickCashAPI constructor.
     *
     * @param Plugin $plugin
     */
    public function __construct(Plugin $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * Get the cash balance of a player.
     *
     * @param Player $player
     * @return int
     */
    public function getCash(Player $player): int {
        $nbt = $player->getNamedTag();
        return $nbt->getTag(self::CASH_TAG) instanceof IntTag ? $nbt->getInt(self::CASH_TAG) : 0;
    }

    /**
     * Set the cash balance of a player.
     *
     * @param Player $player
     * @param int $amount
     */
    public function setCash(Player $player, int $amount): void {
        $nbt = $player->getNamedTag();
        $nbt->setInt(self::CASH_TAG, $amount);
        $player->setNamedTag($nbt);
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
