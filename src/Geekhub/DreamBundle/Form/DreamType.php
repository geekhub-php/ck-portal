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
            ->add('title', 'text', array(
                'label' => 'Нава мрії',
                'max_length' => 70
            ))
            ->add('description', 'textarea', array(
                'label' => 'Опис мрії',
            ))
            ->add('financial', 'collection', array(
                'type' => new FinancialType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Фінансові витрати',
            ))
            ->add('equipment', 'collection', array(
                'type' => new EquipmentType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Інструменти / обладнання / техніка',
            ))
            ->add('work', 'collection', array(
                'type' => new WorkType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Роботи та ресурси',
            ))
            ->add('tagArray', 'text', array(
                'data' => $stringTags,
                'label' => 'Теги',
                'required' => false,
            ))
            ->add('phone', 'text', array(
                'label' => 'Телефон',
            ))
            ->add('phoneAvailable', 'checkbox', array(
                'data' => true,
                'label' => 'Для всіх користувачів'
            ))
            ->add('video', 'collection', array(
                'type' => new \Geekhub\FileBundle\Form\VideoType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Відео',
            ))
            ->add('images', 'collection', array(
                'type' => new \Geekhub\FileBundle\Form\ImageType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Зображення',
            ))
            ->add('mainImage')
            ->add('document', 'collection', array(
                'type' => new \Geekhub\FileBundle\Form\DocumentType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Документи',
            ))
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
