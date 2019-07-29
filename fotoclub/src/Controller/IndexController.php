<?php

namespace App\Controller;

use App\Service\GalleryService;
use App\Service\PageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /** @var GalleryService */
    protected $galleryService;

    protected $pageService;

    public function __construct(GalleryService $galleryService, PageService $pageService)
    {
        $this->galleryService = $galleryService;
        $this->pageService = $pageService;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        $images = $this->galleryService->getLastCreatedImages(4);
        $homepagePage = $this->pageService->findHomePage();

        return $this->render('index.html.twig', [
            'images' => $images,
            'homepage' => $homepagePage,
        ]);
    }
}