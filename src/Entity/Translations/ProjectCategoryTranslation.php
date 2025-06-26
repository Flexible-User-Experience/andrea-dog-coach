<?php

namespace App\Entity\Translations;

use App\Entity\ProjectCategory;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'lookup_project_category_unique_idx', columns: ['locale', 'object_id', 'field'])]
class ProjectCategoryTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: ProjectCategory::class, inversedBy: 'translations')]
    protected $object;
}
