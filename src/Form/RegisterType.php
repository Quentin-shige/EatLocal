<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [ 'label' => 'Votre Email',
             'attr' => ['placeholder' => 'Merci de saisir votre Email'],
             'constraints' =>new Length ([ 'min' => 5, 'max' => 45])])
            ->add('password', RepeatedType::class, ['type' => PasswordType::class,
             'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
              'required' => true,
               'first_options' => ['label' => 'Mot de passe', 'attr' => ['placeholder' => 'Merci de saisir votre mot de passe']],
                'second_options'=> ['label' => 'Confirmez votre mot de passe', 'attr' => ['placeholder' => 'Merci de confirmer votre mot de passe']]])
            ->add('firstname', TextType::class, [ 'label' => 'Votre prénom',
             'attr' => ['placeholder' => 'Merci de saisir votre prénom']])
            ->add('lastname', TextType::class, [ 'label' => 'Votre nom',
             'attr' => ['placeholder' => 'Merci de saisir votre nom']])
            ->add('age', NumberType::class, [ 'label' => 'Votre âge',
             'attr' => ['placeholder' => 'Merci de saisir votre âge']])
            ->add('adress', TextType::class, [ 'label' => 'Votre adresse',
             'attr' => ['placeholder' => 'Merci de saisir votre adresse']])
            ->add('city', TextType::class, [ 'label' => 'Votre ville',
             'attr' => ['placeholder' => 'Merci de saisir votre ville']])
            ->add('phone',  TextType::class, [ 'label' => 'Votre numéro de contact',
             'attr' => ['placeholder' => 'Merci de saisir votre numéro de téléphone']])
            ->add( 'submit', SubmitType::class, [ 'label' => "S'inscrire"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
