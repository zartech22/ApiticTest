<?php
/**
 * Created by PhpStorm.
 * User: keke-
 * Date: 22/01/2017
 * Time: 20:04
 */

namespace CoreBundle\AnimalsColorDispenser;

use CoreBundle\Entity\Animal;

class AnimalColorDispenser extends \Twig_Extension
{
    /**
     * Holds the "Animal subclass => color" association
     * @var array
     */
    private static $colors;

    /**
     * Holds "safe colors" to use
     *
     * Array of background colors which are compatible with black text
     *
     * @var array
     */
    private static $safeColors;

    public function __construct()
    {
        if(self::$colors === null) {
            self::$colors = array();
        }

        if(self::$safeColors === null) {
            $this->generateSafeColors();
        }
    }

    /**
     * Twig extension. Return an attribute to display the color associated with the animal subclass
     * @param Animal $animal An animal subclass to which we return the color bonded to it
     * @return string A 'style' attribute with 'background-color
     */
    public function getAnimalColor($animal)
    {
        if (!is_subclass_of($animal, Animal::class)) {
            return '';
        }

        if (!array_key_exists(get_class($animal), self::$colors)) {
            $index = rand(0, count(self::$safeColors) - 1);
            self::$colors[get_class($animal)] = self::$safeColors[$index];
            array_splice(self::$safeColors, $index, 1);
        }

        $color = self::$colors[get_class($animal)];

        return sprintf(' style="background-color: rgb(%d, %d, %d);" ', $color['r'], $color['g'], $color['b']);
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'addAnimalColor',
                array($this, 'getAnimalColor'),
                array('is_safe' => array('html'))
            )
        );
    }

    public function getName()
    {
        return 'CoreAnimalColorDispenser';
    }

    /**
     * Return true if it is a light color or false.
     *
     * The algorithm comes from 'https://24ways.org/2010/calculating-color-contrast'
     *
     * @param array $color An array holding color information with keys 'r' for red, 'g' for green and 'b' for blue
     * @return bool True if we can write in black on it or False
     */
    private function isLightColor(array $color)
    {
        $yiq = (($color['r'] * 299) + ($color['g'] * 587) + ($color['b'] * 114)) / 1000;

        return ($yiq >= 128);
    }

    /**
     * Generates colors for the $safecolor array
     */
    private function generateSafeColors()
    {
        $currentColor = array('r' => 0, 'g' => 0, 'b' => 0);

        while ($currentColor['r'] != 255)
        {
            if($this->isLightColor($currentColor)) {
                self::$safeColors[] = $currentColor;
            }

            $currentColor['b'] += 51;

            if ($currentColor['b'] > 255) {
                $currentColor['b']  = 0;
                $currentColor['g'] += 51;
            }

            if ($currentColor['g'] > 255) {
                $currentColor['g']  = 0;
                $currentColor['r'] += 51;
            }
        }
    }
}
