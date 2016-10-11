<?php

namespace Fantasy\FBase;

use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\event\TextContainer;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\level\Level; 
use pocketmine\math\Vector3;
use pocektmine\schedularer\Task;
use pocketmine\utils\TextFormat;


use onebone\economyapi\EconomyAPI;
use Fantasy\FBase\CallbackTask;


class Main extends PluginBase implements Listener
{
	 public $path,$conf;
	public function onEnable()
	{

	$this->path = $this->getDataFolder();
		@mkdir($this->path);
		$this->conf = new Config($this->path."FBase.yml", Config::YAML,array(
		"hn"=>"手持",
		"pn"=>"在线",
		"mn"=>"金钱",
		"vn"=>"坐标",
		"an"=>"权限",
		"map"=>"地图",
		"time"=>"时间",
		"--------------",
		"Msg"=>"这里写公告~"
				));
	$this->getLogger()->info(" §e加载中  \nSnowXxm(雪宸)§6［贴吧ID: 緑搽丶］§a和 §bMattTardis(塔迪斯)§6［贴吧ID: The_Tardis］§a制作~\n§c仅供测试学习，严禁商业用途 ");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
	 $this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask ([$this,"xbase"]), 10) ;
	 
	}
	
	public function onLoad()
	{
	$this->getLogger()->info("§b---------------\n§a FBase加载完毕\n§eFantasy_Team§a制作~\n§c仅供测试学习，严禁商业用途\n §b--------------- ");
 }
 
 public function xbase(){
 
		foreach ($this->getServer()->getOnlinePlayers() as $players) {
	 $item = $players->getInventory()->getItemInHand();
	 date_default_timezone_set('Asia/Shanghai');
   //设定时区为上海
	 $itemid = $item->getId();
  	$itemdamage = $item->getDamage();
  $x = $players->getX();
  $y = $players->getY();
  $z = $players->getZ();
  $xx = intval($x);
  $yy = intval($y);
  $zz = intval($z);
  $mapn = $players->getLevel()->getFolderName();
  //获取自定义标题
  $hn = $this->conf->get("hn");
  $pn = $this->conf->get("pn");
  $mn = $this->conf->get("mn");
  $vn = $this->conf->get("vn");
  $an = $this->conf->get("an");
  $map = $this->conf->get("map");
  $time = $this->conf->get("time");
  	//手持
		$h = $hn ."->". $itemid. ":" .$itemdamage;
		//在线
		$p = $pn ."->". count($players);
		//金钱
		$m = $mn ."->". EconomyAPI::getInstance()->myMoney($players->getName());
		//坐标
		$v = $vn ."->". "X".$xx . "Y".$yy . "Z".$zz;
		//时间
		$t = $time ."->". date('H'). ":".date('i');
   //地图
   $mpn = $map ."->". ":".$mapn;
		//权限
    if ($players->isOp()) {
                   $a = "op";
                } else {
                    $a = "player";
}
    $a = $an ."->". $a;

    $players->sendPopup("[$p]    [$m]    [$h] [$mpn] \n <$v>    [$a]  [$t]");
    $Msg=$this->conf->get("Msg");
    $players->sendTip("$Msg");
			}

		}

 
}


?>