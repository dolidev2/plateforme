<?php

namespace App\Form;

use App\Entity\TacheMarketing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('responsable',ChoiceType::class,[
                'label'=>"Responsable",
                'choices'=>[
                    'Abraham' => 'Abraham',
                    'Leila' => 'Leila',
                    'Elsa' => 'Elsa',
                    'Ibrahim' => 'Ibrahim',
                    'Stéphan' => 'Stéphan',
                    'Awa' => 'Awa',
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' =>"Tâche",
                'attr'=>[
                    'class'=>'form-control'
                ],
            ])
            ->add('statut',ChoiceType::class,[
                'label'=>"Statut",
                'choices'=>[
                    'En cours' => '0',
                    'Terminé' => '1',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TacheMarketing::class,
        ]);
    }
}
