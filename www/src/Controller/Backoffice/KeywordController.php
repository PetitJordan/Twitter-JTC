<?php

namespace App\Controller\Backoffice;

use App\Entity\Keyword\Keyword;
use App\Entity\Keyword\Request;
use App\Form\Front\Keyword\KeywordEditType;
use App\Repository\Keyword\KeywordRepository;
use App\Repository\Keyword\RequestRepository;
use App\Service\TwitterService;
use App\Utils\Various\ReturnMsgsUtils;


class KeywordController extends BackofficeController
{
    public function listKeyword(KeywordRepository $KeywordRepository)
    {
        $keywords = $KeywordRepository->findAll();

        return $this->render('front/keyword/listKeyword.html.twig', array(
            'keywords' => $keywords
        ));
    }

    public function editKeyword($id, KeywordRepository $keywordRepository)
    {
        $keyword = null;
        // charge ou nouveau keyword
        if ($id) {
            $keyword = $keywordRepository->find($id);
        }
        if (!$keyword) {
            $keyword = new Keyword();
        }

        // formulaire
        $form = $this->createForm(KeywordEditType::class, $keyword);
        $form->handleRequest($this->tools->requestStack->getCurrentRequest());
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                // sauvegarde
                $this->getDoctrine()->getManager()->persist($keyword);
                $this->getDoctrine()->getManager()->flush();

                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_SUCCESS,
                    ReturnMsgsUtils::SAVE_SUCCESS
                );

                // redirection
                return $this->redirectToRoute('keywords',
                    array('id' => $keyword->getId()
                    )
                );
            } else {
                // message
                $this->addFlash(
                    ReturnMsgsUtils::CLASS_ERROR,
                    ReturnMsgsUtils::SAVE_ERROR
                );
            }
        }

        // rendu template
        return $this->render('front/keyword/editKeyword.html.twig', array(
            'form' => $form->createView(),
            'keyword' => $keyword
        ));
    }

    public function deleteKeyword($id, KeywordRepository $keywordRepository)
    {
        $keyword = $keywordRepository->find($id);

        if ($keyword != null) {
            $this->getDoctrine()->getManager()->remove($keyword);
            $this->getDoctrine()->getManager()->flush();

            // message
            $this->addFlash(
                ReturnMsgsUtils::CLASS_SUCCESS,
                ReturnMsgsUtils::DELETE_SUCCESS
            );
        } else {
            $this->addFlash(
                ReturnMsgsUtils::CLASS_ERROR,
                ReturnMsgsUtils::DELETE_ERROR
            );
        }
        return $this->redirectToRoute('keywords');
    }
}
