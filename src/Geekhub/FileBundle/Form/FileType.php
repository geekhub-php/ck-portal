<?php

namespace Geekhub\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Ім’я файлу',
            ))
            ->add('path', 'text', array(
                'label' => 'Лінк',
            ))
            ->add('type', 'text', array(
                'label' => 'Формат',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Geekhub\FileBundle\Entity\File'
        ));
    }

    public function getName()
    {
        return 'geekhub_filebundle_filetype';
    }
}
