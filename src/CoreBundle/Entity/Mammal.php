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

    public function fur()
    {
        return $this->getDescription();
    }

    public function growl()
    {
        return $this->getSpecies();
    }

    public function __toString()
    {
        return 'Je suis un(e) ' .$this->growl(). ' et ma fourrure est ' .$this->fur(). '.';
    }
}
