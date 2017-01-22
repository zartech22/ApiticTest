<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 *
 * @ORM\Table(name="bird")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\BirdRepository")
 */
class Bird extends Animal
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

    public function feathers()
    {
        return $this->getDescription();
    }

    public function tweet()
    {
        return $this->getSpecies();
    }

    public function __toString()
    {
        return 'Je suis un(e) ' .$this->tweet(). ' et ma fourrure est ' .$this->feathers(). '.';
    }
}
