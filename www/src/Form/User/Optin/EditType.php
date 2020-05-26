<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 14/06/2019
 * Time: 15:52
 */

namespace App\Form\User\Optin;

use App\Entity\User\Optin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', CheckboxType::class, array(
                'required'      => false,
                'label'         => 'form.optin.active',
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
            'data_class'    => Optin::class,
            'required'      => false
        ));
    }
}
