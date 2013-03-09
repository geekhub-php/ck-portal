<?php

namespace Geekhub\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('originalName', 'text', array(
            'label' => 'Ім’я файлу',
        ))
            ->add('mimeType', 'text', array(
            'label' => 'Формат',
        ))
            ->add('size', 'text', array(
            'label' => 'Розмір файла'
        ))
            ->add('path', 'text', array(
            'label' => 'Лінк',
        ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Geekhub\FileBundle\Entity\Image'
        ));
    }

    public function getName()
    {
        return 'geekhub_filebundle_imagetype';
    }
}
