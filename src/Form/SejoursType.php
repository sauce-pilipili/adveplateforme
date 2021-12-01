<?php

namespace App\Form;

use App\Entity\Activites;
use App\Entity\Centres;
use App\Entity\DureeSejour;
use App\Entity\Saisons;
use App\Entity\Sejours;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SejoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'titre du séjour',
                ]
            ])
            ->add('metaDescription', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'meta description',
                ]
            ])
            ->add('introduction', CKEditorType::class, [
                'label' => false,
            ])
            ->add('ageMin', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'age minimal de l\'enfant',
                ]
            ])
            ->add('ageMax', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'age maximal de l\'enfant',
                ]
            ])
            ->add('prixMin', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'prix minimal du séjour',
                ]
            ])
            ->add('cadreDeVie', CKEditorType::class, [
                'label' => false,
            ])
            ->add('Encadrement', CKEditorType::class, [
                'label' => false,
            ])
            ->add('plusDuSejour', CKEditorType::class, [
                'label' => false,
            ])
            ->add('indispensables', CKEditorType::class, [
                'label' => false,
            ])
            ->add('activitesDominantes', CKEditorType::class, [
                'label' => false,
            ])
            ->add('activitesAnnexes', CKEditorType::class, [
                'label' => false,
            ])
            ->add('photoEnAvant', FileType::class, [
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoEnAvant', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'legende de la photo de mise en avant',
                ]
            ])
            ->add('photoCadre', FileType::class, [
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoCadre', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'legende de la photo cadre de vie',
                ]
            ])
            ->add('photoEncadrement', FileType::class, [
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoEncadrement', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'inputForm',
                    'placeholder' => 'legende de la photo encadrement',
                ]
            ])
            ->add('dateSejour', CKEditorType::class, [
                'label' => false,
            ])
            ->add('saisons', EntityType::class, [
                'class' => Saisons::class,
                'label' => false,
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('dureeSejour', EntityType::class, [
                'class' => DureeSejour::class,
                'label' => false,
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('activite', EntityType::class, [
                'class' => Activites::class,
                'label' => false,
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('centre', EntityType::class, [
                'class' => Centres::class,
                'label' => false,
                'attr' => [
                    'class' => 'inputForm'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sejours::class,
        ]);
    }
}
