<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de la sortie'
                ]
            ])
            ->add('ville', EntityType::class, [
                'required' => false,
                'choice_value' => "id",
                'class' => Villes::class,
                'choice_label' => 'nom',
                'placeholder' => "Tout"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => "get",
            'csrf_protection' => false

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
