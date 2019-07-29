<?php


namespace App\Service;


use App\Repository\NavigationRepository;

class NavigationService
{
    protected $navigationRepo;

    public function __construct(NavigationRepository $navigationRepo)
    {
        $this->navigationRepo = $navigationRepo;
    }

    public function getNavigation()
    {
        return $this->navigationRepo->findAll();
    }
}