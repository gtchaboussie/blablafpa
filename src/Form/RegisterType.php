<?php

namespace App\Form;

use App\Entity\Student;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegisterType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
    /**
     * {@inheritdoc}
     */
        $builder
            ->add('studentId', TextType::class, $this->getConfiguration('numéro ID', "Votre numéro d'identifiant AFPA"))    
            ->add('studentFirstName', TextType::class, $this->getConfiguration('Prénom', "Votre prénom"))
            ->add('studentLastname', TextType::class, $this->getConfiguration('Nom', "Votre nom"))
            ->add('studentMail', EmailType::class, $this->getConfiguration('Email', "Votre e-mail"))
            ->add('studentPhone', TextType::class, $this->getConfiguration('Téléphone', "Votre numéro de téléphone"))
            ->add('password', PasswordType::class, $this->getConfiguration("Mot de passe", "Votre mot de passe..."))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmation du mot de passe", "Confirmer le mot de passe..."))
            ->add('studentPicture', FileType::class, array('label' => 'Photo de profil', "required" => false))
            ->add('studentDescription', TextareaType::class, $this->getConfiguration("Description", "Présentez vous en quelques mots..."))
            ->add(
                'StudentStartDate', 
                DateType::class, 
                $this->getConfiguration("Date de d'arrivée", "Quand avez-vous commencé votre formation ?"))
            ->add(
                'StudentEndDate', 
                DateType::class, 
                $this->getConfiguration("Date de départ", "Quand finissez-vous votre formation ?")); 
    }  

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}