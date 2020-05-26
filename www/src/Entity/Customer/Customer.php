<?php

namespace App\Entity\Customer;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Customer\CustomerRepository")
 *
 * @UniqueEntity("slug", message="Ce nom est déjà utilisé")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $projectName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $concept;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $context;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mission;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $imaginer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $developper;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $accompagner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $webUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="CustomerMedia", mappedBy="customer", orphanRemoval=true, cascade={"persist"})
     */
    private $customerMedias;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $conseiller;



    /**
     * @Assert\Image(
     *     detectCorrupted = true,
     *     corruptedMessage = "Customer logo is corrupted. Upload it again."
     * )
     */
    private $logoFile;

    /**
     * @var array
     */
    private $logoPaths;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer\Expertise", inversedBy="customer")
     */
    private $expertise;

    /**
     * @ORM\Column(type="boolean", nullable  = true)
     */
    private $cas_client;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $conseillerActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $imaginerActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $developperActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accompagnerActive;


    public function __construct()
    {
        $this->expertise = new ArrayCollection();
        $this->position  = 0;
        $this->createdAt = new DateTime('now');
        $this->uid       = uniqid();
        $this->customerMedias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return mixed
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * @param mixed $projectName
     */
    public function setProjectName($projectName): void
    {
        $this->projectName = $projectName;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getConcept(): ?string
    {
        return $this->concept;
    }

    public function setConcept(?string $concept): self
    {
        $this->concept = $concept;

        return $this;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(?string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(?string $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getImaginer(): ?string
    {
        return $this->imaginer;
    }

    public function setImaginer(?string $imaginer): self
    {
        $this->imaginer = $imaginer;

        return $this;
    }

    public function getDevelopper(): ?string
    {
        return $this->developper;
    }

    public function setDevelopper(?string $developper): self
    {
        $this->developper = $developper;

        return $this;
    }

    public function getAccompagner(): ?string
    {
        return $this->accompagner;
    }

    public function setAccompagner(?string $accompagner): self
    {
        $this->accompagner = $accompagner;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getWebUrl(): ?string
    {
        return $this->webUrl;
    }

    public function setWebUrl(?string $webUrl): self
    {
        $this->webUrl = $webUrl;

        return $this;
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

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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

    /**
     * @return Collection|CustomerMedia[]
     */
    public function getCustomerMedias(): Collection
    {
        return $this->customerMedias;
    }
    public function getCustomerMediasByDefault(): Collection
    {
        $criteria = Criteria::create();
        $criteria
            ->orderBy(['defaultPicture' => Criteria::DESC])
        ;

        return $this->customerMedias->matching($criteria);
    }
    public function addCustomerMedia(CustomerMedia $customerMedia): self
    {
        if (!$this->customerMedias->contains($customerMedia)) {
            $this->customerMedias[] = $customerMedia;
            $customerMedia->setCustomer($this);
        }

        return $this;
    }

    public function removeCustomerMedia(CustomerMedia $customerMedia): self
    {
        if ($this->customerMedias->contains($customerMedia)) {
            $this->customerMedias->removeElement($customerMedia);
            // set the owning side to null (unless already changed)
            if ($customerMedia->getCustomer() === $this) {
                $customerMedia->setCustomer(null);
            }
        }

        return $this;
    }

    public function getConseiller(): ?string
    {
        return $this->conseiller;
    }

    public function setConseiller(?string $conseiller): self
    {
        $this->conseiller = $conseiller;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * @param mixed $logoFile
     */
    public function setLogoFile($logoFile): void
    {
        $this->logoFile = $logoFile;
    }

    /**
     * @return array
     */
    public function getLogoPaths(): ?array
    {
        return $this->logoPaths;
    }

    /**
     * @param array $logoPaths
     */
    public function setLogoPaths(array $logoPaths): void
    {
        $this->logoPaths = $logoPaths;
    }

    /**
     * @return Collection|Expertise[]
     */
    public function getExpertise(): Collection
    {
        return $this->expertise;
    }

    public function addExpertise(Expertise $expertise): self
    {
        if (!$this->expertise->contains($expertise)) {
            $this->expertise[] = $expertise;
        }

        return $this;
    }

    public function removeExpertise(Expertise $expertise): self
    {
        if ($this->expertise->contains($expertise)) {
            $this->expertise->removeElement($expertise);
        }

        return $this;
    }

    public function getCasClient(): ?bool
    {
        return $this->cas_client;
    }

    public function setCasClient(bool $cas_client): self
    {
        $this->cas_client = $cas_client;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getConseillerActive(): ?bool
    {
        return $this->conseillerActive;
    }

    public function setConseillerActive(bool $conseillerActive): self
    {
        $this->conseillerActive = $conseillerActive;

        return $this;
    }

    public function getImaginerActive(): ?bool
    {
        return $this->imaginerActive;
    }

    public function setImaginerActive(bool $imaginerActive): self
    {
        $this->imaginerActive = $imaginerActive;

        return $this;
    }

    public function getDevelopperActive(): ?bool
    {
        return $this->developperActive;
    }

    public function setDevelopperActive(bool $developperActive): self
    {
        $this->developperActive = $developperActive;

        return $this;
    }

    public function getAccompagnerActive(): ?bool
    {
        return $this->accompagnerActive;
    }

    public function setAccompagnerActive(bool $accompagnerActive): self
    {
        $this->accompagnerActive = $accompagnerActive;

        return $this;
    }

}
