<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom*',
                'required' => true,
                'row_attr' => ['class' => 'label-block']
            ])

            ->add('nom', TextType::class, [
                'label' => 'Nom*',
                'required' => true,
                'row_attr' => ['class' => 'label-block']
            ])

            ->add('email', EmailType::class, [
                'label' => 'E-mail*',
                'required' => true,
                'row_attr' => ['class' => ' label-block']
            ])

            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'row_attr' => ['class' => ' label-block']
            ])

            ->add('message', TextareaType::class, [
                'label' => 'Message*',
                'required' => true,
                'row_attr' => ['class' => ' label-block']
            ])

            ->add('save',SubmitType::class, [
                'attr' => ['class' => 'btn-primary'],
                'label_format' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
