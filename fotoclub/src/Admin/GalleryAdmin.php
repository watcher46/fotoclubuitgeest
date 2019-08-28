<?php
namespace App\Admin;

use App\Entity\Image;
use App\Entity\Member;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class GalleryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class)
            ->add('description', SimpleFormatterType::class, [
                'format' => 'richhtml'
            ])
            ->add('active', CheckboxType::class, [
                'required' => false,
                'value' => 1,
            ])
            ->add('member', ModelType::class, [
                'class' => Member::class,
                'property' => 'name'
            ])
            ->add('images', ModelType::class, [
                'class' => Image::class,
                'multiple' => true,
                'by_reference' => false,
            ],[
                'help' => 'Kies een afbeelding die nog niet gekoppeld is aan een gallerij. Een afbeelding kan maar aan 1 gallerij gekoppeld worden. Wanneer je dit overschrijft vervalt de oude referentie.'
            ])
        ;
    }

    public function prePersist($gallery)
    {
        $gallery->setDateCreated(new \DateTime('now'));
        $gallery->setDateChanged(new \DateTime('now'));
        $gallery->addImages($gallery->getImages());
    }

    public function preUpdate($gallery)
    {
        $gallery->setDateChanged(new \DateTime('now'));
        $gallery->addImages($gallery->getImages());
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('member');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')
            ->add('member');
    }
}