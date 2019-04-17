<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GalleryService;
use App\Service\MemberService;

class MemberController extends AbstractController
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
     * @Route("/leden", name="members_overview")
     * @return Response
     */
    public function members()
    {
        $members = $this->membersService->getAllActiveMembers();
        $gallery = $this->galleryService->getRandomActiveGallery();

        return $this->render('members/overview.html.twig', [
            'members' => $members,
            'gallery' => $gallery,
        ]);
    }
}