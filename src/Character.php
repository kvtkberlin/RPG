<?php

namespace Rpg\Test;

use AllowDynamicProperties;

#[AllowDynamicProperties] class Character
{
    private string $name;

    /**
     * @var int Health Points
     */
    private int $hp;

    /**
     * @var int Attack Points
     */
    private int $ap;

    /**
     * @var float Attack Bonus Factor
     */
    private float $attackFactor;

    /**
     * @var int Defense Points
     */
    private int $dp;

    /**
     * @var float Defense Factor
     */
    private float $defenseFactor;

    /**
     * @var int Critical Points
     */
    private int $cp;

    /**
     * @var float Critical Bonus Factor
     */
    private float $criticalFactor;

    /**
     * @param string $name
     * @param int $hp
     * @param int $ap
     * @param float $attackFactor
     * @param int $dp
     * @param float $defenseFactor
     * @param int $cp
     * @param float $criticalFactor
     */
    public function __construct(string $name, int $hp = 120, int $ap = 6, float $attackFactor = 1.0, int $dp = 6, float $defenseFactor = 0.7, int $cp = 3, float $criticalFactor = 0.3)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->ap = $ap;
        $this->attackFactor = $attackFactor;
        $this->dp = $dp;
        $this->defenseFactor = $defenseFactor;
        $this->cp = $cp;
        $this->criticalFactor = $criticalFactor;
    }

    public function __toString(): string
    {
        return $this->name;
    }
    public function attack(Character $character): void
    {
        if ($character->getHp() <= 0) {
            echo "{$character} ist tot!\n";
        }

        $fiendHP = $character->getHp();
        $fiendDP = $character->getDp() * $character->getDefenseFactor();

        // Zufallskomplex 1 - Angriffsstärke
        $apRand = rand(70, 130);                                // $apRand1 = rand(30,130); $apRand2 = rand(40,130); $apRand3 = rand(50,130); $apRand4 = rand(60,130); $apRand5 = rand(70,130);
        if ($apRand > 110) {                                    //  {$gladiator->getwüg()          if($gladiator->getwüg() = 1) { if($apRand1 >     Würfelglück
            if (rand(0, 100) < 50) {
                $apRand = $this->attackFactor * 100;
            }
        }
                                                                // $diceRoll = 24 + ($this->cf * 10);   // Anzahl der Würfelversuche -- 0.1 = 25 =1 0.3 = 27 -- 0,1 = 10% (25x) 20 = 90% (225x)    80 = 200 ; 100 = 250   25/250   225/250(45/50)
                                                                //1 $criticalChance = 24;                //  foreach($criticalFactor = -0.1 ; $criticalFactor < 0.1 ; $criticalChance--);
                                                                //3 $criticalChance = rand(1,250);
                                                                //1 for ($criticalChance < 250 ; $diceRoll ; rand(1, 250)) {
                                                                //2 for ($criticalChance = 24 ; $criticalChance < 250 ; rand(1,250)->$diceRoll) {

        // Zufallskomplex 2 - Kritischer Schaden
        for ($diceRoll = 0; $diceRoll < 24 + ($this->criticalFactor * 10); $diceRoll++) {

            $criticalChance = rand(1, 250);                         // $criticalChance->criticalHit
            if ($criticalChance == 250) {

                $cfRand = rand($this->criticalFactor * 2, 70);
                $cfRand2 = rand($this->criticalFactor * 3, 100);
                $cfRand3 = rand($this->criticalFactor * 4, 140);

                $criticalHit = round((($cfRand + $cfRand2 + $cfRand3) / 31),2);      // round(($cfRand + $cfRand2 + $cfRand3) / 31,2);

                if ($criticalHit < 1.5) {
                    $criticalHit = 1.5;
                }
                break;
            } else {$criticalHit = 0;}
        }
                                                        //        if($diceRoll->
                                                        //  for ( $criticalChance = 0 ; $criticalChance < 250 ; $criticalChance = rand(1,250) ) {
                                                        //      $cfRand = rand($this->cf * 2, 70);
                                                        //      $cfRand2 = rand($this->cf * 3, 100);
                                                        //      $cfRand3 = rand($this->cf * 4, 140);
                                                        //
                                                        //      $criticalHit = ($cfRand + $cfRand2 + $cfRand3) / 31;
                                                        //
                                                        //      if ($criticalHit < 1.5) {
                                                        //          $criticalHit = 1.5;
                                                        //
                                                        //          } else {
                                                        //            $criticalHit = 1;
                                                        //            }

                                                        //      if($criticalChance < 250) {
                                                        //            $criticalHit = 1;
                                                        //        } else {
                                                        //          continue $diceRoll;
                                                        //         }

                                                        //        $cpRand  = rand($this->cp,70);
                                                        //        $cpRand2 = rand($this->cp,110);
                                                        //        $cpRand3 = rand($this->cp,110);
                                                        //        $cpRandEq = ($cpRand + $cpRand2) / 2;

                                                        //        if($cpRandEq > 60) {                      // wird critt vollzogen ??
                                                        //            $criticalHit = $cpRandEq * $this->cp / 100;
                                                        //        } else {$criticalHit = 1;
                                                        //          }
                                                        // Ermitteln der Angriffskraft
        $attackFactor = $this->attackFactor * $apRand / 100;
        $basicAttack = $this->ap * round($attackFactor,2);
        // $criticalDamage = $criticalHit > 1.5 * $this->cp
        $criticalDamage = round($criticalHit,2) * $this->cp;

        $selfAP = $basicAttack + $criticalDamage - $fiendDP;

        if($selfAP <= 0) {
            $selfAP = 0;
            echo "{$character} hat geblockt!\n";
        } else {
            echo "{$this} attackiert {$character} mit {$selfAP} Angriffspunkten! \033[31m             cH={$criticalHit} ; cD={$criticalDamage} ; dRA={$diceRoll}\033[0m\n";
            if($criticalDamage > 0) {
                echo "_______es wurde kritischer Schaden ausgeteilt.. in Höhe von {$criticalDamage}\n";
                echo "_______dabei hat der Verteidiger insgesamt {$fiendDP} geblockt\n";
                echo  "\033[33m\033[1m\033[44m cHitPower : dice1={$cfRand} dice2={$cfRand2} dice3={$cfRand3} - critHit={$criticalHit}  -->  critChan={$criticalChance} - bei {$diceRoll} Versuchen  -->  ATTACK : diceAp={$apRand} factor={$attackFactor} Damage={$basicAttack}\x1B[0m\n";
            }
        }
        $resultFiendHP = $fiendHP-$selfAP;

        // Angriff durchführen
        $character->setHp( round($resultFiendHP) );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getHp(): int
    {
        return $this->hp;
    }

    /**
     * @param int $hp
     */
    public function setHp(int $hp): void
    {
        $this->hp = $hp;
    }

    /**
     * @return int
     */
    public function getAp(): int
    {
        return $this->ap;
    }

    /**
     * @param int $ap
     */
    public function setAp(int $ap): void
    {
        $this->ap = $ap;
    }

    /**
     * @return float
     */
    public function getAttackFactor(): float
    {
        return $this->attackFactor;
    }

    /**
     * @param float $attackFactor
     */
    public function setAttackFactor(float $attackFactor): void
    {
        $this->attackFactor = $attackFactor;
    }

    /**
     * @return int
     */
    public function getDp(): int
    {
        return $this->dp;
    }

    /**
     * @param int $dp
     */
    public function setDp(int $dp): void
    {
        $this->dp = $dp;
    }

    /**
     * @return float
     */
    public function getDefenseFactor(): float
    {
        return $this->defenseFactor;
    }

    /**
     * @param float $defenseFactor
     */
    public function setDefenseFactor(float $defenseFactor): void
    {
        $this->defenseFactor = $defenseFactor;
    }

    /**
     * @return int
     */
    public function getCp(): int
    {
        return $this->cp;
    }

    /**
     * @param int $cp
     */
    public function setCp(int $cp): void
    {
        $this->cp = $cp;
    }

    /**
     * @return float
     */
    public function getCriticalFactor(): float
    {
        return $this->criticalFactor;
    }

    /**
     * @param float $criticalFactor
     */
    public function setCriticalFactor(float $criticalFactor): void
    {
        $this->criticalFactor = $criticalFactor;
    }

}