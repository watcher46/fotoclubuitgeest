<?php
namespace App\Admin;

use App\Entity\Image;
use App\Entity\Member;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name', TextType::class)
            ->add('active', CheckboxType::class, [
                'required' => false,
                'value' => 1,
            ])
            ->add('file', FileType::class, [
                'required' => false
            ])
            ->add('member', ModelType::class, [
                'class' => Member::class,
                'property' => 'name',
            ])
        ;
    }

    public function prePersist($image)
    {
        $image->setDateCreated(new \DateTime());
        $image->setSortOrder(1);
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $image->setDateChanged(new \DateTime());
        $this->manageFileUpload($image);
    }

    private function manageFileUpload(Image $image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('member.name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
        $listMapper->add('member');
    }
}