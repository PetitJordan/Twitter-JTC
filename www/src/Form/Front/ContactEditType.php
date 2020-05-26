<?php

namespace App\Form\Front;

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

class ContactEditType extends AbstractType
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
            ->add('phone',TextType::class, array(
                'required'          => true,
                'label'             => 'Téléphone',
                'attr'  =>
                    array(
                        'placeholder' => "Si vous préférez de vive voix"
                    )
            ))
            ->add('objet',TextType::class, array(
                'required'          => true,
                'label'             => 'Objet',
                'attr'  =>
                    array(
                        'placeholder' => "De quoi voulez-vous parler ?"
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
            ->add('candidature', HiddenType::class, [
                'data' => 0,
            ])
            ->add('rules', CheckboxType::class,
                  array(
                      'label' => "En soumettant ce formulaire, j’accepte que les informations saisies soient exploitées dans 
                    le cadre de ma demande de contact et de la relation commerciale qui peut en découler.",
                      'required'  => true,
                      'attr'  =>
                          array(
                              'class' => "checkmark"
                          )
                  ))
            ->add(
                'submit', SubmitType::class,
                array(
                    'label' => 'Contactez-nous',
                    'attr'  => array(
                        'class' => 'btn-ds-contact'
                    )
                )
            )
            ->add('recaptcha', EWZRecaptchaType::class, array(
                'required'          => true,
                'label'             => false,
                'attr' => array(
                    'options' => array(
                        'theme' => 'light',
                        'type' => 'image',
                        'size' => 'normal',
                        'defer' => true,
                        'async' => true,
                    )
                )
                ,
                'mapped' => false,
                'constraints' => array(
                    new IsTrue()
                )
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }


}
