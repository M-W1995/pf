<?php

namespace App\Form;

use App\Entity\Marbrerie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MarbrerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, [
                'attr'=>['placeholder'=>'Nom de la plaque','class'=>'input'],
                'row_attr'=>['class'=>'field'],
                'label_attr'=>['class'=>'label']
            ])
            ->add('photo',FileType::class,[
                'mapped'=>false,'attr'=>['placeholder'=>'Choisir une photo','class'=>'input'],
                'row_attr'=>['class'=>'field'],
                'label_attr'=>['class'=>'label']
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr'=>['class'=>'button is-primary is-fullwidth'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Marbrerie::class,
        ]);
    }
}
