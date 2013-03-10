<?php

namespace Geekhub\FileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link', 'text', array(
                'label' => 'Лінк',
            ))
            ->add('type', 'text', array(
                'label' => 'Формат',
            ))
            ->add('remoteThumbnail', 'text' ,array(
                'label' => 'Мініатюра відео на сервері провайдера'
            ))
            ->add('thumbnail', 'text' ,array(
                'label' => 'Мініатюра на сервері Мрії'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Geekhub\FileBundle\Entity\Video'
        ));
    }

    public function getName()
    {
        return 'geekhub_filebundle_videotype';
    }
}
