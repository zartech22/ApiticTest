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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return parent::getId();
    }

    public function scale()
    {
        return $this->getDescription();
    }

    public function setScale($scale)
    {
        $this->setDescription($scale);

        return $this;
    }

    public function hiss()
    {
        return $this->getSpecies();
    }

    public function setHiss($hiss)
    {
        $this->setSpecies($hiss);

        return $this;
    }

    public function __toString()
    {
        return 'Je suis un(e) ' .$this->hiss(). ' et mes écailles sont ' .$this->scale(). '.';
    }
}
