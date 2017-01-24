<?php

namespace CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => "Nom de l'animal"))
            ->add(
                'type',
                EntityType::class,
                array(
                    'label' => "Spécification de l'animal",
                    'class' => 'CoreBundle\Entity\AnimalClassification',
                    'choice_label' => 'name'
                )
            )
            ->add('species', TextType::class, array('label' => "Espèce de l'animal"))
            ->add(
                'description',
                TextType::class,
                array('label' => "Description des écailles / fourrure / plumage de l'animal")
            )
            ->add('save', SubmitType::class, array('label' => 'Ajouter'));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'preSetDataListener'));
    }

    /**
     * Listen PRE_SET_DATA form event to change the submit button label if user edits an Animal instead of adding ir
     * @param FormEvent $event
     */
    public function preSetDataListener(FormEvent $event)
    {
        $data = $event->getData();

        if ($data === null)
        {
            return;
        }

        if ($data->getId() !== null)
        {
            $options = $event->getForm()->get('save')->getConfig()->getOptions();

            $event->getForm()->add(
                'save',
                SubmitType::class,
                array_replace($options, array('label' => 'Mettre à jour'))
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CoreBundle\Entity\Animal'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_animal';
    }
}
