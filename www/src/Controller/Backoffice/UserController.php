<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 11/09/2019
 * Time: 14:03
 */

namespace App\Controller\Backoffice;
use App\Controller\Backoffice\BackofficeController;
use App\Entity\User\User;
use App\Form\Backoffice\User\EditType;
use App\Form\User\ChangePasswordType;
use App\Repository\User\UserRepository;
use App\Utils\Various\Constant;
use App\Utils\Various\ReturnMsgsUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends BackofficeController
{
    public function listUser(UserRepository $userRepository)
    {
        // recupere les users
        $users = $userRepository->findAll();

        // rendu template
        return $this->render('backoffice/user/listUser.html.twig', array(
            'users'         => $users
        ));
    }

    public function editUser($id, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $user = null;
        // charge ou nouveau user
        if ($id) {
            $user = $userRepository->find($id);
            if ($user) {
                // check que l'admin peu editer ce user
                if (!$this->isHighEnoughToEdit($user)) {
                    $this->addFlash(
                        ReturnMsgsUtils::CLASS_ERROR,
                        ReturnMsgsUtils::AUTHORIZATION_ERROR
                    );
                    return $this->redirectToRoute('backoffice/users');
                }
            }
        }
        if (!$user) {
            $user = new User();
        }

        // formulaire
        $form = $this->createForm(EditType::class, $user);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // si nouveau utilisateur
                if (!$user->getId() && $form->get('rawPassword')->getData()) {
                    // infos complementaires
                    $user->setIdStatus(Constant::STATUS_VALIDATE);
                    $user->setPassword($passwordEncoder->encodePassword($user, $user->getRawPassword()));
                }

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

//                return $this->redirectToRoute('backoffice/user/edit', array('id' => $user->getId()));
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }
        // rendu template
        return $this->render('backoffice/user/editUser.html.twig', array(
            'form'              => $form->createView()
        ));
    }

    public function changePassword($id, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        // charge user
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->redirectToRoute('backoffice/users');
        }
        // check que l'admin peu editer ce user
        if (!$this->isHighEnoughToEdit($user)) {
            $this->addFlash(
                ReturnMsgsUtils::CLASS_ERROR,
                ReturnMsgsUtils::AUTHORIZATION_ERROR
            );
            return $this->redirectToRoute('backoffice/users');
        }

        // formulaire
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // confirmation fausse
                $rawNewPassword = $form->get('newPassword')->getData();
                $rawConfirmPassword = $form->get('confirmPassword')->getData();

                if ($rawNewPassword != $rawConfirmPassword) {
                    $this->addFlash(
                        ReturnMsgsUtils::CLASS_ERROR,
                        ReturnMsgsUtils::PASSWORD_MISSMATCH
                    );
                } else { // confirmation ok
                    // update du password
                    $user->setRawPassword($rawNewPassword);
                    $user->setPassword($passwordEncoder->encodePassword($user, $user->getRawPassword()));

                    $this->getDoctrine()->getManager()->persist($user);
                    $this->getDoctrine()->getManager()->flush();

                    // message retour
                    $this->addFlash(
                        ReturnMsgsUtils::CLASS_SUCCESS,
                        ReturnMsgsUtils::PASSWORD_UPDATE_SUCCESS
                    );
                }
            }
        }

        // rendu template
        return $this->render('backoffice/user/change-password.html.twig', array(
            'user'          => $user,
            'form'          => $form->createView()
        ));
    }
}