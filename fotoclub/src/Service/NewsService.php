<?php

namespace App\Service;

use App\Repository\NewsRepository;

class NewsService
{
    /** @var NewsRepository */
    protected $newsRepo;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->newsRepo = $newsRepo;
    }

    public function getNews(): array
    {
        return $this->newsRepo->findAllEnabledNews();
    }

    public function getGroupedNews(): array
    {
        $news = $this->getNews();

        $return = [];
        foreach ($news as $newsItem) {
            $newsItemYear = $newsItem->getDateCreated()->format('Y');
            $newsItemMonth = $newsItem->getDateCreated()->format('F');

            $return[$newsItemYear][$newsItemMonth][] = $newsItem;
        }

        return $return;
    }
}