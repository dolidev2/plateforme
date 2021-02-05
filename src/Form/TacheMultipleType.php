<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheMultipleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('tacheMarketings', CollectionType::class,[
            'entry_type' => TacheType::class,
            'prototype'			=> true,
            'allow_add'			=> true,
            'allow_delete'		=> true,
            'by_reference' 		=> false,
            'required'			=> false,
            'label'			=> false,
            'mapped'=>false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
