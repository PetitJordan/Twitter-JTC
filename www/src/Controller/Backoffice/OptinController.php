<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 14/06/2019
 * Time: 16:50
 */

namespace App\Controller\Backoffice;

use App\Repository\User\OptinRepository;
use App\Utils\Various\ReturnMsgsUtils;

class OptinController extends BackofficeController
{
    public function list(OptinRepository $optinRepository)
    {
        // optins
        $optins = $optinRepository->findBy(
            array(

            ),
            array(
                'timeCreate'            => 'DESC'
            )
        );

        // rendu template
        return $this->render('backoffice/user/optin/list.html.twig', array(
            'optins'            => $optins
        ));
    }

    public function delete($id, OptinRepository $optinRepository)
    {
        // optin
        $optin = $optinRepository->find($id);

        // supprime
        $this->getDoctrine()->getManager()->persist($optin);
        $this->getDoctrine()->getManager()->flush();

        // message
        $this->addFlash(
            ReturnMsgsUtils::CLASS_SUCCESS,
            ReturnMsgsUtils::DELETE_SUCCESS
        );

        // redirection
        return $this->redirectToRoute('backoffice/user/optins');
    }
}
