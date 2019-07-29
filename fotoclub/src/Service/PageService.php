<?php


namespace App\Service;

use App\Entity\Page;
use App\Repository\PageRepository;


class PageService
{
    protected $pageRepo;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    public function findPageByName(string $name)
    {
        if (empty($name)) { return false; }

        return $this->pageRepo->findOneBy(['title' => $name, 'enabled' => true]);
    }

    public function findHomePage()
    {
        return $this->pageRepo->findOneBy(['homepage' => true, 'enabled' => true]);
    }
}