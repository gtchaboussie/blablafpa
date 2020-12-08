<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'cityStart', 
                TextType::class, 
                $this->getConfiguration("Ville de départ", "Tapez votre ville de départ"))
            ->add(
                'cityGoal', 
                TextType::class, 
                $this->getConfiguration("Ville d'arrivée", "Tapez votre ville d'arrivée"))
            ->add(
                'dateStart', 
                DateType::class, 
                $this->getConfiguration("Date de départ", "Quand partez-vous ?"))
            ->add(
                'hourStart', 
                TimeType::class, 
                $this->getConfiguration("Heure de départ", "A quelle heure vous partez ?"))
            ->add(
                'seats', 
                ChoiceType::class, [
                    'choices' => [
                        '1' => 1,
                        '2' => 2,
                        '3' => 3,
                        '4' => 4,
                        '5' => 5,
                        '6' => 6,
                    ],
                ])
            ->add(
                'content', 
                TextareaType::class, 
                $this->getConfiguration("Description", "Tapez une description qui donne envie", ["required" => false]));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingType::class,
        ]);
    }
}
