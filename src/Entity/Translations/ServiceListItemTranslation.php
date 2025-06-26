<?php

namespace App\Entity\Translations;

use App\Entity\ServiceListItem;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: 'lookup_service_list_item_unique_idx', columns: ['locale', 'object_id', 'field'])]
class ServiceListItemTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: ServiceListItem::class, inversedBy: 'translations')]
    protected $object;
}
