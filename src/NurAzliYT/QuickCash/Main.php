<?php

namespace NurAzliYT\QuickCash;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use NurAzliYT\QuickCash\api\QuickCashAPI;
use NurAzliYT\QuickCash\commands\{SetCashCommand, SeeCashCommand, AddCashCommand, RemoveCashCommand, PayCommand};

class Main extends PluginBase{

    private Config $config;

    public function onEnable() : void{
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        $this->getServer()->getCommandMap()->registerAll($this->getName(), [
            new SetCashCommand($this),
            new SeeCashCommand($this),
            new AddCashCommand($this),
            new RemoveCashCommand($this),
            new PayCommand($this)
        ]);
    }

    public function getConfigValue(string $key, $default = null){
        return $this->config->get($key, $default);
    }

    public function getCurrencyName() : string{
        return $this->getConfigValue("currency-name", "Cash");
    }

    public function getDefaultBalance() : int{
        return (int) $this->getConfigValue("default-balance", 1000);
    }

    public function getMaxBalance() : int{
        return (int) $this->getConfigValue("max-balance", 1000000);
    }

    public function getAPI() : QuickCashAPI{
        return new QuickCashAPI($this->getDataFolder());
    }
}
