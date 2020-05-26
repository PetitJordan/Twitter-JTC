<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 26/02/2019
 * Time: 11:22
 */

namespace App\Form\User;

use App\Validator\Constraints\Password;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', PasswordType::class, array(
                'required'      => true,
                'label'         => 'Nouveau mot de passe',
                'constraints'   => array(
                    new Password()
                )
            ))
            ->add('confirmPassword', PasswordType::class, array(
                'required'      => true,
                'label'         => 'Confirmer le nouveau mot de passe'
            ))
            ->add('submit', SubmitType::class, array(
                'label'         => 'Enregistrer',
                'attr'          => array(
                'class'             => 'btn btn-success btn-save'
                )
            ))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {

    }
}
