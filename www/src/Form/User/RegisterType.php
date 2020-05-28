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
                    'Homme'          => 1,
                    'Femme'          => 2
                ),
                'expanded'      => true
            ))
            ->add('lastname', TextType::class, array(
                'required'      => true,
                'label'         => 'Nom',
            ))
            ->add('firstname', TextType::class, array(
                'required'      => true,
                'label'         => 'Prénom',
            ))
            ->add('email', EmailType::class, array(
                'required'      => true,
                'label'         => 'Email'
            ))
            ->add('rawPassword', RepeatedType::class, array(
                'required'      => true,
                'type'          => PasswordType::class,
                'invalid_message' => 'Merci de rentrer deux mots de passe identiques',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
	            'label'          => false,
	            'constraints'    => array(
	            	new Password()
	            )
            ))
            ->add('birthdate', BirthdayType::class, array(
                'required'      => false,
                'label'         => 'Date de naissance',
                'widget'        => 'choice'
            ))
            ->add('phone', TextType::class, array(
                'required'      => false,
                'label'         => 'Téléphone'
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
