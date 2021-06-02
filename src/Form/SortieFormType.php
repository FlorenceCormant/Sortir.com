<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('date_debut')
            ->add('date_cloture')
            ->add('nb_inscriptions_max')
            ->add('duree')
            ->add('description_infos')
            ->add('noLieu', EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un lieu'])

            ->add('noLieu', EntityType::class, [
            'class' => Lieux::class,
            'choice_label' => 'nom',
            'placeholder' => 'Choisir un lieu'])


        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
