<?php

namespace App\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;

final class BookAdmin extends AbstractAdmin
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('name', TextType::class)
        ->add('description', TextareaType::class, ['required' => false])
        ->add('published', DateType::class,  ['widget' => 'single_text', 'format' => 'yyyy'])
        ->add('book_cover', FileType::class, ['required' => false])
        ->add('authors', ModelAutocompleteType::class, [
            'required' => false,
            'property' => ['first_name', 'last_name'],
            'multiple' => true,
            'to_string_callback' => function($entity, $property) {
                return $entity->getFirstName() . ' ' . $entity->getLastName();
            },
            'btn_add' => false,
            'minimum_input_length' => 1,
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('name')
        ->add('description')
        ->add('published', DateFilter::class, ['field_options' => ['widget' => 'single_text', 'format' => 'yyyy']])
        ->add('authors');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('name')
        ->addIdentifier('description')
        ->addIdentifier('published', FieldDescriptionInterface::TYPE_DATE, ['format' => 'Y']  )
        ->addIdentifier( 'authors')
        ->addIdentifier( 'book_cover');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('name')
        ->add('description')
        ->add('published', FieldDescriptionInterface::TYPE_DATE, ['format' => 'Y'])
        ->add('book_cover');
    }

    public function preUpdate(object $book): void
    {
//        $authorsArr = [];
//        $authors = $book->getAuthors();
//        foreach ($authors as $author) {
//            $authorsArr[] = $author->getId();
//        }
//        $authorsStr = implode(', ', $authorsArr);

//        $conn = $this->entityManager->getConnection();
//        $sql = '
//        UPDATE `author`
//        SET `books_number`=(
//            SELECT COUNT(`book_author`.`book_id`)
//            FROM `book_author`
//            WHERE `book_author`.`author_id` = `author`.`id`
//        )
//        ';
//        //WHERE a.id IN (SELECT b_a.author_id FROM book_author AS b_a WHERE b_a.book_id = :bookId)
//        $count = $conn->executeUpdate($sql);
//
//        var_dump($count);
//        exit;
    }

}
