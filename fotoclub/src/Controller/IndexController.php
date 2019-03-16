<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GalleryService;

class IndexController extends AbstractController
{
    /** @var GalleryService */
    protected $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        $images = $this->galleryService->getLastCreatedImages(5);

        return $this->render('index.html.twig', [
            'controller_name' => 'MigrateDataController',
            'images' => $images,
        ]);
    }
}