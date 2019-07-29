<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Entity\Page;

class AdminController extends EasyAdminController
{
    // Customizes the instantiation of entities only for the 'User' entity
    public function createNewPageEntity()
    {
        $now = new \DateTime('now');
        $page = new Page();
        $page->setDateCreated($now)
            ->setDateUpdated($now)
        ;
        return $page;
    }
}