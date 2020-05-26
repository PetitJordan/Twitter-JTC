<?php

namespace App\Entity\Customer;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerMediaRepository")
 *
 *  @ORM\Table(indexes={
 *     @ORM\Index(name="active", columns={"active"})
 * })
 */
class CustomerMedia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $timeCreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $timeUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="customerMedias")
     * @ORM\JoinColumn(nullable=false, name="id_customer")
     */
    private $customer;

    /****************************************************************************
     * CHAMPS NON LIES A LA BASE
     */

    /**
     * @Assert\Image(
     *     mimeTypes = {"image/*"},
     *     mimeTypesMessage = "mimtypes.image_bad_format",
     *     detectCorrupted = true,
     *     corruptedMessage = "corrupted.image"
     * )
     */
    private $mediaFile;

    /**
     * @var array
     */
    private $mediaPaths;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

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

    public function setTimeUpdate(\DateTimeInterface $timeUpdate): self
    {
        $this->timeUpdate = $timeUpdate;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMediaFile()
    {
        return $this->mediaFile;
    }

    /**
     * @param mixed $mediaFile
     */
    public function setMediaFile($mediaFile): void
    {
        $this->mediaFile = $mediaFile;
    }

    /**
     * @return array
     */
    public function getMediaPaths(): ?array
    {
        return $this->mediaPaths;
    }

    /**
     * @param array $mediaPaths
     */
    public function setMediaPaths(array $mediaPaths): void
    {
        $this->mediaPaths = $mediaPaths;
    }

    /**
     * @return mixed
     */
    public function getDefaultPicture()
    {
        return $this->defaultPicture;
    }

    /**
     * @param mixed $defaultPicture
     */
    public function setDefaultPicture($defaultPicture): void
    {
        $this->defaultPicture = $defaultPicture;
    }
}
