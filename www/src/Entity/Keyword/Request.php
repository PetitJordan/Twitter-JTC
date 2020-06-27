<?php

namespace App\Entity\Keyword;

use App\Entity\Keyword\Keyword;
use App\Repository\Keyword\RequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="Request")
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $nbTweet;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
        $this->requests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNbTweet(): ?int
    {
        return $this->nbTweet;
    }

    public function setNbTweet(?int $nbTweet): self
    {
        $this->nbTweet = $nbTweet;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
