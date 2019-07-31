<?php
namespace App\Admin;

use App\Entity\Gallery;
use App\Entity\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class MemberAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class)
            ->add('memberNumber', TextType::class)
            ->add('active', CheckboxType::class, [
                'required' => false,
                'value' => 1,
            ])
            ->add('galleries', ModelType::class, [
                'class' => Gallery::class,
                'multiple' => true,
            ])
            ->add('images', ModelType::class, [
                'class' => Image::class,
                'multiple' => true,
            ])

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
        $listMapper->add('memberNumber')
            ->add('active')
        ;
    }
}