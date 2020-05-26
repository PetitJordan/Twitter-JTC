<?php

namespace App\Form\Front\Home;

use App\Entity\Contact\Contact;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname',TextType::class, array(
                'required'          => true,
                'label'             => 'Nom',
                'attr'  =>
                    array(
                        'placeholder' => "Doe"
                    )
            ))
            ->add('firstname',TextType::class, array(
                'required'          => true,
                'label'             => 'Prénom',
                'attr'  =>
                    array(
                        'placeholder' => "John"
                    )
            ))
            ->add('email',EmailType::class, array(
                'required'          => true,
                'label'             => 'Email',
                'attr'  =>
                    array(
                        'placeholder' => "Pour pouvoir nous contacter"
                    )
            ))
            ->add('message', TextareaType::class,
                array(
                    'label'    => 'Message',
                    'required' => false,
                    'attr'  =>
                        array(
                            'placeholder' => "Précisez votre demande"
                        )
                )
            )
            ->add(
                'submit', SubmitType::class,
                array(
                    'label' => 'Contactez-nous',
                    'attr'  => array(
                        'class' => 'btn-ds-contact'
                    )
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
    public function getBlockPrefix()
    {
        return 'contactFormChat';
    }
}
