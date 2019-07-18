<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/nieuws/{year}/{month}", name="monthNews")
     *
     * @param int $year
     * @param string $month
     * @return Response
     */
    public function month(int $year, string $month)
    {
        $archivedNews = $news = $this->newsService->getGroupedNews();
        $news = $this->newsService->getNewsByYearMonth($year, $month);

        return $this->render('news/month.html.twig', ['news' => $archivedNews, 'monthNews' => $news]);
    }
}
