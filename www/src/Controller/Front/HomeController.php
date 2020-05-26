<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:43
 */

namespace App\Controller\Front;

use App\Controller\Front\FrontController;
use App\Entity\Contact\Contact;
use App\Form\Front\ContactEditType;
use App\Form\Front\Home\ContactChatType;
use App\Utils\Mail\Mailer;
use App\Utils\Various\ReturnMsgsUtils;

class HomeController extends FrontController
{
    public function home()
    {
        $pageName = 'home';

        $contact  = new Contact();

        // formulaire
        $form = $this->createForm(ContactEditType::class, $contact);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // envoi du mail
                $params = array();
                $params['contact'] = $contact;

//                if ($contact->getAttachment()) {
//                    $params['attachmentFilename'] = $contact->getAttachment();
//                    $params['attachmentPath'] = $contact->getAttachmentPaths()['file'];
//                }
//                dd($contact);

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($contact);
                $this->getDoctrine()->getManager()->flush();
                $this->tools->mailer->send(
                    Mailer::CONTACT,
                    Mailer::CONTACT_EMAIL,
                    $params,
                    array(
                        'reply-to'      => $contact->getEmail()
                    )
                );

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );
                return $this->redirect('/#contact');
                // redirection
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }

        // formulaire
        $formChat = $this->createForm(ContactChatType::class, $contact);
        $formChat->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($formChat->isSubmitted()) {
            if ($formChat->isValid()) {
                // envoi du mail
                $params = array();
                $params['contact'] = $contact;
//                if ($contact->getAttachment()) {
//                    $params['attachmentFilename'] = $contact->getAttachment();
//                    $params['attachmentPath'] = $contact->getAttachmentPaths()['file'];
//                }
                $this->tools->mailer->send(
                    Mailer::CONTACT,
                    Mailer::CONTACT_EMAIL,
                    $params,
                    array(
                        'reply-to'      => $contact->getEmail()
                    )
                );
                // sauvegarde
                $this->getDoctrine()->getManager()->persist($contact);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );
                // redirection
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }
        // rendu template
        return $this->render('front/home/home.html.twig', array(
            'pageName'  => $pageName,
            'formBottom'          => $form->createView(),
            'formChat'          => $formChat->createView(),
        ));
    }
}
