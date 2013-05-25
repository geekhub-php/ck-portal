<?php

namespace Geekhub\PagesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContactAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('file', 'file', array(
                'label' => 'Зображення контакту',
                'image_path' => 'webPath',
                'required' => false,
            ))
            ->add('contact')
            ->add('position')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Тип контакту (Skype, Life, ICQ ect.)'))
//        TODO: view contact image in field list
//            ->add('webPath', 'image', array('image_path' => 'webPath', 'label' => 'Зображення контакту'))
            ->add('contact', null, array('label' => 'Контакт (телефон, id ect.)'))
            ->add('position', null, array('label' => 'Положення на сторінці'))
        ;
    }
}