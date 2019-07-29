<?php

namespace App\Controller;

use App\Service\PageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * @Route("/page/{slug}", name="page", defaults={"slug" = null}, requirements={"slug"=".+"})
     *
     * @param Request $request
     * @param string $slug
     * @return Response
     */
    public function page(Request $request, string $slug)
    {
        if (empty($slug)) { throw new NotFoundHttpException('Pagina niet gevonden.'); }

        $pageName = $slug;
        if (stripos($slug, '/')) {
            list($pageName, $afterSlash) = explode('/', $slug);
        }

        $page = $this->pageService->findPageByName($pageName);
        if (!$page) { throw new NotFoundHttpException('Pagina niet gevonden.'); }

        return $this->render('page/view.html.twig', ['page' => $page]);
    }
}