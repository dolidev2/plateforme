<?php

namespace App\Form;

use App\Entity\Commercial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommercialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom du dossier',
                ],
                'required'=>true
            ])
            ->add('description',TextareaType::class,[
                'label' =>"Description du dossier",
                'attr'=>[
                    'class'=>'form-control'
                ],
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commercial::class,
        ]);
    }
}
