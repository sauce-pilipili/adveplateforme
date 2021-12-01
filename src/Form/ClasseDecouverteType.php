<?php

namespace App\Form;

use App\Entity\ClasseDecouverte;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseDecouverteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'nom de la classe',
                ]
            ])
            ->add('metaDescription',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'meta description',
                ]
            ])
            ->add('introduction',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('presentation',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('encadrement',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('hebergement',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('decouverte',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('animation',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('photoEnAvant',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoEnAvant',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo en avant',
                ]
            ])
            ->add('photoClasse',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoClasse',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo classe',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClasseDecouverte::class,
        ]);
    }
}
