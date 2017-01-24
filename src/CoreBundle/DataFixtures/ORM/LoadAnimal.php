<?php
/**
 * Created by PhpStorm.
 * User: keke-
 * Date: 22/01/2017
 * Time: 19:05
 */

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\AnimalClassification;
use CoreBundle\Entity\Bird;
use CoreBundle\Entity\Mammal;
use CoreBundle\Entity\Reptile;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadAnimal
 *
 * Class which loads a set of examples animals data into the database
 * It loads Mammals, Reptiles and Birds
 *
 * @package CoreBundle\DataFixtures\ORM
 * @see \CoreBundle\Entity\Animal
 * @see \CoreBundle\Entity\Mammal
 * @see \CoreBundle\Entity\Reptile
 * @see \CoreBundle\Entity\Bird
 */
class LoadAnimal implements FixtureInterface
{
    // List of possible names to use to fill the database
    private static $names = array('Jean', 'Fifi', 'Roberta', 'Pikachu', 'Doctor Who', 'Yvette', 'Plumesec', 'Syndra',
        'Varian', 'Fordring', 'Karma', 'Neltharion');

    // Lists of adjectives for the fur, the scale and the feathers of animals
    private static $furDescriptions      = array('chatoyante', 'douce', 'aux longs poils');
    private static $scaleDescriptions    = array('coupantes', 'lisses', 'résistantes');
    private static $feathersDescriptions = array('doux', 'long', 'sombre');

    // Lists of species
    private static $growls = array('lion', 'girafe', 'chaton');
    private static $hisses = array('couleuvre', 'cobra', 'crocodile');
    private static $tweets = array('pivert', 'hiboux', 'phoenix', 'aigle');

    /**
     * Load data fixtures with the passed EntityManager
     *
     * Use shuffled data within lists to fill entities.
     * Data are the name, an adjective for an animal characteristic (fur, scale or feather)
     * and a species for each animal category (mammal, reptile and bird)
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
        {
            $manager->persist($example);
        }

        $manager->flush();
    }

    /**
     * Fill an array with Mammal
     * @param array $set The array to be filled
     * @see \CoreBundle\Entity\Mammal
     */
    private function loadMammals(array &$set)
    {
        $type = new AnimalClassification();
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

    /**
     * Fill an array with Reptiles
     * @param array $set The array to be filled
     * @see \CoreBundle\Entity\Reptile
     */
    private function loadReptiles(array &$set)
    {
        $type = new AnimalClassification();
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

    /**
     * Fill an array with Bird
     * @param array $set The array to be filled
     * @see \CoreBundle\Entity\Bird
     */
    private function loadBirds(array &$set)
    {
        $type = new AnimalClassification();
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
