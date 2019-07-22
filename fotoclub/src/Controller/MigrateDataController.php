<?php

namespace App\Controller;

use App\Entity\Agenda;
use App\Entity\CompetitionGallery;
use App\Entity\CompetitionGalleryImage;
use App\Entity\CompetitionImage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Member;
use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\News;
use App\Repository\ImageRepository;

class MigrateDataController extends AbstractController
{
    protected $imageRepository;
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * @Route("/migrate/data", name="migrate_data")
     */
    public function index()
    {
        die('only run this on migration-day');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $entityManager->getConnection();
        //fetch data to be migrated
        $membersWithGalleryIds = $connection->fetchAll($this->getMembersWithGalleriesQuery());
        $galleriesWithImages = $connection->fetchAll($this->getGalleriesWithImagesQuery());
        $competitionGalleriesWithoutMember = $connection->fetchAll($this->getCompetitionsWithImagesQuery());

        //structure the data for new entities
        $members = $this->parseMembersWithGalleries($membersWithGalleryIds);
        $galleries = $this->parseGalleriesWithImages($galleriesWithImages);

        $nonExistingGalleries = [];


        $newMembersWithNewImageIds = [];
        $competitionGalleryLinkedToMember = [];

        //insert the newly structured data for all members
        foreach ($members as $member) {
            $newMember = new Member();
            $newMember->setMemberNumber($member['member_number']);
            $newMember->setActive($member['active']);
            $newMember->setName($member['name']);

            $entityManager->persist($newMember);
            $entityManager->flush();

            foreach($member['galleries'] as $galleryId) {
                $galleryIds = array_keys($galleries);
                if(!in_array($galleryId, $galleryIds)) {
                    $nonExistingGalleries[] = $member;
                    continue;
                }

                $oldGallery = $galleries[$galleryId];

                if ($oldGallery['type'] == '4') {
                    $newGallery = new Gallery();
                    $newGallery->setName($oldGallery['name']);
                    $newGallery->setDescription($oldGallery['description']);
                    $newGallery->setDateCreated(new \DateTime($oldGallery['date_created']));
                    $newGallery->setDateChanged(new \DateTime($oldGallery['date_changed']));
                    $newGallery->setActive($oldGallery['active']);
                    $newGallery->setMember($newMember);
                }

                if($oldGallery['type'] == '5') {
                    $competitionGalleryLinkedToMember[] = $member;
                }

                $entityManager->persist($newGallery);
                $i = 1;
                foreach($oldGallery['images'] as $image) {
                    $newImage = new Image();
                    $newImage->setName($image['name']);
                    $newImage->setFileName($image['file_name']);
                    $newImage->setDateCreated(new \DateTime($image['date_created']));
                    $newImage->setActive(true);
                    $newImage->setMember($newMember);
                    $newImage->setSortOrder($i);

                    $entityManager->persist($newImage);

                    $entityManager->flush();

                    $newGallery->addImage($newImage);

                    $newMembersWithNewImageIds[$image['id']] = ['memberId' => $newMember->getId(), 'newImageId' => $newImage->getId(), 'oldImage' => $image];

                    $i++;
                }

                $entityManager->flush();
            }

            $entityManager->flush();
            $entityManager->clear();
        }


        $competitions = $this->parseGalleriesWithImages($competitionGalleriesWithoutMember);
        $notSavedImages = [];
        //insert all competitions
        foreach($competitions as $competition) {
            $newGallery = new CompetitionGallery();
            $newGallery->setName($competition['name']);
            $newGallery->setDescription($competition['description']);
            $newGallery->setActive($competition['active']);
            $newGallery->setDateCreated(new \DateTime($competition['date_created']));

            $entityManager->persist($newGallery);

            $entityManager->flush();

            $i = 1;
            foreach($competition['images'] as $image) {

                if(!array_key_exists($image['id'], $newMembersWithNewImageIds)) {
                    $notSavedImages[] = [
                        'image' => $image,
                        'competition' => $competition,
                    ];
                    continue;
                }

                $imageId = $newMembersWithNewImageIds[$image['id']]['newImageId'];
                $image = $this->imageRepository->find($imageId);

                $competitionImage = new CompetitionImage();
                $competitionImage->setCompetitionGallery($newGallery);
                $competitionImage->setImage($image);
                $competitionImage->setSortOrder($i);

                $entityManager->persist($competitionImage);

                $i++;
            }
            $entityManager->flush();
        }

        return $this->render('migrate_data/index.html.twig', [
            'controller_name' => 'MigrateDataController',
            'nonExistingGalleries' => $nonExistingGalleries,
            'notSavedImagesToCompetition' => $notSavedImages,
            'competitionGalleryLinkedToMember' => $competitionGalleryLinkedToMember,
        ]);
    }

