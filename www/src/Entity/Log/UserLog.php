<?php

namespace App\Entity\Log;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Log\UserLogRepository")
 *
 * @ORM\Table(indexes={
 *     @ORM\Index(name="id_user", columns={"id_user"}),
 *     @ORM\Index(name="action", columns={"action"})
 * })
 */
class UserLog
{
    const ACTION_LOGIN = 'login';
    const ACTION_AUTOLOGIN = 'autologin';
    const ACTION_LOGOUT = 'logout';
    const ACTION_CREATE = 'create';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="id_user", nullable=true)
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", name="user_agent", length=255, nullable=true)
     */
    private $userAgent;

    /**
     * @ORM\Column(type="datetime", name="time_create")
     * @Gedmo\Timestampable(on="create")
     */
    private $timeCreate;

    /**
     * @ORM\Column(type="date")
     * @Gedmo\Timestampable(on="create")
     */
    private $dateCreate;

    /****************************************************
     * LINKS
     */

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="userLogs")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /****************************************************
     * GETTERS & SETTERS
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getTimeCreate(): ?\DateTimeInterface
    {
        return $this->timeCreate;
    }

    public function setTimeCreate(\DateTimeInterface $timeCreate): self
    {
        $this->timeCreate = $timeCreate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @param mixed $dateCreate
     */
    public function setDateCreate($dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
