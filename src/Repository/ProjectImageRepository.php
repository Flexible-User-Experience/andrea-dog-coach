<?php

namespace App\Repository;

use App\Entity\ServiceImage;
use App\Enum\SortOrderEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceImage>
 *
 * @method ServiceImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceImage[]    findAll()
 * @method ServiceImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceImage::class);
    }

    public function update(bool $flush = false): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function add(ServiceImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->update($flush);
    }

    public function remove(ServiceImage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->update($flush);
    }

    public function getActiveSortedByPositionQB(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.active = :active')
            ->setParameter('active', true)
            ->orderBy('p.position', SortOrderEnum::ASCENDING->value)
        ;
    }

    public function getActiveSortedByPositionQ(): Query
    {
        return $this->getActiveSortedByPositionQB()->getQuery();
    }

    public function getActiveSortedByPosition(): array
    {
        return $this->getActiveSortedByPositionQ()->getResult();
    }
}
