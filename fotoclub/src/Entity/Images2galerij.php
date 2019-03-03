<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Images2galerij
 *
 * @ORM\Table(name="images2galerij", indexes={@ORM\Index(name="image_id", columns={"image_id"}), @ORM\Index(name="galerij_id", columns={"galerij_id"})})
 * @ORM\Entity
 */
class Images2galerij
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     */
    private $imageId;

    /**
     * @var int
     *
     * @ORM\Column(name="galerij_id", type="integer", nullable=false)
     */
    private $galerijId;

    /**
     * @var string
     *
     * @ORM\Column(name="naam", type="string", length=255, nullable=false)
     */
    private $naam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function setImageId(int $imageId): self
    {
        $this->imageId = $imageId;

        return $this;
    }

    public function getGalerijId(): ?int
    {
        return $this->galerijId;
    }

    public function setGalerijId(int $galerijId): self
    {
        $this->galerijId = $galerijId;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }


}
