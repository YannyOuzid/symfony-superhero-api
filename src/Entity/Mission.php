<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="missions")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $priority;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $release_date = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity=Villain::class, inversedBy="missions")
     */
    private $wicked;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="missions")
     */
    private $hero;

    public function __construct()
    {
        $this->wicked = new ArrayCollection();
        $this->hero = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate($release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Villain[]
     */
    public function getWicked(): Collection
    {
        return $this->wicked;
    }

    public function addWicked(Villain $wicked): self
    {
        if (!$this->wicked->contains($wicked)) {
            $this->wicked[] = $wicked;
        }

        return $this;
    }

    public function removeWicked(Villain $wicked): self
    {
        $this->wicked->removeElement($wicked);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getHero(): Collection
    {
        return $this->hero;
    }

    public function addHero(User $hero): self
    {
        if (!$this->hero->contains($hero)) {
            $this->hero[] = $hero;
        }

        return $this;
    }

    public function removeHero(User $hero): self
    {
        $this->hero->removeElement($hero);

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
