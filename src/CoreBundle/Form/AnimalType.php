<?php

namespace CoreBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextType::class, $this->getOptionsArray("Description des écailles / fourrure / plumage de l'animal", 'form-control', 'col-sm-6 control-label'))
            ->add('species', TextType::class, $this->getOptionsArray("Espèce de l'animal", 'form-control', 'col-sm-6 control-label'))
            ->add('name', TextType::class, $this->getOptionsArray("Nom de l'animal", 'form-control', 'col-sm-6 control-label'))
            ->add('type', EntityType::class, $this->getOptionsArray("Spécification de l'animal", 'form-control', 'col-sm-6 control-label',
                array('class' => 'CoreBundle\Entity\AnimalClassification', 'property' => 'name')))
            ->add('save', SubmitType::class, $this->getOptionsArray('Ajouter', 'btn btn-primary', ''));
    }

    /**
     * Returns an option array for FormBuilder::add
     *
     * @param string $label The label to display for the form field
     * @param string|array $class Class attribute as an array or string
     * @param string|array $labelClass Label's class attribute as an array or string
     * @param array $additional Additional options to add
     * @return array The options array for a formtype
     *
     * @see \Symfony\Component\Form\FormBuilder
     */
    private function getOptionsArray($label, $class, $labelClass = "", array $additional = array())
    {
        $options = array();

        $options['label'] = $label;

        if (is_array($class)) {
            $classStr = "";

            foreach ($class as $item)
                $classStr .= $item;

            $class = $classStr;
        }

        if (is_array($labelClass)) {
            $classStr = "";

            foreach ($labelClass as $item)
                $classStr .= $item;

            $labelClass = $classStr;
        }

        $options['attr'] = array('class' => $class);

        if (!empty($labelClass))
            $options['label_attr'] = array('class' => $labelClass);

        return array_merge_recursive($options, $additional);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Animal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_animal';
    }


}
