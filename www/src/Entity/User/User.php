<?php

namespace App\Entity\User;

use App\Entity\Addressing\Address;
use App\Entity\Log\UserLog;
use App\Entity\Ordering\Order;
use App\Utils\Various\Constant;
use App\Validator\Constraints\AdultOnly;
use App\Validator\Constraints\EmailTrash;
use App\Validator\Constraints\Password;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 * @UniqueEntity("email", message="Cet email est déjà inscrit")
 * @UniqueEntity("apiToken", message="Ce token est déjà inscrit")
 *
 * @ORM\Table(indexes={
 *     @ORM\Index(name="gender", columns={"gender"}),
 *     @ORM\Index(name="email", columns={"email"}),
 *     @ORM\Index(name="birthdate", columns={"birthdate"}),
 *     @ORM\Index(name="id_status", columns={"id_status"})
 * })
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $apiToken;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $gender;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Email()
     * @EmailTrash()
     */
    private $email;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     * @AdultOnly()
     */
    private $birthdate;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $timeCreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $timeUpdate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $timeLastLogin;

    /**
     * @ORM\Column(type="integer")
     */
    private $idStatus;

    /****************************************************************************
     * CHAMPS NON LIES A LA BASE
     */

    /**
     * @var string
     * @Password(groups={"register", "change-password"});
     */
    private $rawPassword;

    /****************************************************************************
     * LIAISONS AVEC AUTRES ENTITES
     */


    /**
     * @var ArrayCollection|UserLog[]
     * @ORM\OneToMany(targetEntity="App\Entity\Log\UserLog", mappedBy="user")
     * @Serializer\Exclude()
     */
    private $userLogs;

    /****************************************************************************
     * CONSTRUCT
     */

    public function __construct()
    {
        $this->userLogs = new ArrayCollection();
    }


    /****************************************************************************
     * GETTERS & SETTERS
     */


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * @param string $apiToken
     */
    public function setApiToken(?string $apiToken): void
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @return int
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTime $birthdate
     */
    public function setBirthdate(?\DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }


    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        if (count($this->roles) == 0) {
            $this->addRole(Constant::ROLE_USER);
        }
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    public function getTimeUpdate(): ?\DateTimeInterface
    {
        return $this->timeUpdate;
    }

    public function setTimeUpdate(?\DateTimeInterface $timeUpdate): self
    {
        $this->timeUpdate = $timeUpdate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimeLastLogin(): \DateTime
    {
        return $this->timeLastLogin;
    }

    /**
     * @param \DateTime $timeLastLogin
     */
    public function setTimeLastLogin(\DateTime $timeLastLogin): void
    {
        $this->timeLastLogin = $timeLastLogin;
    }

    public function getIdStatus(): ?int
    {
        return $this->idStatus;
    }

    public function setIdStatus(int $idStatus): self
    {
        $this->idStatus = $idStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawPassword(): ?string
    {
        return $this->rawPassword;
    }

    /**
     * @param string $rawPassword
     */
    public function setRawPassword(string $rawPassword): void
    {
        $this->rawPassword = $rawPassword;
    }

    /**
     * @return UserLog|ArrayCollection
     */
    public function getUserLogs()
    {
        return $this->userLogs;
    }

    /**
     * @param UserLog|ArrayCollection $userLogs
     */
    public function setUserLogs($userLogs): void
    {
        $this->userLogs = $userLogs;
    }

    /****************************************************************************
     * FONCTIONS SPECIFIQUES
     */

    /**
     * Verifie si le user a un role
     * @param $role
     * @return bool
     */
    public function hasRole($role) {
        foreach ($this->roles as $thisRole) {
            if ($thisRole == $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * Ajoute un role
     * @param $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return string|void|null
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

}
