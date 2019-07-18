<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\NewsService;

class NewsController extends AbstractController
{
    /** @var NewsService */
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/nieuws", name="news")
     */
    public function index()
    {
        $news = $this->newsService->getGroupedNews();

        return $this->render('news/index.html.twig', ['news' => $news]);
    }
}
