<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Items2galerij
 *
 * @ORM\Table(name="items2galerij")
 * @ORM\Entity
 */
class Items2galerij
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
     * @ORM\Column(name="items_id", type="integer", nullable=false)
     */
    private $itemsId;

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

    public function getItemsId(): ?int
    {
        return $this->itemsId;
    }

    public function setItemsId(int $itemsId): self
    {
        $this->itemsId = $itemsId;

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
