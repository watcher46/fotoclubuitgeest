<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateChanged;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gallery", inversedBy="images")
     */
    private $gallery;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionImage", mappedBy="image")
     */
    private $competitionGalleries;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\Column(type="integer")
     */
    private $sortOrder;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="image")
     */
    private $pages;

    public function __construct()
    {
        $this->competitionGalleries = new ArrayCollection();
        $this->pages = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateChanged(): ?\DateTimeInterface
    {
        return $this->dateChanged;
    }

    public function setDateChanged(\DateTimeInterface $dateChanged): self
    {
        $this->dateChanged = $dateChanged;

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

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return Collection|CompetitionGallery[]
     */
    public function getCompetitionGalleries(): Collection
    {
        return $this->competitionGalleries;
    }

    public function addCompetitionGallery(CompetitionGallery $competitionGallery): self
    {
        if (!$this->competitionGalleries->contains($competitionGallery)) {
            $this->competitionGalleries[] = $competitionGallery;
            $competitionGallery->addImage($this);
        }

        return $this;
    }

    public function removeCompetitionGallery(CompetitionGallery $competitionGallery): self
    {
        if ($this->competitionGalleries->contains($competitionGallery)) {
            $this->competitionGalleries->removeElement($competitionGallery);
            $competitionGallery->removeImage($this);
        }

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return Collection|Page[]
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setImage($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
            // set the owning side to null (unless already changed)
            if ($page->getImage() === $this) {
                $page->setImage(null);
            }
        }

        return $this;
    }
}
