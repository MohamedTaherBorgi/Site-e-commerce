<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\AgeUnder18;
use DateTime;

// Or just call /DateType from global classes(namespaces)
// and then you have to use 'data' => new /DateTime('today')

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom :',
                'attr' => ['placeholder' => 'Entrer votre Prénom'],
                'constraints' => [
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Votre prénom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Votre prénom ne peut contenir que des lettres',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom :',
                'attr' => ['placeholder' => 'Entrer votre Nom'],
                'constraints' => [
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Votre nom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Votre nom ne peut contenir que des lettres',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email :',
                'attr' => ['placeholder' => 'Entrer votre Email'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre adresse e-mail.',
                    ]),
                    new Email([
                        'message' => 'L\'adresse e-mail "{{ value }}" n\'est pas valide.',
                    ]),
                ],
            ])
            //->add('roles')
            ->add('date_of_birth', DateType::class, [
                'years' => range(date('Y') - 100, date('Y')), // Allow selection of past 100 years
                'data' => new \DateTime('today'),
                'constraints' => [
                    new AgeUnder18(),
                ],
            ])
            ->add('address', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez confirmer votre mot de passe',
                'required' => true, //it's not necessary since it can't be null in the User entity
                'first_options' => ['label' => 'Ajouter un mot de passe :', 'attr' => ['placeholder' => 'Entrer votre mot de passe']],
                'second_options' => ['label' => 'Confirmer le mot de passe :', 'attr' => ['placeholder' => 'Confirmer votre mot de passe']]
            ])
            ->add('submit', SubmitType::class, ['label' => "S'inscrire"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}