<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionImageRepository")
 */
class CompetitionImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sortOrder;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompetitionGallery", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="competition_gallery_id", referencedColumnName="id", nullable=false)
     */
    private $competitionGallery;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="competitionGalleries")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     */
    private $image;

    public function __toString(): string
    {
        return $this->image->getName() . ' - ' . $this->image->getMember()->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitionGallery(): ?CompetitionGallery
    {
        return $this->competitionGallery;
    }

    public function setCompetitionGallery(?CompetitionGallery $competitionGallery): self
    {
        $this->competitionGallery = $competitionGallery;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }
}
