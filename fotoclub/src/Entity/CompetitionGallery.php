<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionGalleryRepository")
 */
class CompetitionGallery
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionImage", mappedBy="competitionGallery", cascade={ "persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"sortOrder" = "ASC"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

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
     * @return Collection|CompetitionImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImages(CompetitionImage $images): self
    {
        if (!$this->images->contains($images)) {
            $this->images[] = $images;
            $images->setCompetitionGallery($this);
        }

        return $this;
    }

    public function setImages(Collection $images): self
    {
        if(count($images) > 0) {
            foreach($images as $image) {
                $this->addImages($image);
            }
        }
        return $this;
    }

    public function removeImages(CompetitionImage $images): self
    {
        if ($this->images->contains($images)) {
            $this->images->removeElement($images);
            // set the owning side to null (unless already changed)
            $images->setImage(null);
        }

        return $this;
    }

    /**
     * virtual property
     */
    public function countImages(): int
    {
        return count($this->images);
    }
}
