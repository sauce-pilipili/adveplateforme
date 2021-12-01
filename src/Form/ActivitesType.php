<?php

namespace App\Form;

use App\Entity\Activites;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'nom de l\'activité',
                ]
            ])
            ->add('metaDescription',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'meta description',
                ]
            ])
            ->add('description',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('histoire',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('citation',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'citation du sport',
                ]
            ])
            ->add('discipline',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('equipement',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('aptitudes',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('photoEnAvant',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendeEnAvant',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo en avant',
                ]
            ])
            ->add('photoHistoire',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendeHistoire',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo histoire',
                ]
            ])
            ->add('photoDiscipline',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoDiscipline',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo discipline',
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activites::class,
        ]);
    }
}
