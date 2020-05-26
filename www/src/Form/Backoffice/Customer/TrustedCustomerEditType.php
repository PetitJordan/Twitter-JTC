<?php

namespace App\Form\Backoffice\Customer;

use App\Entity\Customer\TrustedCustomer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrustedCustomerEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array(
                'required'          => true,
                'label'             => 'Nom du client *'
            ))
            ->add('logoFile', FileType::class, array(
                'label'         => 'Logo',
                'required'      => false
            ))
            ->add('webUrl', UrlType::class, array(
                'label' => 'Url Web *',
                'required' => true,
            ))
            ->add('submit', SubmitType::class, array(
                'label'                 => 'Sauvegarder',
                'attr'                  => array(
                    'class'                 => 'btn btn-success btn-save'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrustedCustomer::class,
        ]);
    }
}
