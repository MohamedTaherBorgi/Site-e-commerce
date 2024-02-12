<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'Votre Prenom', 'attr' => ['placeholder' => 'Entrer votre Prenom']])
            ->add('lastname', TextType::class, ['label' => 'Votre Nom', 'attr' => ['placeholder' => 'Entrer votre Nom']])
            ->add('email', EmailType::class, ['label' => 'Votre Email', 'attr' => ['placeholder' => 'Entrer votre Email']])
            //->add('roles')
            ->add('password', PasswordType::class, ['label' => 'Votre mot de passe', 'attr' => ['placeholder' => 'Entrer votre mot de passe']])
            ->add('confirm_password', PasswordType::class, ['mapped' => false
                /*To tell Controller don't link it to the Entity User (it doesn't exist */
                , 'label' => 'Confirmer le mot de passe', 'attr' => ['placeholder' => 'Confirmer votre mot de passe']])
            ->add('submit', SubmitType::class, ['label' => "S'inscrire"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
