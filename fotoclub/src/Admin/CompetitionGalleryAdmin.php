<?php
namespace App\Admin;

use App\Entity\CompetitionImage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class CompetitionGalleryAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'dateCreated',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class, [
            'label' => 'Titel',
        ])
            ->add('description', SimpleFormatterType::class, [
                'label' => 'Beschrijving',
                'format' => 'richhtml'
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Actief',
                'required' => false,
                'value' => 1,
            ])
            ->add('images', CollectionType::class, [
                'label' => 'Afbeeldingen',
                'modifiable' => true,
                'by_reference' => true,
            ], [
                'inline' => 'table',
                'edit' => 'inline',
            ])
        ;
    }

    public function prePersist($object)
    {
        $object->setImages($object->getImages());
        $object->setDateCreated(new \Datetime('now'));
    }

    public function preUpdate($object)
    {
        /** @var CompetitionImage $image */
        foreach($object->getImages() as $image) {
            $image->setCompetitionGallery($object);
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, [
                'label' => 'Competitie',
            ])
            ->add('countImages', null, [
                'label' => 'Aantal afbeeldingen',
            ])
            ->add('active', null, [
                'label' => 'Actief',
                'editable' => true,
            ]);
    }
}