<?php

use Rpg\Test\Character;

require 'vendor/autoload.php';

$gladiator = new Character('Hulk');
$monster = new Character('Org');  //,120,4,1,3,.7,4);

echo "Das Spiel beginnt!\n";

while(true) {

    $gladiator->attack($monster);
    $monster->attack($gladiator);

        if($gladiator->getHp() <= 0) {
            echo "$gladiator ist tot !\n";
            echo "$monster überlebt mit {$monster->getHp()} HP und reitet siegreich vom Feld.\n";
            break;
        }
        if($monster->getHp() <= 0) {
            echo "$monster ist tot !\n";
            echo "$gladiator überlebt mit {$gladiator->getHp()} HP und reitet siegreich vom Feld.\n";
            break;
        }
}
// echo ""
echo "Das Spiel ist zu ende!\n";