    /**
     * @Route("migrate/items", name="migrate_items")
     */
    public function items(){
        die('only execute on migration day!');
        $entityManager = $this->getDoctrine()->getManager();

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $entityManager->getConnection();
        //fetch data to be migrated
        $newsItems = $connection->fetchAll($this->getNewsQuery());
        $agendaItems = $connection->fetchAll($this->getAgendaQuery());

        foreach($newsItems as $newsRow) {
            $newsItem = new News();

            $newsItem->setTitle($newsRow['titel']);
            $newsItem->setText($newsRow['description']);
            $newsItem->setDateCreated(new \DateTime($newsRow['datum']));
            $newsItem->setDateUpdated(new \DateTime($newsRow['datum']));
            $newsItem->setEnabled(($newsRow['status'] == 'actief')? true : false);

            $entityManager->persist($newsItem);
            $entityManager->flush();
        }

        foreach($agendaItems as $agendaRow) {
            $agendaItem = new Agenda();

            $agendaItem->setTitle($agendaRow['titel']);
            $agendaItem->setText($agendaRow['description']);
            $agendaItem->setDateCreated(new \DateTime($agendaRow['datum']));
            $agendaItem->setDateUpdated(new \DateTime($agendaRow['datum']));
            $agendaItem->setEventDate(new \DateTime($agendaRow['datum']));
            $agendaItem->setEnabled(($agendaRow['status'] == 'actief')? true : false);

            $entityManager->persist($agendaItem);
            $entityManager->flush();
        }
    }


    protected function parseMembersWithGalleries(array $result) :array
    {
        $membersWithGalleries = [];
        foreach ($result as $row) {

            $galIds = array_keys($membersWithGalleries);

            if(!in_array($row['id'], $galIds)) {
                $membersWithGalleries[$row['id']] = [
                    'member_number' => $row['lid_nr'],
                    'name' => $row['naam'],
                    'active' => ($row['status'] === 'actief') ? true : false,
                    'galleries' => [$row['galId']],
                ];
            } else {
                $membersWithGalleries[$row['id']]['galleries'][] = $row['galId'];
            }
        }

        return $membersWithGalleries;
    }

    protected function parseGalleriesWithImages(array $result) :array
    {
        $galleriesWithImages = [];
        foreach($result as $row) {
            $galIds = array_keys($galleriesWithImages);

            if(!in_array($row['galId'], $galIds)) {
                $galleriesWithImages[$row['galId']] = [
                    'name' => (!empty($row['galNaam'])) ? $row['galNaam'] : '',
                    'type' => (!empty($row['type'])) ? $row['type'] : 4,
                    'description' => (!empty($row['beschrijving'])) ? $row['beschrijving'] : '',
                    'date_created' => $row['datum_aangemaakt'],
                    'date_changed' => $row['datum_gewijzigd'],
                    'active' => ($row['status'] === 'actief')? true : false,
                    'images' => [
                        [
                            'id' => (!empty($row['imageId'])) ? $row['imageId'] : null,
                            'name' => (!empty($row['imageNaam'])) ? $row['imageNaam'] : '',
                            'file_name' => (!empty($row['naam_original'])) ? $row['naam_original'] : '',
                            'date_created' => $row['datum']
                        ]
                    ],
                ];
            } else {
                $galleriesWithImages[$row['galId']]['images'][] = [
                    'id' => (!empty($row['imageId'])) ? $row['imageId'] : null,
                    'name' => (!empty($row['imageNaam'])) ? $row['imageNaam'] : '',
                    'file_name' => (!empty($row['naam_original'])) ? $row['naam_original'] : '',
                    'date_created' => $row['datum']
                ];
            }
        }

        return $galleriesWithImages;
    }

    protected function getMembersWithGalleriesQuery() :string
    {
        return "
            SELECT l.*, g.id AS galId
            FROM leden as l
            LEFT JOIN leden2galerij as l2g ON l.id = l2g.lid_id
            LEFT JOIN galerij as g ON l2g.galerij_id = g.id
            WHERE g.type = '4'
            ORDER BY l.id ASC
        ";
    }

    protected function getGalleriesWithImagesQuery() :string
    {
        return "
            SELECT g.id AS galId, g.naam AS galNaam, g.*, i.id AS imageId, i.naam AS imageNaam, i.* 
            FROM galerij as g 
            LEFT JOIN images2galerij as i2g ON i2g.galerij_id = g.id
            LEFT JOIN images as i ON i2g.image_id = i.id
        ";
    }

    protected function getCompetitionsWithImagesQuery() :string
    {
        return "
            SELECT g.id AS galId, g.naam AS galNaam, g.*, i.id AS imageId, i.naam AS imageNaam, i.* 
            FROM galerij as g 
            LEFT JOIN images2galerij as i2g ON i2g.galerij_id = g.id
            LEFT JOIN images as i ON i2g.image_id = i.id
            WHERE g.type = '5'
        ";
    }

    protected function getNewsQuery() :string
    {
        return "
            SELECT *
            FROM `items`
            WHERE `type_id` = '2'
        ";
    }

    protected function getAgendaQuery() :string
    {
        return "
            SELECT *
            FROM `items`
            WHERE `type_id` = '3'
        ";
    }
}
