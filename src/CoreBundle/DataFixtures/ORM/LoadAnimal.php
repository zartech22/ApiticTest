<?php
/**
 * Created by PhpStorm.
 * User: keke-
 * Date: 22/01/2017
 * Time: 19:05
 */

namespace CoreBundle\DataFixtures\ORM;


use CoreBundle\Entity\AnimalType;
use CoreBundle\Entity\Bird;
use CoreBundle\Entity\Mammal;
use CoreBundle\Entity\Reptile;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAnimal implements FixtureInterface
{
    private static $names = array('Jean', 'Fifi', 'Roberta', 'Pikachu', 'Doctor Who', 'Yvette', 'Plumesec', 'Syndra',
        'Varian', 'Fordring', 'Karma', 'Neltharion');
    private static $furDescriptions = array('chatoyante', 'douce', 'aux longs poils');
    private static $scaleDescriptions = array('coupantes', 'lisses', 'résistantes');
    private static $feathersDescriptions = array('doux', 'long', 'sombre');

    private static $growls = array('lion', 'girafe', 'chaton');
    private static $hisses = array('couleuvre', 'cobra', 'crocodile');
    private static $tweets = array('pivert', 'hiboux', 'phoenix', 'aigle');

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $exampleSet = array();

        shuffle(self::$tweets);
        shuffle(self::$growls);
        shuffle(self::$hisses);

        shuffle(self::$feathersDescriptions);
        shuffle(self::$furDescriptions);
        shuffle(self::$scaleDescriptions);

        shuffle(self::$names);

        $this->loadMammals($exampleSet);
        $this->loadReptiles($exampleSet);
        $this->loadBirds($exampleSet);

        foreach ($exampleSet as $example)
            $manager->persist($example);

        $manager->flush();
    }

    private function loadMammals(array &$set)
    {
        $type = new AnimalType();
        $type->setName('Mammifère');

        for ($i = 0; $i < 3; $i++)
        {
            $mammal = new Mammal();
            $mammal->setFur(self::$furDescriptions[$i])
                ->setGrowl(self::$growls[$i])
                ->setName(next(self::$names))
                ->setType($type);

            $set[] = $mammal;
        }
    }

    private function loadReptiles(array &$set)
    {
        $type = new AnimalType();
        $type->setName('Reptile');

        for ($i = 0; $i < 3; $i++)
        {
            $reptile = new Reptile();
            $reptile->setScale(self::$scaleDescriptions[$i])
                ->setHiss(self::$hisses[$i])
                ->setName(next(self::$names))
                ->setType($type);

            $set[] = $reptile;
        }
    }

    private function loadBirds(array &$set)
    {
        $type = new AnimalType();
        $type->setName('Oiseau');

        for ($i = 0; $i < 3; $i++)
        {
            $bird = new Bird();
            $bird->setFeathers(self::$feathersDescriptions[$i])
                ->setTweet(self::$tweets[$i])
                ->setName(next(self::$names))
                ->setType($type);

            $set[] = $bird;
        }
    }
}