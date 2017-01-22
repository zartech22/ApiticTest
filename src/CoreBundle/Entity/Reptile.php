<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reptile
 *
 * @ORM\Table(name="reptile")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ReptileRepository")
 */
class Reptile extends Animal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function scale()
    {
        return $this->getDescription();
    }

    public function hiss()
    {
        return $this->getSpecies();
    }

    public function __toString()
    {
        return 'Je suis un(e) ' .$this->hiss(). ' et mes écailles sont ' .$this->scale(). '.';
    }
}
