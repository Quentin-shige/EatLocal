<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true
            ])
           
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Ancien mot de passe',
                'attr' => ['placeholder' => 'Tapez votre mot de passe actuel']
            ])
            ->add('new_password',RepeatedType::class,
             ['type' => PasswordType::class,
             'mapped' => false,
             'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques.',
              'required' => true,
               'first_options' => ['label' => 'Nouveau mot de passe',
                'attr' => ['placeholder' => 'Merci de saisir votre nouveau mot de passe']],
                'second_options'=> ['label' => 'Nouveau mot de passe',
                 'attr' => ['placeholder' => 'Merci de confirmer votre nouveau mot de passe']]])
            ->add('firstname', TextType::class, [
                'disabled' => true
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true
            ])
            ->add('phone')
            ->add('adress')
            ->add('city')
            ->add('age')
            ->add( 'submit', SubmitType::class, [ 'label' => "Confirmer les changements"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
