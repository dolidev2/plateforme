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
                    new Unique(['message'=> "Ce nom d'utilisateur n'est pas valide "])
                ]
            ])
            ->add('plainpassword',RepeatedType::class,[
                'mapped'=>false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de passe',
                  
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ],
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
