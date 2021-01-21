<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Unique;

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
                'label'=>'Login de l\'utilisateur',
                'constraints'=>
                [
                    new NotBlank(['message'=>"Le nom d'utilisateur ne doit pas être vide"]),
                  
                ]
            ])
            ->add('password',PasswordType::class,[
                'label' => 'Mot de passe',
                'attr'=>[
                    'placeholder'=>'Entrez le mot de passe'
                ],
                'constraints'=>
                [
                    new Length(['min'=>6])
                ]
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
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
