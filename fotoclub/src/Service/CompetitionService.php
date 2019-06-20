<?php

namespace App\Service;

use App\Entity\CompetitionGallery;
use App\Repository\CompetitionGalleryRepository;
use App\Repository\CompetitionImageRepository;

class CompetitionService
{
    const SEASON_START_MONTH = 9;
    const SEASON_END_MONTH = 5;


    /** @var CompetitionGalleryRepository */
    protected $competitionRepo;

    /** @var CompetitionImageRepository */
    protected $competitionImageRepo;

    public function __construct(CompetitionGalleryRepository $competitionRepo, CompetitionImageRepository $competitionImageRepo)
    {
        $this->competitionRepo = $competitionRepo;
        $this->competitionImageRepo = $competitionImageRepo;
    }

    public function getAllCompetitions()
    {

    }


    public function getAllCompetitionsInCurrentSeason()
    {
        $currentSeason = $this->getCurrentSeasonDates();

        return $this->competitionRepo->findAllActiveInSeason($currentSeason['start'], $currentSeason['end'], 'dateCreated', 'DESC');
    }

    public function getAllArchivedCompetitionsPerSeason()
    {
        $currentSeasonDates = $this->getCurrentSeasonDates();

        $archivedCompetitions = $this->competitionRepo->findAllActiveInSeason(date('Y-m-d', 0), $currentSeasonDates['start'], 'dateCreated', 'DESC');
        $seasons = [];
        $seasonStartDates = [];

        $i = 0;
        /** @var CompetitionGallery $competition */
        foreach ($archivedCompetitions as $competition) {
            $dateCreated = $competition->getDateCreated();
            $seasonDates = $this->getSeasonDatesByTime($dateCreated->getTimestamp());
            if (!in_array($seasonDates['start'], $seasonStartDates)) {
                $seasonStartDates[] = $seasonDates['start'];
                $i++;
                $seasons[$i] = [
                    'season' => $seasonDates,
                    'competitions' => [$competition],
                ];
            } else {
                $seasons[$i]['competitions'][] = $competition;
            }
        }

        return $seasons;
    }

    public function getCompetition(int $competitionId)
    {
        return $this->competitionRepo->find($competitionId);
    }

    protected function getSeasonDatesByTime($time)
    {
        $currentYear = date('Y', $time);
        $currentMonth = date('n', $time);

        $startSeasonMonth = self::SEASON_START_MONTH;
        $startSeasonYear = $currentYear;

        //calculate the year for the end of the season
        $endSeasonYear = $currentYear + 1;
        //if the start-month is higher then the current month, it means we've entered the new year
        if($startSeasonMonth > $currentMonth) {
            $startSeasonYear = $currentYear - 1;
            $endSeasonYear = $currentYear;
        }

        //make it a date-object
        $startDatetime = strtotime('01-' . self::SEASON_START_MONTH . '-' . $startSeasonYear);
        $endDatetime = strtotime('01-'. self::SEASON_END_MONTH . '-' . $endSeasonYear);

        //format the date so the database can understand it
        $startSeasonDate = date('Y-m-d', $startDatetime);
        $endSeasonDate = date('Y-m-t', $endDatetime); //t stands for amount of days in the current month, which is the last day of the month

        return [
            'start' => $startSeasonDate,
            'end' => $endSeasonDate,
        ];
    }

    protected function getCurrentSeasonDates()
    {
        return $this->getSeasonDatesByTime(time());
    }
}
