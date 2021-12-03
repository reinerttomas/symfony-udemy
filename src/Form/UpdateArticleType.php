<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add(
                'content',
                TextareaType::class,
                [
                    'attr' => ['rows' => 6]
                ]
            )
            ->add(
                'publishedAt',
                DateType::class,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Save'
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateArticleRequest::class,
        ]);
    }
}
