<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mammal
 *
 * @ORM\Table(name="mammal")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\MammalRepository")
 */
class Mammal extends Animal
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

    public function fur()
    {
        return $this->getDescription();
    }

    public function setFur($fur)
    {
        $this->setDescription($fur);

        return $this;
    }

    public function growl()
    {
        return $this->getSpecies();
    }

    public function setGrowl($growl)
    {
        $this->setSpecies($growl);

        return $this;
    }

    public function __toString()
    {
        return 'Je suis un(e) ' . $this->growl() . ' et ma fourrure est ' . $this->fur() . '.';
    }
}
