<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:42
 */

namespace App\Controller\Front;

use App\Entity\User\User;
use App\Utils\Breadcrumb;
use App\Utils\Tools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontController extends AbstractController
{
    protected $tools;
    protected $breadcrumb;

    public function __construct(Tools $tools, Breadcrumb $breadcrumb)
    {
        $this->tools = $tools;
        $this->breadcrumb = $breadcrumb;
    }

    public function hasEnoughRole($role)
    {
        $hasAccess = $this->isGranted($role);
        return $hasAccess;
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    }

    public function isHighEnoughToEdit(User $user) {
        $isOk = false;
        foreach ($user->getRoles() as $role) {
            if ($this->hasEnoughRole($role)) {
                $isOk = true;
            }
        }
        return $isOk;
    }

    public function test()
    {
        // rendu template
        return $this->render('test.html.twig', array(

        ));
    }

    /**
     * Change la langue courante
     * @return JsonResponse
     */
    public function ajaxSetLocale()
    {
        $language = $this->tools->requestStack->getCurrentRequest()->get('language');
        $this->tools->requestStack->getCurrentRequest()->setLocale($language);
        $this->tools->requestStack->getCurrentRequest()->getSession()->set('_locale', $language);
        return new JsonResponse(array(
            'success'           => 1
        ));
    }
}
