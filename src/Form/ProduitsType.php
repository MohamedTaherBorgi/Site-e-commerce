<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referenceProduits', TextType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9_]+$/',
                        'message' => 'La référence ne peut pas comporter de caractères spéciaux.'
                    ])
                ]
            ])
            ->add('nomProduits', TextType::class)
            ->add('descriptionProduits', TextType::class)
            ->add('prix', MoneyType::class, [
                'constraints' => [
                    new Assert\LessThanOrEqual([
                        'value' => 400,
                        'message' => 'Le prix ne doit pas dépasser 400 DT.'
                    ])
                ]
            ])
            ->add('stock', IntegerType::class, [
                'constraints' => [
                    new Assert\LessThanOrEqual([
                        'value' => 10000,
                        'message' => 'Le stock ne peut pas dépasser 10000.'
                    ])
                ]
            ])
            ->add('imageProduits', TextType::class)
            ->add('typeProduits')
            ->add('categories');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
