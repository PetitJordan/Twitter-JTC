<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:45
 */

namespace App\Controller\Front;

use App\Entity\User\User;
use App\Form\User\LoginType;
use App\Form\User\RegisterType;
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
            'error'         => $error,
            'form'          => $formLogin->createView(),
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
           'form'               => $form->createView()
        ));
    }
}
