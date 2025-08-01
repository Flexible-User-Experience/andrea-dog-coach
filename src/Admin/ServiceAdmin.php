<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Translations\ServiceTranslation;
use App\Enum\RoutesEnum;
use App\Enum\SortOrderEnum;
use App\Form\Type\GedmoTranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

final class ServiceAdmin extends AbstractBaseAdmin
{
    public function generateBaseRoutePattern(bool $isChildAdmin = false): string
    {
        return RoutesEnum::app_admin_service_path;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        parent::configureDefaultSortValues($sortValues);
        $sortValues[DatagridInterface::SORT_ORDER] = SortOrderEnum::ASCENDING->value;
        $sortValues[DatagridInterface::SORT_BY] = 'position';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('show')
            ->remove('batch')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('name')
            ->add('position')
            ->add('showInFrontend')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add(
                'imageName',
                null,
                [
                    'editable' => false,
                    'header_style' => 'width:140px',
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                    'template' => '@App/admin/cells/list__cell_image_field.html.twig',
                ]
            )
            ->add(
                'name',
                FieldDescriptionInterface::TYPE_STRING,
                [
                    'editable' => true,
                ]
            )
            ->add(
                'position',
                FieldDescriptionInterface::TYPE_INTEGER,
                [
                    'editable' => true,
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                ]
            )
            ->add(
                'showInFrontend',
                FieldDescriptionInterface::TYPE_BOOLEAN,
                [
                    'editable' => true,
                    'header_class' => 'text-center',
                    'row_align' => 'center',
                ]
            )
            ->add(
                ListMapper::NAME_ACTIONS,
                ListMapper::TYPE_ACTIONS,
                [
                    'actions' => [
                        'edit' => [],
                        'delete' => [],
                    ],
                    'header_style' => 'width:86px',
                    'header_class' => 'text-right',
                    'row_align' => 'right',
                ]
            )
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with(
                'Image',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-success',
                ]
            )
            ->add(
                'imageFile',
                VichImageType::class,
                [
                    'required' => $this->isFormToCreateNewRecord(),
                    'allow_delete' => false,
                    'help' => 'Image Helper',
                ]
            )
            ->end()
            ->with(
                'General',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-success',
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required' => false,
                    'attr' => [
                        'data-controller' => 'easymde',
                        'data-easymde-target' => 'textarea',
                    ],
                ]
            )
            ->end()
            ->with(
                'Translations',
                [
                    'class' => 'col-md-4',
                    'box_class' => 'box box-success',
                ]
            )
            ->add(
                'translations',
                GedmoTranslationsType::class,
                [
                    'label' => false,
                    'required' => false,
                    'translatable_class' => ServiceTranslation::class,
                    'fields' => [
                        'name' => [
                            'required' => true,
                            'field_type' => TextType::class,
                        ],
                        'description' => [
                            'required' => false,
                            'field_type' => TextareaType::class,
                            'attr' => [
                                'rows' => 10,
                            ],
                        ],
                    ],
                ]
            )
            ->end()
        ;
        if (!$this->isFormToCreateNewRecord()) {
            $form
                ->with(
                    'Controls',
                    [
                        'class' => 'col-md-3',
                        'box_class' => 'box box-success',
                    ]
                )
                ->add(
                    'position',
                    NumberType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'showInFrontend',
                    null,
                    [
                        'required' => false,
                    ]
                )
                ->end()
            ;
        }
    }
}
