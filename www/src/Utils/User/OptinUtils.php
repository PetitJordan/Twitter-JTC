<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 17/06/2019
 * Time: 14:00
 */

namespace App\Utils\User;


use App\Entity\User\Optin;
use Doctrine\ORM\EntityManagerInterface;

class OptinUtils
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function checkUserUpdatesEmail($newEmail)
    {
        $optin = $this->entityManager->getRepository(Optin::class)->findOneBy(array(
            'email'             => $newEmail
        ));
        if ($optin) {
            $conn = $this->entityManager->getConnection();
            $table = $this->entityManager->getClassMetadata(Optin::class)->getTableName();
            $sql = '
                DELETE FROM 
                '.$table.'
                WHERE email = :email
            ';
            $stmt = $conn->prepare($sql);
            $stmt->execute(array('email' => $newEmail));
        }
    }
}
