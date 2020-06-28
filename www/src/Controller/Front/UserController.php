<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:45
 */

namespace App\Controller\Front;

use App\Entity\User\User;
use App\Form\Front\User\EditType;
use App\Form\Front\User\ChangePasswordType;
use App\Form\Front\User\LoginType;
use App\Form\Front\User\RegisterType;
use App\Repository\User\UserRepository;
use App\Utils\Various\Constant;
use App\Utils\Various\ReturnMsgsUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class UserController extends FrontController
{
    /**
     * Page de login
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $breadcrumb = $this->breadcrumb->add(
            'Identification',
            $this->generateUrl('login')
        );
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // affiche message erreur si besoin
        if ($error && $error->getCode() == 0) {
            $this->addFlash(
                ReturnMsgsUtils::CLASS_ERROR,
                ReturnMsgsUtils::LOGIN_ERROR
            );
        }

        // formulaire de login
        $formLogin = $this->createForm(LoginType::class);

        // Rendu template
        return $this->render('front/user/login.html.twig', array(
            'error' => $error,
            'form' => $formLogin->createView(),
            'breadcrumb' => $breadcrumb,
        ));
    }

    /**
     * Login manuel du user (après inscription par ex)
     * @param User $user
     */
    private function authenticateUser(User $user)
    {
        // logue le user
        $providerKey = 'secured_area';
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);

        // dispatch l'event login
        $this->tools->eventDispatcher->dispatch(
            SecurityEvents::INTERACTIVE_LOGIN,
            new InteractiveLoginEvent($this->tools->requestStack->getCurrentRequest(), $token)
        );
    }

    public function register(UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        // formulaire
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // infos complementaires
                $user->setPassword($passwordEncoder->encodePassword($user, $user->getRawPassword()));

                // enregistrement
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();

                // login user
                $this->authenticateUser($user);

                // redirection home
                return $this->redirectToRoute('index');
            }
        }

        // rendu template
        return $this->render('front/user/register.html.twig', array(
            'form' => $form->createView()
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
                    return $this->redirectToRoute('front/user/edit');
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

               return $this->redirectToRoute('front/user/edit', array('id' => $user->getId()));
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }
        // rendu template
        return $this->render('front/user/editUser.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function changePassword($id, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        // charge user
        $user = $userRepository->find($id);
        /*    if (!$user) {
                return $this->redirectToRoute('backoffice/users');
            }*/
        /* // check que l'admin peu editer ce user
         if (!$this->isHighEnoughToEdit($user)) {
             $this->addFlash(
                 ReturnMsgsUtils::CLASS_ERROR,
                 ReturnMsgsUtils::AUTHORIZATION_ERROR
             );
             return $this->redirectToRoute('backoffice/users');
         }*/

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
    }
}