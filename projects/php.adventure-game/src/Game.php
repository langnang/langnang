<?php
require_once 'Player.php';
require_once 'Room.php';
require_once 'Enemy.php';
require_once 'Item.php';

class Game
{
  private $player;
  private $rooms = [];
  private $currentRoom;
  private $isRunning = true;

  public function __construct()
  {
    $this->initPlayer();
    $this->initRooms();
    $this->currentRoom = $this->rooms['start'];
  }

  private function initPlayer()
  {
    $this->player = new Player('冒险者', 100, 50);
  }

  private function initRooms()
  {
    // 创建房间
    $this->rooms['start'] = new Room(
      'start',
      '村庄广场',
      "你站在村庄的中心广场，四周是熟悉的建筑。\n北方是武器店，东方是森林入口。"
    );

    $this->rooms['shop'] = new Room(
      'shop',
      '武器店',
      "武器店内摆满了各种装备。老板热情地打招呼。"
    );

    $this->rooms['forest'] = new Room(
      'forest',
      '神秘森林',
      "树木茂密，光线昏暗。远处传来野兽的吼声。",
      ['enemy' => new Enemy('哥布林', 30, 10)]
    );

    $this->rooms['treasure'] = new Room(
      'treasure',
      '宝藏密室',
      "金光闪闪！你发现了传说中的宝藏！",
      ['item' => new Item('黄金剑', 'weapon', 25)]
    );

    // 设置房间连接
    $this->rooms['start']->addExit('north', 'shop');
    $this->rooms['start']->addExit('east', 'forest');
    $this->rooms['shop']->addExit('south', 'start');
    $this->rooms['forest']->addExit('west', 'start');
    $this->rooms['forest']->addExit('north', 'treasure');
    $this->rooms['treasure']->addExit('south', 'forest');
  }

  public function run()
  {
    $this->clearScreen();
    echo "🗡️  === 命令行冒险游戏 === ️\n\n";
    echo "输入 help 查看可用命令\n\n";

    while ($this->isRunning) {
      $this->displayRoom();
      $command = $this->getInput();
      $this->processCommand($command);
    }

    echo "\n感谢游玩！再见！\n";
  }

  private function displayRoom()
  {
    echo str_repeat('-', 40) . "\n";
    echo "📍 {$this->currentRoom->getName()}\n";
    echo str_repeat('-', 40) . "\n";
    echo "{$this->currentRoom->getDescription()}\n";
    echo "\n❤️ 生命: {$this->player->getHealth()} | 💰 金币: {$this->player->getGold()}\n";
    echo "\n";
  }

  private function getInput()
  {
    echo "> ";
    $input = trim(fgets(STDIN));
    return strtolower($input);
  }

  private function processCommand($command)
  {
    $parts = explode(' ', $command);
    $action = $parts[0];

    switch ($action) {
      case 'help':
        $this->showHelp();
        break;
      case 'go':
      case 'move':
        $this->move($parts[1] ?? '');
        break;
      case 'look':
        $this->look();
        break;
      case 'take':
        $this->takeItem($parts[1] ?? '');
        break;
      case 'inventory':
      case 'i':
        $this->showInventory();
        break;
      case 'attack':
        $this->attack();
        break;
      case 'save':
        $this->saveGame();
        break;
      case 'load':
        $this->loadGame();
        break;
      case 'quit':
      case 'exit':
        $this->isRunning = false;
        break;
      default:
        echo "❌ 未知命令，输入 help 查看帮助\n";
    }
  }

  private function showHelp()
  {
    echo "\n📖 可用命令:\n";
    echo "  go [方向]     - 移动 (north/south/east/west)\n";
    echo "  look          - 查看当前房间\n";
    echo "  take [物品]   - 拾取物品\n";
    echo "  inventory     - 查看背包 (可简写为 i)\n";
    echo "  attack        - 攻击敌人\n";
    echo "  save          - 保存游戏\n";
    echo "  load          - 加载游戏\n";
    echo "  quit          - 退出游戏\n";
    echo "  help          - 显示帮助\n\n";
  }

  private function move($direction)
  {
    if (empty($direction)) {
      echo "❌ 请指定方向 (north/south/east/west)\n";
      return;
    }

    $nextRoom = $this->currentRoom->getExit($direction);
    if ($nextRoom) {
      $this->currentRoom = $this->rooms[$nextRoom];
      echo "✅ 你向 {$direction} 移动...\n";

      // 检查是否有敌人
      $enemy = $this->currentRoom->getEnemy();
      if ($enemy && $enemy->isAlive()) {
        echo "⚠️ 警告！{$enemy->getName()} 出现了！\n";
      }
    } else {
      echo "❌ 那个方向无法通行\n";
    }
  }

  private function look()
  {
    $this->displayRoom();
  }

  private function takeItem($itemName)
  {
    if (empty($itemName)) {
      echo "❌ 请指定物品名称\n";
      return;
    }

    $item = $this->currentRoom->getItem($itemName);
    if ($item) {
      $this->player->addItem($item);
      $this->currentRoom->removeItem($itemName);
      echo "✅ 你拾取了 {$item->getName()}!\n";
    } else {
      echo "❌ 这里没有这个物品\n";
    }
  }

  private function showInventory()
  {
    echo "\n🎒 背包物品:\n";
    $items = $this->player->getItems();
    if (empty($items)) {
      echo "  (空)\n";
    } else {
      foreach ($items as $item) {
        echo "  - {$item->getName()}: {$item->getDescription()}\n";
      }
    }
    echo "\n";
  }

  private function attack()
  {
    $enemy = $this->currentRoom->getEnemy();
    if (!$enemy || !$enemy->isAlive()) {
      echo "❌ 这里没有敌人可攻击\n";
      return;
    }

    // 玩家攻击
    $damage = rand(5, 15);
    $enemy->takeDamage($damage);
    echo "⚔️ 你攻击 {$enemy->getName()}，造成 {$damage} 点伤害!\n";

    if (!$enemy->isAlive()) {
      echo "🎉 你击败了 {$enemy->getName()}!\n";
      $reward = rand(10, 50);
      $this->player->addGold($reward);
      echo "💰 获得 {$reward} 金币!\n";
      return;
    }

    // 敌人反击
    $enemyDamage = rand(3, 10);
    $this->player->takeDamage($enemyDamage);
    echo " {$enemy->getName()} 反击，造成 {$enemyDamage} 点伤害!\n";

    if (!$this->player->isAlive()) {
      echo "💀 你被击败了... 游戏结束!\n";
      $this->isRunning = false;
    }
  }

  private function saveGame()
  {
    $data = [
      'player' => $this->player->toArray(),
      'currentRoom' => $this->currentRoom->getId()
    ];
    file_put_contents('data/save.json', json_encode($data, JSON_PRETTY_PRINT));
    echo "✅ 游戏已保存!\n";
  }

  private function loadGame()
  {
    if (!file_exists('data/save.json')) {
      echo "❌ 没有存档文件\n";
      return;
    }

    $data = json_decode(file_get_contents('data/save.json'), true);
    $this->player->fromArray($data['player']);
    $this->currentRoom = $this->rooms[$data['currentRoom']];
    echo "✅ 游戏已加载!\n";
  }

  private function clearScreen()
  {
    echo chr(27) . "[H" . chr(27) . "[2J";
  }
}
