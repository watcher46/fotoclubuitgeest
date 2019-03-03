<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leden
 *
 * @ORM\Table(name="leden", indexes={@ORM\Index(name="lid_nr", columns={"lid_nr"})})
 * @ORM\Entity
 */
class Leden
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
     * @ORM\Column(name="lid_nr", type="integer", nullable=false)
     */
    private $lidNr;

    /**
     * @var string
     *
     * @ORM\Column(name="naam", type="string", length=255, nullable=false)
     */
    private $naam;

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

    public function getLidNr(): ?int
    {
        return $this->lidNr;
    }

    public function setLidNr(int $lidNr): self
    {
        $this->lidNr = $lidNr;

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
