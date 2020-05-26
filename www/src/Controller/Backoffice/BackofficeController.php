<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 16:31
 */

namespace App\Controller\Backoffice;

use App\Entity\User\User;
use App\Utils\Tools;
use App\Utils\Various\Constant;
use App\Utils\Various\ReturnMsgsUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class BackofficeController extends AbstractController
{
    protected $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
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

    public function ajaxEdit()
    {
        // parametres
        $id = $this->tools->requestStack->getCurrentRequest()->get('id');
        $field = $this->tools->requestStack->getCurrentRequest()->get('field');
        $value = $this->tools->requestStack->getCurrentRequest()->get('value');
        $entity = $this->tools->requestStack->getCurrentRequest()->get('entity');

        if (!$id || !$field || $value == null || !$entity) {
            return new JsonResponse(
                array(
                    'error'         => 1
                )
            );
        }

        // objet
        $object = $this->getDoctrine()->getRepository('App\Entity\\'.$entity)->find($id);
        if (!$object) {
            return new JsonResponse(
                array(
                    'error'         => 1
                )
            );
        }

        // update
        switch ($field) {
            case 'admin':
                $object->setAdmin($value);
                break;
            case 'active':
                $object->setActive($value);
                break;
            case 'defaultImage':
                $object->setDefaultImage($value);
                break;
            case 'cas_client':
                $object->setCasClient($value);
                break;
            case 'pin':
                $object->setPin($value);
                break;
        }
        // sauvegarde
        $this->getDoctrine()->getManager()->persist($object);
        $this->getDoctrine()->getManager()->flush();

        // retour
        return new JsonResponse(
            array(
                'error'         => 0
            )
        );
    }


    public function ajaxSort()
    {
        // paramètres
        $strIds = $this->tools->requestStack->getCurrentRequest()->get('strIds');
        $entity = $this->tools->requestStack->getCurrentRequest()->get('entity');

        if (!$entity || !$strIds) {
            return new JsonResponse(
                array(
                    'error'         => 1,
                    'message'       => ReturnMsgsUtils::GENERIC_ERROR
                )
            );
        }

        // tri
        $ids = explode(',', $strIds);
        foreach ($ids as $key => $id) {
            if ($id) {
                $object = $this->getDoctrine()->getRepository('App\Entity\\'.$entity)->find($id);
                if ($object) {
                    $object->setPosition($key);
                    $this->getDoctrine()->getManager()->persist($object);
                }
            }
        }
        if (is_callable([$object, 'pin'])){
            $objetItem = $this->getDoctrine()->getRepository('App\Entity\\'.$entity)->findOneBy(
                array(
                    'pin'   => true
                )
            );
            if ($objetItem) {
                if ($objetItem->getPosition()) {
                    $objetItem->setPosition(9999);
                };
            }
        }
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            array(
                'message'       => 'Ordre sauvegardé',
                'error'         => 0
            )
        );
    }


    public function ajaxUploadMedia()
    {
        // parametres
        /** @var UploadedFile $fileToUpload */
        $fileToUpload = $this->tools->requestStack->getCurrentRequest()->files->get('fileToUpload');
        if (!in_array($fileToUpload->getClientOriginalExtension(), array('jpg', 'gif', 'png'))) {
            return new JsonResponse(
                array(
                    'success'           => false,
                    'ext'               => $fileToUpload
                )
            );
        }

        $entity = $this->tools->requestStack->getCurrentRequest()->get('entity');
        $id = $this->tools->requestStack->getCurrentRequest()->get('id');
        if (!$entity) {
            return new JsonResponse(
                array(
                    'success'           => false
                )
            );
        }

        // Tente Charger objet
        if ($id) {
            $object = $this->getDoctrine()->getRepository('App\Entity\\' . $entity)->find($id);
        } else {
            $entityStr = 'App\Entity\\' . $entity;
            $object = new $entityStr;
        }

        // chemin du media
        $object->setMediaPaths($this->tools->fileUtils->getMediaPaths($object));

        // nom unique
        $object->setMedia($this->tools->fileUtils->getUniqueFileName(
            array(
                'path'          => $object->getMediaPaths()['folder'],
                'file'          => $fileToUpload
            )
        ));

        // ecriture image
        $this->tools->fileUtils->writeMedia($object, $fileToUpload);

        // chemin du media
        $object->setMediaPaths($this->tools->fileUtils->getMediaPaths($object));

        // ------------------------------------------------------------------
        // encode les resultats
        $data = $this->tools->serializer->serialize(
            array(
                'success'           => true,
                'object'            => $object,
                'pictureUrl'        => $object->getMediaPaths()['domain']['big']
            ),
            'json'
        );

        // retour
        return new JsonResponse($data, 200, array(), true);
    }

    public function ajaxToggleUnique() {
        // parametres
        $id = $this->tools->requestStack->getCurrentRequest()->get('id');
        $field = $this->tools->requestStack->getCurrentRequest()->get('field');
        $value = $this->tools->requestStack->getCurrentRequest()->get('value');
        $entity = $this->tools->requestStack->getCurrentRequest()->get('entity');

        if (!$id || !$field || $value == null || !$entity) {
            return new JsonResponse(
                array(
                    'error'         => 1
                )
            );
        }

        // objet
        $object = $this->getDoctrine()->getRepository('App\Entity\\'.$entity)->toggleUnique(
            array(
                'id'    => $id,
                'field'    => $field,
            )
        );
        $objetItem = $this->getDoctrine()->getRepository('App\Entity\\'.$entity)->find($id);
        if ($objetItem->getPosition()) {
            $objetItem->setPosition(9999);
        };
//        dd($objetItem);
        $this->getDoctrine()->getManager()->persist($objetItem);
        $this->getDoctrine()->getManager()->flush();
        // retour
        return new JsonResponse(
            array(
                'error'         => 0
            )
        );
    }

    public function ajaxDeleteFile()
    {
        // paramètres
        $fileType = $this->tools->requestStack->getCurrentRequest()->get('fileType');
        $entity = $this->tools->requestStack->getCurrentRequest()->get('entity');
        $id = $this->tools->requestStack->getCurrentRequest()->get('id');

        if (!$fileType || !$entity || !$id) {
            return new JsonResponse(
                array(
                    'success'           => false
                )
            );
        }

        try {
            $object = $this->getDoctrine()->getRepository('App\Entity\\' . $entity)->find($id);
            switch ($fileType) {
                case Constant::FILE_TYPE_ATTACHMENT:
                    $this->tools->fileUtils->deleteAttachment($object);
                    break;

                case Constant::FILE_TYPE_MEDIA:
                    $this->tools->fileUtils->deleteMedias($object);
                    break;

                default:
                    return new JsonResponse(
                        array(
                            'success'           => false
                        )
                    );
                    break;
            }

            return new JsonResponse(
                array(
                    'success'           => true
                )
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                array(
                    'success'           => false
                )
            );
        }
    }
}
