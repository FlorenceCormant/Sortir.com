<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' => false,
                'class' => Villes::class,
                'choice_label' => 'nom',
                'placeholder' => "Ville"
            ])
            ->add('date', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('orga', CheckboxType::class, [
                'required' => false,

            ])
            ->add('inscrit', CheckboxType::class, [
                'required' => false,

            ])
            ->add('pasInscrit', CheckboxType::class, [
                'required' => false,

            ])
            ->add('passe', CheckboxType::class, [
                'required' => false,

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
