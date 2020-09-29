<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('client',TextType::class,[
                'attr'=>[
                    'placeholder'=>"Nom du client si externe"
                ],
                'required'=>false
            ])
            ->add('cout',NumberType::class,[
                'attr'=>[
                    'placeholder'=>"Montant total"
                ],
                'required'=>false,
                'label'=>'Montant TTC devis'
            ])
            ->add('vente',TextType::class,[
                'attr'=>[
                    'placeholder'=>"Prix de vente"
                ],
                'required'=>false,
                'label'=>'Prix de vente'

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
