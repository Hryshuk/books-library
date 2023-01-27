<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class AuthorAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('first_name', TextType::class)
        ->add('last_name', TextType::class)
        ->add('books', ModelAutocompleteType::class, [
            'required' => false,
            'property' => 'name',
            'multiple' => true,
            'to_string_callback' => function($entity, $property) {
                return $entity->getName();
            },
            'btn_add' => false,
            'minimum_input_length' => 1,
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('first_name')
        ->add('last_name')
        ->add('books_number');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('first_name')
        ->addIdentifier('last_name')
        ->addIdentifier('books_number');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('first_name')
        ->add('last_name')
        ->add('books_number');
    }
}
