<?php

namespace App\Service;

use App\Entity\Agenda;
use App\Repository\AgendaRepository;

class AgendaService
{
    /** @var AgendaRepository */
    protected $agendaRepo;

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

    public function __construct(AgendaRepository $agendaRepo)
    {
        $this->agendaRepo = $agendaRepo;
    }

    public function getAllEvents(): array
    {
        return $this->groupAgendaItems($this->agendaRepo->findAllEnabledEvents());
    }

    public function getFutureEvents(): array
    {
        return $this->groupAgendaItems($this->agendaRepo->findAllFutureEvents());
    }

    public function getEventsByMonth(int $year, string $month): array
    {
        if ($year < 0) { return []; }
        if (empty($month)) { return []; }

        $month = array_search($month, $this->months, true);

        if ($month === false) {
            return [];
        }

        return $this->agendaRepo->findByYearAndMonth($year, $month);
    }

    protected function groupAgendaItems(array $items): array
    {
        $return = [];
        /** @var Agenda $newsItem */
        foreach ($items as $newsItem) {
            $newsItemYear = $newsItem->getEventDate()->format('Y');
            $newsItemMonth = $newsItem->getEventDate()->format('n');

            $return[$newsItemYear][$this->months[$newsItemMonth]][] = $newsItem;
        }

        return $return;
    }
}