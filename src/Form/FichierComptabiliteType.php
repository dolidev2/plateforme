<?php

namespace App\Form;

use App\Entity\FichierComptabilite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichierComptabiliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',FileType::class,[
                'label'=>'Fichier Joint',
                'attr'=>[
                    'class'=>'form-control'
                ],
                'required' => true,
                'mapped'=> false,
                'multiple'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichierComptabilite::class,
        ]);
    }
}
