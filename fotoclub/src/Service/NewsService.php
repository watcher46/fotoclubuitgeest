<?php

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepository;

class NewsService
{
    /** @var NewsRepository */
    protected $newsRepo;

    protected $months = [
        1 => 'januari',
        2 => 'februari',
        3 => 'maart',
        4 => 'april',
        5 => 'mei',
        6 => 'juni',
        7 => 'juli',
        8 => 'augustus',
        9 => 'september',
        10 => 'oktober',
        11 => 'november',
        12 => 'december'
    ];

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
        /** @var News $newsItem */
        foreach ($news as $newsItem) {
            $newsItemYear = $newsItem->getDateCreated()->format('Y');
            $newsItemMonth = $newsItem->getDateCreated()->format('n');

            $return[$newsItemYear][$this->months[$newsItemMonth]][] = $newsItem;
        }

        return $return;
    }

    public function getNewsByYearMonth(int $year, string $month): array
    {
        if ($year < 0) { return false; }
        if (empty($month)) { return false; }

        $month = array_search($month, $this->months, true);

        if ($month === false) {
            return false;
        }

        return $this->newsRepo->findByYearAndMonth($year, $month);
    }
}