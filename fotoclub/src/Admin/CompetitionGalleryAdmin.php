<?php
namespace App\Admin;

use App\Entity\CompetitionImage;
use mysql_xdevapi\Collection;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\Form\Type\CollectionType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

final class CompetitionGalleryAdmin extends AbstractAdmin
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
            ->add('images', CollectionType::class, [
                'modifiable' => true,
                'by_reference' => false,
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

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')
            ->add('member');
    }
}