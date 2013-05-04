<?php

namespace Geekhub\DreamBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Geekhub\DreamBundle\Form\FinancialType;

class DreamAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
        ;

    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('state', 'choice', array(
                'choices'   => array(
                    'open'   => 'open',
                    'close' => 'close',
                    'complete'   => 'complete',
                    'success'   => 'success',
                ))
            )
            ->add('financial', 'collection', array(
                'type' => new FinancialType(),

                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                'label' => 'Фінансові витрати',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('state')
            ->add('owner')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'Назва мрии'))
            ->add('state')
            ->add('owner')
        ;
    }
}