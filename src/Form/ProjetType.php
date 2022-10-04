<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;

use App\Entity\Projet;
use App\Entity\Tag;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('annee', IntegerType::class, [
                'label' => 'Année',
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('introduction', TextareaType::class, [
                'label' => 'Introduction',
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('couverture', FileType::class, [
                'label' => 'Image de couverture',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '3000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Seulement les images sont autorisées',
                    ])
                ],

                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => 'couverture']
            ])

            ->add('couverture_bg_white', ChoiceType::class, [
                'label' => 'Couverture avec un fond blanc',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'libelle',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.libelle', 'ASC');
                },
                'multiple' => true,
                'expanded' => true,
                'label' => 'Tags',
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => 'form-tags']
            ])

            ->add('lien', UrlType::class, [
                'label' => 'Lien',
                'required' => false,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('github', UrlType::class, [
                'label' => 'GitHub',
                'required' => false,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('etat', ChoiceType::class, [
                'label' => 'État',
                'choices' => [
                    'Actif' => true,
                    'Inactif' => false,
                ],
                'expanded' => true,
                'required' => true,
                'attr' => ['class' => ''],
                'row_attr' => ['class' => '', 'id' => '']
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn'],
                'row_attr' => ['class' => '', 'id' => '']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
