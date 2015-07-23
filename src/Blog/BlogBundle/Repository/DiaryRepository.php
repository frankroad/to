<?php

namespace Blog\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Blog\BlogBundle\Entity\Diary;

/**
 * DiaryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DiaryRepository extends EntityRepository
{
	public function getForLuceneQuery($query)
    {
        $hits = Diary::getLuceneIndex()->find($query);

        $pks = array();
        foreach ($hits as $hit)
        {
          $pks[] = $hit->pk;
        }

        if (empty($pks))
        {
          return array();
        }

        $q = $this->createQueryBuilder('d')
            ->where('d.id IN (:pks)')
            ->setParameter('pks', $pks)
            ->setMaxResults(20)
            ->getQuery();

        return $q->getResult();
    }
}
