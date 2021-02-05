<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomDossier', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom du dossier',
                ],
                'required'=>true
            ])
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Interne' => 'Interne',
                    'Externe' => 'Externe'
                ]
            ]) 
            ->add('descript',TextAreaType::class,[
                'label' =>"Description du dossier",
                'attr'=>[
                    'class'=>'form-control'
                ],
                'required'=>false,
            ])
            ->add('client',TextType::class,[
                'attr'=>[
                    'placeholder'=>"Nom du client si externe"
                ],
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
