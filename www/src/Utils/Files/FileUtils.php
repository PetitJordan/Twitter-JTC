<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 19/04/2018
 * Time: 10:29
 */

namespace App\Utils\Files;

use App\Utils\Various\Constant;
use App\Utils\Various\ToolString;
use Doctrine\ORM\EntityManagerInterface;

class FileUtils
{
    protected $toolString;
    protected $packageUtils;
    protected $entityManager;

    public function __construct(ToolString $toolString, PackageUtils $packageUtils, EntityManagerInterface $entityManager)
    {
        $this->toolString = $toolString;
        $this->packageUtils = $packageUtils;
        $this->entityManager = $entityManager;
    }


    /**
     * Le tableau des formats d'images
     * @return array
     */
    public function getMediaFormats($entity = null)
    {
        if (method_exists($entity,'getMediaFormats')) {
            return $entity->getMediaFormats();
        }
        return array(
            'original'      => array(
                'width'         => false,
                'height'        => false,
                'crop'          => false
            ),
            'big'           => array(
                'width'         => 810,
                'height'        => 690,
                'crop'          => true,
            ),
            'backoffice'      => array(
                'width'         => 265,
                'height'        => 174,
                'crop'          => true
            ),
            'thumbnail'      => array(
                'width'         => 400,
                'height'        => 275,
                'crop'          => true
            ),
            'thumbnail_crop'  => array(
                'width'         => 365,
                'height'        => 365,
                'crop'          => true
            ),
            'thumbnail_customer'  => array(
                'width'         => 640,
                'height'        => 300,
                'crop'          => true
            ),
            'icon'  => array(
                'width'         => 50,
                'height'        => 50,
                'crop'          => true
            ),
            'grille_customer'  => array(
                'width'         => 400,
                'height'        => 580,
                'crop'          => true
            ),
            'conseiller'  => array(
                'width'         => 675,
                'height'        => 450,
                'crop'          => true
            ),
        );
    }

    /**
     * Le tableau des formats du logo
     * @return array
     */
    public function getLogoFormats($entity = null)
    {
        if (method_exists($entity,'getLogoFormats')) {
            return $entity->getLogoFormats();
        }
        return array(
            'original'      => array(
                'width'         => false,
                'height'        => false,
                'crop'          => false
            ),
            'icon'  => array(
                'width'         => 50,
                'height'        => 50,
                'crop'          => true
            ),
            'testimony'  => array(
                'width'         => 400,
                'height'        => 600,
                'crop'          => true
            ),
        );
    }

    /**
     * Retourne le dossier d'une entité
     * @param $entity
     * @return string
     */
    public function getEntityFolder($entity)
    {
        $entityName = $this->entityManager->getMetadataFactory()->getMetadataFor(get_class($entity))->getName();
        // si l'entité à un folder spécifié
        if(defined($entityName.'::FOLDER')){
            return $entity::FOLDER;
        }

        // sinon on prends le nom de l'entité
        return strtolower(substr($entityName, strrpos($entityName, '\\') + 1));
    }

    /**
     * Donne les chemins du media d'une entité
     * @param $entity
     * @return array|bool
     */
    public function getMediaPaths($entity)
    {
        if (!method_exists($entity,'getMedia')) {
            return false;
        }

        $paths = array(
            'domain'        => array(),
            'file'          => array(),
            'filename'      => array(),
            'folder'        => $this->packageUtils->getUploadDir().$this->getEntityFolder($entity).'/'
        );
        foreach ($this->getMediaFormats($entity) as $key => $format) {
            $paths['domain'][$key] = $this->packageUtils->getSharedUrl(Constant::UPLOAD_FOLDER.'/'.$this->getEntityFolder($entity).'/'.$this->addFormatToFilename($entity->getMedia(), $key), true);
//            dd($paths);
            $paths['file'][$key] = $this->packageUtils->getUploadDir().''.$this->getEntityFolder($entity).'/'.$this->addFormatToFilename($entity->getMedia(), $key);
            $paths['filename'][$key] = $this->addFormatToFilename($entity->getMedia(), $key);
        }

        return $paths;
    }

