<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Votre Mot de passe actuel :',
                'attr' => ['placeholder' => 'Entrer votre mot de passe'],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit avoir au moins {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre mot de passe.',
                    ])
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez confirmer votre mot de passe',
                'required' => false, //it's not necessary since it can't be null in the User entity
                'first_options' => ['label' => 'Ajouter un nouveau mot de passe :', 'attr' => ['placeholder' => 'Entrer votre mot de passe']],
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe :', 'attr' => ['placeholder' => 'Confirmer votre mot de passe']],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit avoir au moins {{ limit }} caractères.'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez entrer votre mot de passe.',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => "Sauvegarder"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
