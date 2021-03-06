<?php
namespace App\Admin;

use App\Entity\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Entity\Navigation;

final class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class)
            ->add('text', SimpleFormatterType::class, [
                'format' => 'richhtml'
            ])
            ->add('homepage', CheckboxType::class, [
                'required' => false,
                'value' => 1,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'value' => 1,
            ])
            ->add('image', ModelType::class, [
                'class' => Image::class,
                'property' => 'name',
            ],[
                'sortable' => 'sortOrder',
                'help' => 'Kies een afbeelding die nog niet gekoppeld is aan een gallerij. Een afbeelding kan maar aan 1 gallerij gekoppeld worden. Wanneer je dit overschrijft vervalt de oude referentie.'
            ])
            ->add('navigation', ModelType::class, [
                'class' => Navigation::class,
                'property' => 'title'
            ])
        ;
    }

    public function prePersist($page)
    {
        $page->setDateCreated(new \DateTime('now'));
        $page->setDateUpdated(new \DateTime('now'));
    }

    public function preUpdate($page)
    {
        $page->setDateUpdated(new \DateTime('now'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
        $listMapper->add('dateCreated')
            ->add('dateUpdated')
            ->add('enabled')
        ;
    }
}