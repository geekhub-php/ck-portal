<?php

namespace Geekhub\DreamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DreamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $stringTags = '';
        foreach ($options['data']->getTags() as $tag) {
            $stringTags .= $tag->getName().', ';
        }

        $builder
            ->add('title')
            ->add('description')
            ->add('financial', 'collection', array(
                'type' => new FinancialType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('equipment', 'collection', array(
            'type' => new EquipmentType(),

            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            ))
            ->add('work', 'collection', array(
            'type' => new WorkType(),

            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            ))
            ->add('tagArray', 'text', array(
                'data' => $stringTags,
            ))
            ->add('phone')
            ->add('phoneAvailable')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Geekhub\DreamBundle\Entity\Dream'
        ));
    }

    public function getName()
    {
        return 'geekhub_dreambundle_dreamtype';
    }
}
