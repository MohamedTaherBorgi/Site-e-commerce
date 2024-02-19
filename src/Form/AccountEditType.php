<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\AgeUnder18;

// Or just call /DateType from global classes(namespaces) and then you have to use 'data' => new /DateTime('today')

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AccountEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom :',
                'required' => true,
                'attr' => ['placeholder' => 'Entrer votre Prénom'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom.',
                    ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Votre prénom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Votre prénom ne peut contenir que des lettres.',
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom :',
                'required' => true,
                'attr' => ['placeholder' => 'Entrer votre Nom'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom.',
                    ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Votre nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ]+$/',
                        'message' => 'Votre nom ne peut contenir que des lettres.',
                    ])
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Votre Email :',
                'disabled' => true,
                // Don't use this FUCKING BITCH it returns null. 'attr' => ['disabled' => 'disabled'] FUCKING BITCH
            ])
            //->add('roles')
            ->add('date_of_birth', DateType::class, [
                'years' => range(date('Y') - 100, date('Y')), // Allow selection of past 100 years
                'data' => $options['data']->getDateOfBirth(), // To fill user's date
                'constraints' => [
                    new AgeUnder18()
                ]
            ])
            ->add('address', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre addresse (État & Ville).',
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, ['label' => "Sauvegarder"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}