    /**
     * Donne les chemins du logo d'une entité
     * @param $entity
     * @return array|bool
     */
    public function getLogoPaths($entity)
    {
        if (!method_exists($entity,'getLogo')) {
            return false;
        }

        $paths = array(
            'domain'        => array(),
            'file'          => array(),
            'filename'      => array(),
            'folder'        => $this->packageUtils->getUploadDir().$this->getEntityFolder($entity).'/'
        );
        foreach ($this->getLogoFormats($entity) as $key => $format) {
            $paths['domain'][$key] = $this->packageUtils->getSharedUrl(Constant::UPLOAD_FOLDER.'/'.$this->getEntityFolder($entity).'/'.$this->addFormatToFilename($entity->getLogo(), $key), true);
            $paths['file'][$key] = $this->packageUtils->getUploadDir().''.$this->getEntityFolder($entity).'/'.$this->addFormatToFilename($entity->getLogo(), $key);
            $paths['filename'][$key] = $this->addFormatToFilename($entity->getLogo(), $key);
        }

        return $paths;
    }

    /**
     * Donne les chemins de la piece jointe d'une entité
     * @param $entity
     * @return array|bool
     */
    public function getAttachmentPaths($entity)
    {
        if (!method_exists($entity,'getAttachment')) {
            return false;
        }

        $paths = array(
            'domain'        => $this->packageUtils->getSharedUrl(Constant::UPLOAD_FOLDER.'/'.$this->getEntityFolder($entity).'/'.$entity->getAttachment()),
            'file'          => $this->packageUtils->getUploadDir().''.$this->getEntityFolder($entity).'/'.$entity->getAttachment(),
            'folder'        => $this->packageUtils->getUploadDir().$this->getEntityFolder($entity).'/'
        );

        return $paths;
    }

    /**
     * Ecriture media
     * @param $entity
     * @param $file
     * @return bool
     * @throws \ImagickException
     */
    public function writeMedia($entity, $file)
    {
        if (!method_exists($entity,'getMedia')) {
            return false;
        }

        // recupère les chemins
        $entity->setMediaPaths($this->getMediaPaths($entity));

        // créer repertoire si besoin
        $this->createFolder(
            array(
                'path'          => $entity->getMediaPaths()['folder'],
            )
        );

        // move file
        $file->move(
            $entity->getMediaPaths()['folder'],
            $entity->getMediaPaths()['file']['original']
        );

        // resizes
        foreach ($this->getMediaFormats($entity) as $key => $format) {
            if ($key == 'original') {
                continue;
            }
            $imagick = new \Imagick($entity->getMediaPaths()['file']['original']);
            if ($format['crop']) {
                $imagick->cropThumbnailImage($format['width'], $format['height']);
            } else {
                $imagick->adaptiveResizeImage($format['width'], $format['height'], true);
            }
            $imagick->writeImage($entity->getMediaPaths()['file'][$key]);
            unset($imagick);
        }

        return true;
    }
    /**
     * Ecriture logo
     * @param $entity
     * @param $file
     * @return bool
     * @throws \ImagickException
     */
    public function writeLogo($entity, $file)
    {
        if (!method_exists($entity,'getLogo')) {
            return false;
        }

        // recupère les chemins
        $entity->setLogoPaths($this->getLogoPaths($entity));

        // créer repertoire si besoin
        $this->createFolder(
            array(
                'path'          => $entity->getLogoPaths()['folder'],
            )
        );

        // move file
        $file->move(
            $entity->getLogoPaths()['folder'],
            $entity->getLogoPaths()['file']['original']
        );

        // resizes
        foreach ($this->getLogoFormats($entity) as $key => $format) {
            if ($key == 'original') {
                continue;
            }
            $imagick = new \Imagick($entity->getLogoPaths()['file']['original']);
            if ($format['crop']) {
                $imagick->cropThumbnailImage($format['width'], $format['height']);
            } else {
                $imagick->adaptiveResizeImage($format['width'], $format['height'], true);
            }
            $imagick->writeImage($entity->getLogoPaths()['file'][$key]);
            unset($imagick);
        }

        return true;
    }

    /**
     * Ecriture piece jointe
     * @param $entity
     * @param $file
     * @return bool
     */
    public function writeAttachment($entity, $file)
    {
        if (!method_exists($entity,'getAttachment')) {
            return false;
        }

        // recupère les chemins
        $entity->setAttachmentPaths($this->getAttachmentPaths($entity));

        // créer repertoire si besoin
        $this->createFolder(
            array(
                'path'          => $entity->getAttachmentPaths()['folder'],
            )
        );

        // move file
        $file->move(
            $entity->getAttachmentPaths()['folder'],
            $entity->getAttachmentPaths()['file']
        );

        return true;
    }

