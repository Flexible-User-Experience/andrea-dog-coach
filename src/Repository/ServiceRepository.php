<?php

namespace App\Repository;

use App\Entity\Service;
use App\Enum\SortOrderEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function update(bool $flush = false): void
    {
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function add(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->update($flush);
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->update($flush);
    }

    public function getActiveSortedByPositionQB(): QueryBuilder
    {
        return $this->createQueryBuilder('s')
            ->where('s.active = :active')
            ->setParameter('active', true)
            ->orderBy('s.position', SortOrderEnum::ASCENDING->value)
            ->addOrderBy('s.name', SortOrderEnum::ASCENDING->value)
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

    public function getActiveAndShowInFrontendSortedByPositionQB(): QueryBuilder
    {
        return $this->getActiveSortedByPositionQB()
            ->andWhere('s.showInFrontend = :show')
            ->setParameter('show', true)
        ;
    }

    public function getActiveAndShowInFrontendSortedByPositionQ(): Query
    {
        return $this->getActiveAndShowInFrontendSortedByPositionQB()->getQuery();
    }

    public function getActiveAndShowInFrontendSortedByPosition(): array
    {
        return $this->getActiveAndShowInFrontendSortedByPositionQ()->getResult();
    }

    public function getAllSortedByNameQB(): QueryBuilder
    {
        return $this->createQueryBuilder('s')->orderBy('s.name', SortOrderEnum::ASCENDING->value);
    }

    public function getAllSortedByNameQ(): Query
    {
        return $this->getAllSortedByNameQB()->getQuery();
    }

    public function getAllSortedByName(): array
    {
        return $this->getAllSortedByNameQ()->getResult();
    }

    public function getTotalServicesAmount(): int
    {
        return count($this->getAllSortedByNameQB()->getQuery()->getResult());
    }
}
