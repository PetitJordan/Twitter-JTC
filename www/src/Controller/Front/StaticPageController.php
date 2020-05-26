<?php

namespace App\Controller\Front;

use App\Entity\Contact\Contact;
use App\Form\Front\ContactEditType;
use App\Repository\Team\TeamRepository;
use App\Utils\Mail\Mailer;
use App\Utils\Various\ReturnMsgsUtils;

class StaticPageController extends FrontController
{
    public function QuiSommesNous()
    {

        $breadcrumb = $this->breadcrumb->add(
            'Notre agence',
            ''
        );
        $breadcrumb = $this->breadcrumb->add(
            'Qui sommes-nous',
            $this->generateUrl('front/qui-sommes-nous')
        );


        return $this->render('front/staticPage/quiSommesNous.html.twig', [
            'controller_name' => 'StaticPageController',
            'breadcrumb' => $breadcrumb,
        ]);
    }

    public function History()
    {
        $breadcrumb = $this->breadcrumb->add(
            'Notre agence',
            ''
        );
        $breadcrumb = $this->breadcrumb->add(
            'Notre histoire',
            $this->generateUrl('front/histoire')
        );
        return $this->render('front/staticPage/history.html.twig', [
            'controller_name' => 'StaticPageController',
            'breadcrumb' => $breadcrumb,
        ]);
    }
    public function Policy()
    {
        return $this->render('front/staticPage/policy.html.twig', [
            'controller_name' => 'StaticPageController',
        ]);
    }
    public function LegalNotice()
    {
        return $this->render('front/staticPage/legalNotice.html.twig', [
            'controller_name' => 'StaticPageController',
        ]);
    }

    public function equipe(TeamRepository $teamRepository)
    {
        $staffs = $teamRepository->findBy(
            array(
                'active' => 1,
            ),
            array(
                'position' => 'ASC'
            )
        );

        $classCSS = ['one', 'two', 'three', 'four'];

        foreach ($staffs as $staff) {
            $staff->setMediaPaths($this->tools->fileUtils->getMediaPaths($staff));
        }
        $breadcrumb = $this->breadcrumb->add(
            'Notre agence',
            ''
        );
//        dd($staffs);
        $breadcrumb = $this->breadcrumb->add(
            'L\'équipe',
            $this->generateUrl('front/equipe')
        );
        return $this->render('front/staticPage/equipe.html.twig', [
            'controller_name' => 'StaticPageController',
            'breadcrumb' => $breadcrumb,
            'staffs'    => $staffs
        ]);

    }

    public function methodologie()
    {

        $contact  = new Contact();

        // formulaire
        $form = $this->createForm(ContactEditType::class, $contact);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // envoi du mail
                $params = array();
                $params['contact'] = $contact;

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

                // redirection
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }

        $breadcrumb = $this->breadcrumb->add(
            "Notre méthodologie",
            $this->generateUrl('front/methodologie')
        );

        return $this->render('front/staticPage/methodologie.html.twig', [
            'form'          => $form->createView(),
            'controller_name' => 'StaticPageController',
            'breadcrumb' => $breadcrumb,
        ]);
    }
}
