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
    private $colors;

    private static $safeColors;

    public function __construct()
    {
        $this->colors = array();

        if(self::$safeColors === null)
            $this->generateSafeColors();
    }

    public function getAnimalColor($animal)
    {
        if (!is_subclass_of($animal, Animal::class))
            return '';

        if (!array_key_exists(get_class($animal), $this->colors)) {
            $index = rand(0, count(self::$safeColors) - 1);
            $this->colors[get_class($animal)] = self::$safeColors[$index];
            unset(self::$safeColors[$index]);
        }

        $color = $this->colors[get_class($animal)];

        return sprintf(' style="background-color: rgb(%d, %d, %d);" ', $color['r'], $color['g'], $color['b']);
    }

    public function getFunctions()
    {
        return array(new \Twig_SimpleFunction('addAnimalColor', array($this, 'getAnimalColor'), array('is_safe' => array('html'))));
    }

    public function getName()
    {
        return 'CoreAnimalColorDispenser';
    }

    private function isLightColor($hexColor)
    {
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));

        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return ($yiq >= 128);
    }

    private function rgbToHex(array $color)
    {
        $hex = array();

        $hex['r'] = dechex($color['r']);
        $hex['g'] = dechex($color['g']);
        $hex['b'] = dechex($color['b']);

        $result = $hex['r'] . $hex['g'] . $hex['b'];

        return $result;
    }

    private function generateSafeColors()
    {
        $currentColor = array('r' => 0, 'g' => 0, 'b' => 0);

        while ($currentColor['r'] != 255)
        {
            if($this->isLightColor($this->rgbToHex($currentColor)))
                self::$safeColors[] = $currentColor;

            $currentColor['b'] += 51;

            if ($currentColor['b'] > 255) {
                $currentColor['b'] = 0;
                $currentColor['g'] += 51;
            }

            if ($currentColor['g'] > 255) {
                $currentColor['g'] = 0;
                $currentColor['r'] += 51;
            }
        }
    }
}