    /**
     * Pour supprimer les formats d'un media d'une entité
     * @param $entity
     * @return bool
     */
    public function deleteMedias($entity) {
        if (!method_exists($entity,'getMedia')) {
            return false;
        }
        if (!$entity->getMedia()) {
            return false;
        }

        // recupère les chemins
        $entity->setMediaPaths($this->getMediaPaths($entity));

        // boucle sur les formats
        foreach ($entity->getMediaPaths()['file'] as $file) {
            // essaye de supprimer
            try{
                unlink($file);
            } catch (\Exception $exception) {

            }
        }
    }

    /**
     * Pour supprimer les formats d'un logo d'une entité
     * @param $entity
     * @return bool
     */
    public function deleteLogos($entity) {
        if (!method_exists($entity,'getLogo')) {
            return false;
        }
        if (!$entity->getLogo()) {
            return false;
        }

        // recupère les chemins
        $entity->setLogoPaths($this->getLogoPaths($entity));

        // boucle sur les formats
        foreach ($entity->getLogoPaths()['file'] as $file) {
            // essaye de supprimer
            try{
                unlink($file);
            } catch (\Exception $exception) {

            }
        }
    }

    /**
     * Suppression piece jointe
     * @param $entity
     * @return bool
     */
    public function deleteAttachment($entity) {
        if (!method_exists($entity,'getAttachment')) {
            return false;
        }
        if (!$entity->getAttachment()) {
            return false;
        }

        // recupère les chemins
        $entity->setAttachmentPaths($this->getAttachmentPaths($entity));

        // essaye de supprimer
        try{
            unlink($entity->getAttachmentPaths()['file']);
        } catch (\Exception $exception) {

        }
    }

    /**
     * Rajoute le format au nom de fichier
     * @param $filename
     * @param $format
     * @return string
     */
    public function addFormatToFilename($filename, $format)
    {
        if ($format == 'original') {
            return $filename;
        } else {
            return $this->removeExtension($filename).'-'.$format.'.'.$this->getExtension($filename);
        }

    }

    /**
     * Donne un nom de fichier unique pour un dossier
     * @param array|null $params
     * @return bool|string
     */
    public function getUniqueFileName(array $params = null)
    {

        if (!isset($params['path']) || $params['path'] == '' || !isset($params['file'])) {
            return false;
        }

        $path = $params['path'];
        $file = $params['file'];
        $prefix = (isset($params['prefix'])) ? $params['prefix'] : '';
        $extension = (isset($params['extension']))
            ? '.'.strtolower($params['extension'])
            : '.'.strtolower($this->getExtension($params['file']->getClientOriginalName()));

        $fileName = $prefix.$this->toolString->getSlug($this->removeExtension($file->getClientOriginalName())).$extension;
        $newFileName = $fileName;

        $j = 1;
        while (file_exists($path.$newFileName)) {
            $newFileName =
                $j.'-'.$prefix.$this->toolString->getSlug($this->removeExtension($file->getClientOriginalName())).$extension;
            $j = $j + 1;
        }

        return $newFileName;
    }

    /**
     * Recupere l'extension d'une chaine (pour un nom de fichier)
     * @param String $fichier, nom du fichier
     * @return String
     * @author RB 2012_05
     */
    public function getExtension($fichier)
    {
        $filename_from_url = parse_url($fichier);
        $ext = pathinfo($filename_from_url['path'], PATHINFO_EXTENSION);
        return strtolower($ext);
    }

    /**
     * Retire l'extension d'une chaine (pour un nom de fichier)
     * @param String $fichier, nom du fichier
     * @return String
     * @author RB 2012_05
     */
    public function removeExtension($fichier)
    {
        $bouts = explode('.', $fichier);
        return strtolower($bouts[0]);
    }

    /**
     * Fonction qui créer un répertoire
     * @param array, $params, tableau de paramètres
     * @param String, $params['path'], repertoire à créer
     * @return Boolean, true or false
     * @author RB 2013_11
     */
    public function createFolder(array $params = null)
    {

        if (!isset($params['path'])) {
            return false;
        }

        if (is_dir($params['path'])) {
            @chmod($params['path'], 0777);
            return true;
        } else {
            mkdir($params['path'], 0777, true);
            chmod($params['path'], 0777);
            return true;
        }
    }
}