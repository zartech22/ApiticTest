<?php
/**
 * Created by PhpStorm.
 * User: keke-
 * Date: 23/01/2017
 * Time: 00:55
 */

namespace CoreBundle\DoctrineListener;

use CoreBundle\Entity\Animal;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;

/**
 * Doctrine's Listener class.
 *
 * Handles Animal's persists and updates by finding which subclass the entity is and
 * transform it to it's subclass. Listen to 'onFlush' and 'prePersist'
 *
 * Class AnimalSpecializer
 * @package CoreBundle\DoctrineListener
 */
class AnimalSpecializer
{
    /**
     * Prevents Animal's entity to be persisted or updated
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $unitOfWork = $args->getEntityManager()->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity)
        {
            if (is_a($entity, Animal::class) && !is_subclass_of($entity, Animal::class))
            {
                $unitOfWork->detach($entity);
            }
        }

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity)
        {
            if (is_subclass_of($entity, Animal::class) && (get_class($entity) !== $entity->getType()->getClassName()))
            {
                $args->getEntityManager()->persist($this->specialize($entity));
                $args->getEntityManager()->remove($entity);
                $args->getEntityManager()->flush();
            }
        }
    }

    /**
     * Get the entity and if it is an Animal entity persist an Animal's subclass
     * based on its data depending of its type
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!is_a($entity, Animal::class))
        {
            return;
        }

        if (is_subclass_of($entity, Animal::class))
        {
            return;
        }

        $manager = $args->getObjectManager();

        $manager->persist($this->specialize($entity));
    }

    /**
     * Returns an Animal's subclass based on its type attribute
     * @param Animal $entity
     * @return Animal Subclass of Animal based on the entity's type attribute
     */
    private function specialize($entity)
    {
        $className = $entity->getType()->getClassName();

        $specialized = new $className();

        $specialized->setName($entity->getName());
        $specialized->setType($entity->getType());
        $specialized->setSpecies($entity->getSpecies());
        $specialized->setDescription($entity->getDescription());

        return $specialized;
    }
}
