<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

use App\Entity\Contact;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom*',
                'required' => true,
                'attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12'],
                'row_attr' => ['class' => 'col-lg-6 col-md-6 col-sm-12 label-block', 'id' => '']
            ])

            ->add('nom', TextType::class, [
                'label' => 'Nom*',
                'required' => true,
                'attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12'],
                'row_attr' => ['class' => 'col-lg-6 col-md-6 col-sm-12 label-block', 'id' => '']
            ])

            ->add('email', EmailType::class, [
                'label' => 'E-mail*',
                'required' => true,
                'attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12'],
                'row_attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12 label-block', 'id' => '']
            ])

            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12'],
                'row_attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12 label-block', 'id' => '']
            ])

            ->add('message', TextareaType::class, [
                'label' => 'Message*',
                'required' => true,
                'attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12'],
                'row_attr' => ['class' => 'col-lg-12 col-md-12 col-sm-12 label-block', 'id' => '']
            ])

            ->add('save',SubmitType::class, [
                'attr' => ['class' => 'btn-primary'],
                'label_format' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
