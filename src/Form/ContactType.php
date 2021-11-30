<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expediteur',null,[
                'attr'=>['class'=>'input','placeholder'=>'Nom/prénom'],
                'row_attr'=>['class'=>'field'],
                'label'=>false,
                'required'=>false
            ])
            ->add('email',null,[
                'attr'=>['class'=>'input','placeholder'=>'Adresse mail'],
                'row_attr'=>['class'=>'field'],
                'label'=>false,
                'required'=>false
            ])
            ->add('telephone',null,[
                'attr'=>['class'=>'input','placeholder'=>'Numéro de téléphone'],
                'row_attr'=>['class'=>'field'],
                'label'=>false,
                'required'=>false
            ])
            ->add('message',null,[
                'attr'=>['class'=>'textarea','placeholder'=>'Votre message...'],
                'row_attr'=>['class'=>'field'],
                'label'=>false,
                'required'=>false
            ])
            ->add('Envoyer',SubmitType::class,['attr'=>['class'=>'button is-primary is-fullwidth']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
