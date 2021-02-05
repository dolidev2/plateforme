<?php

namespace App\Form;

use App\Entity\ProgrammeMarketing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut',DateType::class,[
                'label'=>'Date de début',
                'widget'=> "single_text",
                'input_format'=>"yyyy-MM-dd"
            ])
            ->add('dateFin',DateType::class,[
                'label'=>'Date de fin',
                'widget'=> "single_text",
                'input_format'=>"yyyy-MM-dd"
            ])
            ->add('tacheMarketings', CollectionType::class,[
                'entry_type' => TacheType::class,
                'prototype'			=> true,
                'allow_add'			=> true,
                'allow_delete'		=> true,
                'by_reference' 		=> false,
                'required'			=> false,
                'label'			=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgrammeMarketing::class,
        ]);
    }
}
