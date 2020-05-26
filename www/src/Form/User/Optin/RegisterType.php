<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 17/06/2019
 * Time: 09:37
 */

namespace App\Form\User\Optin;

use App\Entity\User\Optin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'required'          => true,
                'label'             => 'Email'
            ))
            ->add('rules', CheckboxType::class, array(
                'required'          => true,
                'mapped'            => false,
                'label'             => false
            ))
            ->add('submit', SubmitType::class, array(
                'label'             => 'S\'Inscrire à la newsletter',
                'attr'              => array(
                    'class'             => 'btn-gen'
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
            'data_class'    => Optin::class,
        ));
    }
}
