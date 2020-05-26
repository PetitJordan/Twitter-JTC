<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 03/06/2019
 * Time: 14:22
 */

namespace App\Form\User;

use App\Entity\User\Optin;
use App\Entity\User\User;
use App\Validator\Constraints\Password;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, array(
                'required'      => true,
                'label'         => 'form.register.gender',
                'choices'       => array(
                    'form.register.gender.choices.1'          => 1,
                    'form.register.gender.choices.2'          => 2
                ),
                'expanded'      => true
            ))
            ->add('lastname', TextType::class, array(
                'required'      => true,
                'label'         => 'form.register.lastname',
            ))
            ->add('firstname', TextType::class, array(
                'required'      => true,
                'label'         => 'form.register.firstname',
            ))
            ->add('email', EmailType::class, array(
                'required'      => true,
                'label'         => 'form.register.email'
            ))
            ->add('rawPassword', RepeatedType::class, array(
                'required'      => true,
                'type'          => PasswordType::class,
                'invalid_message' => 'form.errors.password.mustMatch',
                'first_options'  => ['label' => 'form.register.rawPassword'],
                'second_options' => ['label' => 'form.register.confirmPassword'],
	            'label'          => false,
	            'constraints'    => array(
	            	new Password()
	            )
            ))
            ->add('birthdate', BirthdayType::class, array(
                'required'      => false,
                'label'         => 'form.register.birthdate',
                'widget'        => 'choice'
            ))
            ->add('phone', TextType::class, array(
                'required'      => false,
                'label'         => 'form.register.phone'
            ))
            ->add('optin', \App\Form\User\Optin\EditType::class, array(
                'label'         => false
            ))
            ->add('rules', CheckboxType::class, array(
                'required'      => true,
                'mapped'        => false,
                'label'         => false,
                'attr'          => array(
                    'data-toggle'       => 'toggle',
                    'data-size'         => 'sm',
                    'data-on'           => ' ',
                    'data-off'          => ' ',
                    'data-onstyle'      => 'success',
                    'data-offstyle'     => 'secondary'
                )
            ))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}
