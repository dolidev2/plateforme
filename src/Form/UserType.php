<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-lg',
                    'placeholder'=>'Nom de l\'utilisateur'
                ],
                'label'=>'Nom de l\'utilisateur'
            ])
            ->add('prenom',TextType::class,[
                    'attr'=>[
                        'class'=>'form-control form-control-lg',
                        'placeholder'=>'Prénom de l\'utilisateur'
                    ],
                    'label'=>'Prénom de l\'utilisateur'
            ])
            ->add('username',TextType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-lg',
                    'placeholder'=>'Login de l\'utilisateur'
                ],
                'label'=>'Login de l\'utilisateur'
            ])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'class'=>'form-control form-control-lg',
                    'placeholder'=>'Mot de passe de l\'utilisateur'
                ],
                'label'=>'Mot de passe de l\'utilisateur'
            ])
            ->add('service',EntityType::class,[
                "class" => Service::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'choice_label' => 'nomService',
                "attr" =>[
                    "class" =>"form-control form-control-lg",
                ],
                "label" => "Service",
            ])
            ->add('role',ChoiceType::class,[
                'choices'=>[
                    'Assistant' => 'Assistant',
                    'Administrateur' => 'Administrateur'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
