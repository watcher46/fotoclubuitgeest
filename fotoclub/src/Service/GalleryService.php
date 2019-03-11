<?php

namespace App\Service;

use App\Entity\Gallery;
use App\Repository\GalleryRepository;

class GalleryService
{
    /**
     * @var GalleryRepository
     */
    protected $galleryRepo;

    public function __construct(GalleryRepository $galleryRepository)
    {
        $this->galleryRepo = $galleryRepository;
    }

    /**
     * @param int $id
     * @return Gallery
     */
    public function getGalleryById(int $id)
    {
        /** @var Gallery $gallery */
        $gallery = $this->galleryRepo->findOneWithSortedImagesByDate($id, 'ASC');
        return $gallery;
    }
}