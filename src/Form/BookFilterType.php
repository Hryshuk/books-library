<?php

namespace App\Form;

use App\DTO\BookFilterDTO;
use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['required' => false])
            ->add('description', TextType::class, ['required' => false])
            ->add('published', DateType::class,  [
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy'
            ])
            ->add('authorId', EntityType::class, [
                'class' => Author::class,
                'required' => false,
            ])
            ->add('submit', SubmitType::class)
            ->add('reset', ResetType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookFilterDTO::class,
        ]);
    }
}
