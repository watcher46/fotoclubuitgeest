<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Galerij
 *
 * @ORM\Table(name="galerij")
 * @ORM\Entity
 */
class Galerij
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
     * @var string
     *
     * @ORM\Column(name="naam", type="string", length=255, nullable=false)
     */
    private $naam;

    /**
     * @var string
     *
     * @ORM\Column(name="beschrijving", type="text", length=65535, nullable=false)
     */
    private $beschrijving;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum_gewijzigd", type="date", nullable=false)
     */
    private $datumGewijzigd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum_aangemaakt", type="date", nullable=false)
     */
    private $datumAangemaakt;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    public function getDatumGewijzigd(): ?\DateTimeInterface
    {
        return $this->datumGewijzigd;
    }

    public function setDatumGewijzigd(\DateTimeInterface $datumGewijzigd): self
    {
        $this->datumGewijzigd = $datumGewijzigd;

        return $this;
    }

    public function getDatumAangemaakt(): ?\DateTimeInterface
    {
        return $this->datumAangemaakt;
    }

    public function setDatumAangemaakt(\DateTimeInterface $datumAangemaakt): self
    {
        $this->datumAangemaakt = $datumAangemaakt;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }


}
