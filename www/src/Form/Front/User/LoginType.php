<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 18/06/2018
 * Time: 13:28
 */

namespace App\Form\Front\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginType extends AbstractType
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Nom d'utilisateur
            ->add('_username', EmailType::class, array(
                'required'      => true,
                'label'         => false,
                'attr'          => array(
                    'placeholder'       => 'form.login._username.placeholder'
                )
            ))
            // Mot de passe
            ->add('_password', PasswordType::class, array(
                'required'      => true,
                'label'         => false,
                'attr'          => array(
                    'placeholder'       => 'form.login._password.placeholder'
                )
            ))
            // Case à cocher se souvenir de mpoi
            ->add('_remember_me', CheckboxType::class, array(
                'required'      => false,
                'label'         => 'Se souvenir de moi',
                'attr'          => array(
                    'data-toggle'       => 'toggle',
                    'data-size'         => 'sm',
                    'data-on'           => ' ',
                    'data-off'          => ' ',
                    'data-onstyle'      => 'success',
                    'data-offstyle'     => 'secondary'
                )
            ))
            // champ caché pour redirection après login si besoin
            ->add('_target_path', 'Symfony\Component\Form\Extension\Core\Type\HiddenType')
        ;

        // ecouteur formulaire
        $authUtils = $this->authenticationUtils;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($authUtils) {
            $event->setData(array_replace((array) $event->getData(), array(
                '_username' => $authUtils->getLastUsername(),
            )));
        });
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        /* Note: the form's csrf_token_id must correspond to that for the form login
         * listener in order for the CSRF token to validate successfully.
         */
        $resolver->setDefaults(array(
            'csrf_token_id' => 'authenticate',
        ));
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
