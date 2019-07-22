<?php

namespace App\Controller;

use App\Service\AgendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\NewsService;

class AgendaController extends AbstractController
{
    /** @var AgendaService */
    protected $agendaService;

    public function __construct(AgendaService $agendaService)
    {
        $this->agendaService = $agendaService;
    }

    /**
     * @Route("/agenda", name="agenda")
     */
    public function index()
    {
        $futureEvents = $this->agendaService->getFutureEvents();
        $allPastEvents = $this->agendaService->getAllEvents();

        return $this->render('agenda/index.html.twig', [
            'futureEvents' => $futureEvents,
            'events' => $allPastEvents,
        ]);
    }

    /**
     * @Route("/agenda/{year}/{month}", name="monthEvents")
     *
     * @param int $year
     * @param string $month
     * @return Response
     */
    public function month(int $year, string $month)
    {
        $allPastEvents = $news = $this->agendaService->getAllEvents();
        $monthEvents = $this->agendaService->getEventsByMonth($year, $month);

        return $this->render('agenda/month.html.twig', [
            'monthEvents' => $monthEvents,
            'events' => $allPastEvents,
        ]);
    }
}
