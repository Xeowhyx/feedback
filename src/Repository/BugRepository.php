<?php

namespace App\Repository;

use App\Entity\Bug;
use App\Entity\BugSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bug|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bug|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bug[]    findAll()
 * @method Bug[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BugRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bug::class);
    }



    public function findAllBugQuery(BugSearch $search): Query
    {
        $query = $this->findBugQuery();

        if ($search->getOs()){
            $query = $query
                ->andWhere('p.os = :os')
                ->setParameter('os', $search->getOs());
        }

        if ($search->getLocation()){
            $query = $query
                ->andWhere('p.location = :location')
                ->setParameter('location', $search->getLocation());
        }

        if ($search->getPriority()){
            $query = $query
                ->andWhere('p.priority = :priority')
                ->setParameter('priority', $search->getPriority());
        }

        if ($search->getState()){
            $query = $query
                ->andWhere('p.state = :state')
                ->setParameter('state', $search->getState());
        }

        if ($search->getSeverity()){
            $query = $query
                ->andWhere('p.severity = :severity')
                ->setParameter('severity', $search->getSeverity());
        }

        if ($search->getName()) {
            $query = $query
                ->andWhere('p.name LIKE :name')
                ->setParameter('name', '%'.$search->getName().'%');
        }

        if ($search->getDate()) {
            $query = $query
                ->andWhere('p.date = :date')
                ->setParameter('date', $search->getDate());
        }

        $query->orderBy('p.date', 'DESC');

        if ($search->getOrderBy()){
            $query->orderBy('p.date', 'ASC');
        }

        return $query->getQuery();
    }

    public function findAllBugsQuery(): Query
    {
        $query = $this->findBugQuery();
        $query->orderBy('p.date', 'DESC');
        return $query->getQuery();
    }


    private function findBugQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    public function findLatestBug(): array
    {
        return $this->findAllBugsQuery()
            ->setMaxResults(5)
            ->getResult();
    }
}
