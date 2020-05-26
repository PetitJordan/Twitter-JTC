<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 05/06/2019
 * Time: 15:23
 */

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, array(
                'required'      => true,
                'label'         => 'Titre*',
                'choices'       => array(
                    'M.'            => 1,
                    'Mme.'          => 2
                ),
                'expanded'      => true
            ))
            ->add('lastname', TextType::class, array(
                'required'      => true,
                'label'         => 'Nom*',
            ))
            ->add('firstname', TextType::class, array(
                'required'      => true,
                'label'         => 'Prénom*',
            ))
            ->add('email', EmailType::class, array(
                'required'      => true,
                'label'         => 'Email*'
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
            ->add('optin', \App\Form\User\Optin\EditType::class, array(
                'label'         => false
            ))
            // bouton
            ->add('submit', SubmitType::class, array(
                'label'         => 'Sauvegarder',
                'attr'          => array(
                    'class'         => 'btn btn-success btn-save'
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
            'data_class' => User::class,
            'validation_groups' => ['Default','edit'],
        ));
    }
}
