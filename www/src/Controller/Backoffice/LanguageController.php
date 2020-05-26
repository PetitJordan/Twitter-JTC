<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 20/11/2019
 * Time: 16:56
 */

namespace App\Controller\Backoffice;

use App\Controller\Backoffice\BackofficeController;
use App\Entity\Configuration\Language;
use App\Form\Backoffice\Configuration\Language\LanguageEditType;
use App\Repository\Configuration\LanguageRepository;
use App\Utils\Various\ReturnMsgsUtils;

class LanguageController extends BackofficeController {

	public function list(LanguageRepository $languageRepository)
	{
		$languages = $languageRepository->findBy(
			array(),
			array(
				'position'      => 'ASC'
			)
		);
		foreach ($languages as $language) {
			$language->setMediaPaths($this->tools->fileUtils->getMediaPaths($language));
		}

		// rendu template
		return $this->render('backoffice/configuration/language/list.html.twig', array(
			'languages'              => $languages
		));
	}

	public function edit($id, LanguageRepository $languageRepository)
	{
		$language = null;
		// charge ou nouveau user
		if ($id) {
			$language = $languageRepository->find($id);
		}
		if (!$language) {
			$language = new Language();
		} else {
			$language->setMediaPaths($this->tools->fileUtils->getMediaPaths($language));
		}

		// formulaire
		$form = $this->createForm(LanguageEditType::class, $language);
		$form->handleRequest($this->tools->requestStack->getCurrentRequest());

		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				// si fichier
				if ($form->get('mediaFile')->getData()) {
					$file = $form->get('mediaFile')->getData();

					// chemins
					$language->setMediaPaths($this->tools->fileUtils->getMediaPaths($language));

					// nom du fichier
					$language->setMedia($this->tools->fileUtils->getUniqueFileName(
						array(
							'path'          => $language->getMediaPaths()['folder'],
							'file'          => $file
						)
					));

					// ecriture image
					$this->tools->fileUtils->writeMedia($language, $file);
				}

				// sauvegarde
				$this->getDoctrine()->getManager()->persist($language);
				$this->getDoctrine()->getManager()->flush();

				// message
				$this->addFlash(
					ReturnMsgsUtils::CLASS_SUCCESS,
					ReturnMsgsUtils::SAVE_SUCCESS
				);

				// redirection
				return $this->redirectToRoute('backoffice/config/language/edit', array('id' => $language->getId()));
			} else {
				// message
				$this->addFlash(
					ReturnMsgsUtils::CLASS_ERROR,
					ReturnMsgsUtils::SAVE_ERROR
				);
			}
		}

		// rendu template
		return $this->render('backoffice/configuration/language/edit.html.twig', array(
			'form'          => $form->createView(),
			'language'      => $language
		));
	}
}