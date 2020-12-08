<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Category;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchFormType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cityStart', EntityType::class, [
                'class' => cityStart::class,
                'choice_label' => 'Lieu de départ'
            ])
            ->add('cityGoal', EntityType::class, [
                'class' => cityGoal::class,
                'choice_label' => 'Lieu d\'arrivé'
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('seats', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nombres passager'
                ]
            ])
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}