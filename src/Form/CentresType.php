<?php

namespace App\Form;

use App\Entity\Centres;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'nom du centre',
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
            ->add('localisation',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'localisation',
                ]
            ])
            ->add('ageMin',NumberType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'age minimal de l\'enfant',
                ]
            ])
            ->add('ageMax',NumberType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'age maximal de l\'enfant',
                ]
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
                    'placeholder'=>'legende de la photo de mise en avant',
                ]
            ])
            ->add('photoCadre',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoCadre',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo cadre',
                ]
            ])
            ->add('photoEncadrement',FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoEncadrement',TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class'=>'inputForm',
                    'placeholder'=>'legende de la photo encadrement',
                ]
            ])
            ->add('cadreDeVie',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('Encadrement',CKEditorType::class,[
                'label'=> false,
            ])
            ->add('centrePlus',CKEditorType::class,[
                'label'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Centres::class,
        ]);
    }
}
