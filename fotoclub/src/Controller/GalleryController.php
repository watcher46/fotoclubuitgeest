<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GalleryService;
use App\Service\MemberService;

class GalleryController extends AbstractController
{
    /** @var GalleryService */
    protected $galleryService;

    protected $membersService;

    public function __construct(GalleryService $galleryService, MemberService $membersService)
    {
        $this->galleryService = $galleryService;
        $this->membersService = $membersService;
    }

    /**
     * @Route("/galerij/{galleryId}", name="gallery_view")
     *
     * @param int $galleryId
     * @return Response
     */
    public function viewGallery(int $galleryId): Response
    {
        $members = $this->membersService->getAllActiveMembers();

        try {
            $gallery = $this->galleryService->getActiveGallery($galleryId);
        } catch(\Exception $exception) {
            return $this->render('error/galleryNotFound.html.twig', [
                'members' => $members,
            ]);
        }

        return $this->render('gallery/details.html.twig', [
            'gallery' => $gallery,
            'members' => $members,
        ]);
    }
}