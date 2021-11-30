<?php

namespace App\Form;

use App\Entity\Condoleances;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CondoleancesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur',null,[
                'attr'=>[
                    'placeholder'=>"Nom/Prénom",
                    "class"=>"input"
                    ],
                'row_attr'=>[
                    'class'=>'field'
                ],
                'label_attr'=>[
                    "class"=>"label"
                ],
                'required'=>false
                ])
            ->add('message',null,[
                'attr'=>[
                    'placeholder'=>"Votre message...",
                    "class"=>"textarea"
                ],
                'label_attr'=>[
                    "class"=>"label"
                ],
                'row_attr'=>[
                    'class'=>'field'
                ],
                'required'=>false
                ])
            ->add('Envoyer',SubmitType::class,['attr'=>['class'=>'button is-primary','data-action'=>'send_condoleance']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Condoleances::class,
        ]);
    }
}
