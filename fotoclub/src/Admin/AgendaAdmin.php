<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateTimeType;
use Sonata\Form\Type\DatePickerType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class AgendaAdmin extends AbstractAdmin
{
    protected $datagridValues = [

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'DESC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'eventDate',
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class)
            ->add('text', SimpleFormatterType::class, [
                'format' => 'richhtml'
            ])
            ->add('eventDate', DatePickerType::class, [
                'required' => true,
                'dp_use_current' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
                'value' => 1,
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
        $listMapper->add('eventDate', DateTimeType::class, [
            'format' => 'd-m-Y',
            'code' => 'getFormattedEventDate'
        ]);
        $listMapper->add('enabled');
    }
}