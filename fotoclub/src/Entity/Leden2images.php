<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Leden2images
 *
 * @ORM\Table(name="leden2images")
 * @ORM\Entity
 */
class Leden2images
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
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     */
    private $imageId;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted = '0';

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

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function setImageId(int $imageId): self
    {
        $this->imageId = $imageId;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


}
