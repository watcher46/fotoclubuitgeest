<?php


namespace App\Menu;

use App\Entity\Page;
use App\Service\NavigationService;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder
{
    protected $navigationService;
    protected $factory;

    public function __construct(FactoryInterface $factory, NavigationService $navigationService)
    {
        $this->factory = $factory;
        $this->navigationService = $navigationService;
    }

    public function mainMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav',
            ],
        ]);

        $menu->addChild('Home', ['route' => 'home']);
        $galerij = $menu->addChild('Galerij');
        $galerij->addChild('Leden', ['route' => 'members_overview']);
        $galerij->addChild('Competities', ['route' => 'competitions']);

        $menu->addChild('Nieuws', ['route' => 'news']);
        $menu->addChild('Agenda', ['route' => 'agenda']);

        $pageNavigation = $this->navigationService->getNavigation();

        foreach($pageNavigation as $navItem)
        {
            if (count($navItem->getPages()) > 0) {
                $menu->addChild($navItem->getTitle());
                /** @var Page $page */
                foreach($navItem->getPages() as $page) {
                    $menu[$navItem->getTitle()]->addChild($page->getTitle(), [
                        'route' => 'page',
                        'routeParameters' => ['slug' => $page->getTitle()],
                    ]);
                }

            }
        }

        return $menu;
    }
}