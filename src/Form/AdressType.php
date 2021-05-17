<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [ 'label' => 'Quel est le nom de cette adresse?', 'attr' => [
                'placeholder' => 'Nom de l\'adresse',
            ]])
            ->add('firstname',TextType::class, [ 'label' => 'Prénom', 'attr' => [
                'placeholder' => 'Prénom',
            ]])
            ->add('lastname',TextType::class, [ 'label' => 'Nom', 'attr' => [
                'placeholder' => 'Nom',
            ]])
            ->add('company',TextType::class, [ 'label' => 'Entreprise', 'required' => false, 'attr' => [
                'placeholder' => '(facultatif)',
            ]])
            ->add('adress',TextType::class, [ 'label' => 'Adresse', 'attr' => [
                'placeholder' => 'Adresse',
            ]])
            ->add('postal',TextType::class, [ 'label' => 'Code postal', 'attr' => [
                'placeholder' => 'Code postal',
            ]])
            ->add('city',TelType::class, [ 'label' => 'Ville', 'attr' => [
                'placeholder' => 'Ville',
            ]])
            
            ->add('phone',TextType::class, [ 'label' => 'Numéro de téléphone', 'attr' => [
                'placeholder' => 'Numéro de téléphone',
            ]])
            ->add( 'submit', SubmitType::class, [
                'label' => 'Ajouter',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
