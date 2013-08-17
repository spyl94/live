<?php

namespace Live\LessonBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InstrumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InstrumentRepository extends EntityRepository
{

    public function getInstrumentsLowLevel()
    {
      $qb = $this->createQueryBuilder('i');
      $qb->where($qb->expr()->eq('i.level', 0))
         ->orderBy('i.name', 'ASC');

      return $qb->getQuery()->getResult();
    }

    public function getInstrumentsNotPlayedBy($id)
    {

      $nots = $this->getEntityManager();
      $nots = $this->_em->createQuery('SELECT IDENTITY(l.instrument) FROM LiveLessonBundle:Lesson l WHERE IDENTITY(l.creator) = ' . $id)->getResult();

      $fix = array();
      foreach ($nots as $n) {
          $fix[] = $n[1];
      }
      $qb = $this->createQueryBuilder('i')->where('i.level != 0');

      return empty($fix) ? $qb->orderBy('i.name', 'ASC'); : $qb->andWhere($qb->expr()->notIn('i.id', $fix))->orderBy('i.name', 'ASC');
    }

    public function getInstrumentsNotAskedBy($id)
    {

      $nots = $this->getEntityManager();
      $nots = $this->_em->createQuery('SELECT IDENTITY(l.instrument) FROM LiveLessonBundle:LessonAsk l WHERE IDENTITY(l.creator) = ' . $id)->getResult();

      $fix = array();
      foreach ($nots as $n) {
          $fix[] = $n[1];
      }
      $qb = $this->createQueryBuilder('i')->where('i.level != 0');

      return empty($fix) ? $qb->orderBy('i.name', 'ASC'); : $qb->andWhere($qb->expr()->notIn('i.id', $fix))->orderBy('i.name', 'ASC');
    }
}
