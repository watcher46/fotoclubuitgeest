<?php

namespace App\Controller;

use App\Service\CompetitionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    /** @var CompetitionService */
    protected $competitionService;

    protected $competitionsCurrentSeason;
    protected $archivedCompetitions;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;

        $this->competitionsCurrentSeason = $this->competitionService->getAllCompetitionsInCurrentSeason();
        $this->archivedCompetitions = $this->competitionService->getAllArchivedCompetitionsPerSeason();
    }

    /**
     * @Route("/competities", name="competitions")
     *
     * @return Response
     */
    public function competitions()
    {
        return $this->render('competition/overview.html.twig', [
            'competitions' => $this->competitionsCurrentSeason,
            'archivedCompetitions' => $this->archivedCompetitions,
        ]);
    }

    /**
     *
     * @Route("/competitie/{competitionId}", name="competition_details")
     *
     * @param int $competitionId
     * @return Response
     */
    public function competitionDetails(int $competitionId)
    {
        $competition = $this->competitionService->getCompetition($competitionId);

        return $this->render('competition/detail.html.twig', [
            'competitions' => $this->competitionsCurrentSeason,
            'archivedCompetitions' => $this->archivedCompetitions,
            'competition' => $competition,
        ]);
    }
}
