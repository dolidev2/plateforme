<?php

namespace App\Form;

use App\Entity\Creation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', TextType::class,[
                'label'=>"Annonceur",
                'attr'=>[
                    'placeholder'=>'Nom du client',
                ],
                'required'=>false
            ])
            ->add('description',TextareaType::class,[
                'label' =>"Description",
                'attr'=>[
                    'class'=>'form-control'
                ],
                'required'=>false,
            ])
            ->add('emetteur', TextType::class,[
                'label'=>"Demandeur",
                'attr'=>[
                    'class'=>'form-control',
                ],
                'required'=>true
            ])
            ->add('createdAt',DateType::class,[
                'label'=>'Date',
                'widget'=> "single_text",
                'input_format'=>"yyyy-MM-dd"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Creation::class,
        ]);
    }
}
