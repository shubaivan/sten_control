<?php

namespace App\Repository;

use App\Entity\Control;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Control|null find($id, $lockMode = null, $lockVersion = null)
 * @method Control|null findOneBy(array $criteria, array $orderBy = null)
 * @method Control[]    findAll()
 * @method Control[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Control::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Control $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Control $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return float|int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function fetchTotalCount()
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $queryBuilder
            ->select('COUNT(DISTINCT c.id)');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param string $query
     * @return float|int|mixed|string
     */
    public function fetchBySearchData(array $params)
    {
        $rsm = new ResultSetMappingBuilder(
            $this->_em,
            ResultSetMappingBuilder::COLUMN_RENAMING_INCREMENT
        );
        $rsm->addRootEntityFromClassMetadata(Control::class, 'c');

        $sql = "select " . $rsm->generateSelectClause() . " from control c";
        $sqlCount = "select COUNT(DISTINCT c.id) from control c";

        if (isset($params['search']['value']) && strlen($params['search']['value'])) {
            $query = $params['search']['value'];
            $query = (function ($q) {
                $pieces = explode(' ', $q);
                if (count($pieces) === 1) {
                    return $q . ':*';
                }
                return join(':*&', $pieces);
            })($query);
            $tsquery = " where to_tsvector(c.last_name || ' ' || c.fisrt_name || ' ' || c.mobile || ' ' || c.car_number) @@ to_tsquery('$query')";
            $sql .= $tsquery;
            $sqlCount .= $tsquery;
        }
        if (isset($params['columns']) && is_array($params['columns'])) {
            foreach ($params['columns'] as $column) {
                if (isset($column['search']['value'])
                    && isset($column['data'])
                    && strlen($column['search']['value'])
                ) {
                    $value = $column['search']['value'];
                    $column = $column['data'];
                    $where = '
                        where '.$column.' LIKE \'%' .$value .'%\'
                    ';
                    $sql .= $where;
                    $sqlCount .= $where;
                }
            }
        }
        $count = $this->_em->getConnection()->executeQuery($sqlCount)->fetchOne();;
        if (isset($params['length'])) {
            $length = $params['length'];
            $sql .= "
                        limit $length 
                    ";
        }

        if (isset($params['start'])) {
            $offset = $params['start'];
            $sql .= "
                        offset $offset 
                    ";
        }

        $qb = $this->_em->createNativeQuery($sql, $rsm);

        return ['data' => $qb->getResult(), 'count' => $count];
    }
}
