<?php

namespace App\Form;

use App\Entity\Villes;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class VillesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => ' ',
                'constraints' =>[
                    new Regex("^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$^","Le nom de la ville n'a pas un format correct")
                ]
            ])
            ->add('code_Postal', TextType::class,[
                'label' => ' ',
                'constraints' => [
                    new Regex("^ ((0 [1-9]) | ([1-8] [0-9]) | (9 [0-8]) | (2A) | (2B)) [0-9] {3} $ ^","Le format pour le code postal n'est pas bon")
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Villes::class,
        ]);
    }

}
