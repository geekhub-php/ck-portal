<?php

namespace Geekhub\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete')
        ;

    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username')
            ->add('email')
            ->add('locked', 'checkbox', array(
                'required' => false,
                'label' => 'Бан',
                'help' => 'Якщо увімкнути, користувач буде заблокований')
            )
            ->add('banReason', 'textarea', array(
                'required' => false,
                'label' => 'Причина',
                'help' => 'Причина за якою заблоковано користувача')
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('username')
            ->add('email')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Як звати'))
            ->add('username')
            ->add('email')
            ->add('lastLogin', null, array('label' => 'Останній раз на сайті'))
            ->add('locked', null, array('label' => 'Бан'))
        ;
    }
}