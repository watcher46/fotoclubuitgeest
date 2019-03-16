<?php

namespace App\Service;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Repository\GalleryRepository;
use App\Repository\ImageRepository;

class GalleryService
{
    /** @var GalleryRepository */
    protected $galleryRepo;

    /** @var ImageRepository */
    protected $imageRepo;

    public function __construct(
        GalleryRepository $galleryRepository,
        ImageRepository $imageRepository
    )
    {
        $this->galleryRepo = $galleryRepository;
        $this->imageRepo = $imageRepository;
    }

    /**
     * @param int $id
     * @return Gallery
     */
    public function getGalleryById(int $id): Gallery
    {
        /** @var Gallery $gallery */
        $gallery = $this->galleryRepo->findOneWithSortedImagesByDate($id, 'ASC');
        return $gallery;
    }

    public function getLastCreatedImages(int $limit = 1): array
    {
        if ($limit < 0) {
            $limit = 1;
        }
        return $this->imageRepo->findLastCreatedImages($limit);
    }
}