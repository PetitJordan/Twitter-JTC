<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 05/06/2019
 * Time: 16:30
 */

namespace App\Form\Backoffice\User;


use App\Entity\User\UserGroup;
use App\Utils\User\UserUtils;
use App\Utils\Various\Constant;
use App\Validator\Constraints\Password;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EditType extends \App\Form\User\EditType
{
    protected $userUtils;

    public function __construct(UserUtils $userUtils)
    {
        $this->userUtils = $userUtils;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('submit')
            ->add('roles', ChoiceType::class, array(
                'required'          => true,
                'label'             => 'Rôle',
                'expanded'          => true,
                'multiple'          => true,
                'choices'           => array(
                    'Utilisateur'           => Constant::ROLE_USER,
                    'API'                   => Constant::ROLE_API,
                    'Admin'                 => Constant::ROLE_ADMIN
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label'         => 'Sauvegarder',
                'attr'          => array(
                    'class'         => 'btn btn-success btn-save'
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if (!$user->getId()) {
                $form
                    ->add('rawPassword', PasswordType::class, array(
                        'required'      => true,
                        'label'         => 'Mot de passe*',
                            'constraints'   => array(
                                new Password()
                            )
                    )
                    );
            }

            if ($this->userUtils->isGranted(Constant::ROLE_SUPER_ADMIN)) {
                $form
                    ->remove('roles')
                    ->remove('submit')
                    ->add('roles', ChoiceType::class, array(
                        'required'          => true,
                        'label'             => 'Rôle',
                        'expanded'          => true,
                        'multiple'          => true,
                        'choices'           => array(
                            'Utilisateur'           => Constant::ROLE_USER,
                            'API'                   => Constant::ROLE_API,
                            'Admin'                 => Constant::ROLE_ADMIN,
                            'Super Admin'           => Constant::ROLE_SUPER_ADMIN
                        )
                    ))
                    ->add('submit', SubmitType::class, array(
                        'label'         => 'Sauvegarder',
                        'attr'          => array(
                            'class'         => 'btn btn-success btn-save'
                        )
                    ))
                ;
            }
        });
    }
}
