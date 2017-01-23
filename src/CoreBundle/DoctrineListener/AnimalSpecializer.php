<?php
/**
 * Created by PhpStorm.
 * User: keke-
 * Date: 23/01/2017
 * Time: 00:55
 */

namespace CoreBundle\DoctrineListener;


use CoreBundle\Entity\Animal;
use CoreBundle\Entity\Bird;
use CoreBundle\Entity\Mammal;
use CoreBundle\Entity\Reptile;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;

class AnimalSpecializer
{
    public function onFlush(OnFlushEventArgs $args)
    {
        $unitOfWork = $args->getEntityManager()->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity)
            if(is_a($entity, Animal::class) && !is_subclass_of($entity, Animal::class))
                $unitOfWork->detach($entity);

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity)
            if(is_a($entity, Animal::class) && !is_subclass_of($entity, Animal::class))
                $unitOfWork->detach($entity);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if(!is_a($entity, Animal::class))
            return;
        if (is_subclass_of($entity, Animal::class))
            return;

        $manager = $args->getObjectManager();

        $replace = null;

        switch ($entity->getType()->getName()) {
            case "Mammifère":
                $replace = new Mammal();
                break;
            case "Reptile":
                $replace = new Reptile();
                break;
            case "Oiseau":
                $replace = new Bird();
                break;
            default:
                return;
        }

        $replace->setName($entity->getName());
        $replace->setType($entity->getType());
        $replace->setSpecies($entity->getSpecies());
        $replace->setDescription($entity->getDescription());

        $manager->persist($replace);
    }
}