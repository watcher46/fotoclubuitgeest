<?php

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepository;

class NewsService
{
    /** @var NewsRepository */
    protected $newsRepo;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->newsRepo = $newsRepo;
    }

    public function getNews(): Array
    {
        return $this->newsRepo->findAllEnabledNews();
    }
}