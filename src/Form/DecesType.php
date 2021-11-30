<?php

namespace App\Form;

use App\Entity\Deces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class DecesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite',Choicetype::class,[
                'label'=>false,
                'empty_data' => 'M.',
                'choices'  => [
                    'M.' => 'M.',
                    'Mme.' => 'Mme.',
                    'Melle.' => 'Melle.',
                ],
                'row_attr'=>['class'=>'field select is-fullwidth'],
                'label_attr'=>['class'=>'label']
            ])
            ->add('nom',null,[
                'attr'=>['class'=>'input'],
                'label_attr'=>['class'=>'label'],
                'row_attr'=>['class'=>'field'],
            ])
            ->add('prenom',null,[
                'attr'=>['class'=>'input'],
                'label_attr'=>['class'=>'label'],
                'row_attr'=>['class'=>'field'],
            ])
            ->add('naissance',BirthdayType::class,[
                'label'=>'Date de naissance','widget'=>'single_text','input'=>'string',
                'attr'=>['class'=>'input'],
                'label_attr'=>['class'=>'label'],
                'row_attr'=>['class'=>'field'],
            ])
            ->add('date',BirthdayType::class,[
                'label'=>'Date du décès','widget'=>'single_text','input'=>'string',
                'attr'=>['class'=>'input'],
                'label_attr'=>['class'=>'label'],
                'row_attr'=>['class'=>'field'],
            ])
            ->add('message',TextareaType::class,[
                'attr'=>['class'=>'textarea'],
                'label_attr'=>['class'=>'label'],
                'row_attr'=>['class'=>'field'],
            ])
            ->add('Ajouter',SubmitType::class,[
                'attr'=>['class'=>'button is-primary is-fullwidth'],
                'row_attr'=>['class'=>'field'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deces::class,
        ]);
    }
}
