<?php
namespace App\Admin;

use App\Entity\CompetitionGallery;
use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Member;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class CompetitionImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('image', ModelType::class, [
                'class' => Image::class,
                'by_reference' => false,
            ])
            ->add('sortOrder', TextType::class)
        ;
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setSortOrder(0);

        return $instance;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('sortOrder')
            ->add('competitionGallery');
    }
}