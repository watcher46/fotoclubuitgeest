<?php

namespace App\Controller;

use App\Service\CompetitionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    /** @var CompetitionService */
    protected $competitionService;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    /**
     * @Route("/competities", name="competitions")
     */
    public function competitions()
    {
        $competitions = $this->competitionService->getAllCompetitionsInCurrentSeason();

        return $this->render('competition/overview.html.twig', [
            'competitions' => $competitions,
        ]);
    }

    /**
     *
     * @Route("/competitie/{competitionId}", name="competition_details")
     *
     * @param int $competitionId
     */
    public function competitionDetails(int $competitionId)
    {

    }
}
