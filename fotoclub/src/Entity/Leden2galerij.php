<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leden2galerij
 *
 * @ORM\Table(name="leden2galerij")
 * @ORM\Entity
 */
class Leden2galerij
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
     * @ORM\Column(name="lid_id", type="integer", nullable=false)
     */
    private $lidId;

    /**
     * @var int
     *
     * @ORM\Column(name="galerij_id", type="integer", nullable=false)
     */
    private $galerijId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLidId(): ?int
    {
        return $this->lidId;
    }

    public function setLidId(int $lidId): self
    {
        $this->lidId = $lidId;

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


}
