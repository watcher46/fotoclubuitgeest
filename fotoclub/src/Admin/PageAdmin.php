<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
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
            ->add('text', TextareaType::class)
            ->add('homepage', CheckboxType::class, [
                'required' => false,
                'value' => 1,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'value' => 1,
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