<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ScheduleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScheduleRepository extends EntityRepository
{
  public function getAllFuture(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;

    return $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule','s')
      ->where('s.first_date >= :date')
      ->andWhere('(s.schedule = :id OR s.id = :id)')
      ->setParameter('date', $schedule->getFirstDate()->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();
  }

  public function getAllPast(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;

    return $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule','s')
      ->where('s.first_date < :date')
      ->andWhere('(s.schedule = :id OR s.id = :id)')
      ->setParameter('date', $schedule->getFirstDate()->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();
  }

  public function getAllBetween(\DateTime $start, \DateTime $end)
  {
    return $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule','s')
      ->where('s.first_date >= :start')
      ->andWhere('s.first_date <= :end')
      ->orderBy('s.first_date')
      ->setParameter('start', $start->format('Y-m-d H:i:s'))
      ->setParameter('end', $end->format('Y-m-d H:i:s'))
      ->getQuery()
      ->getResult();
  }

  public function getAllParent()
  {
    return $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule', 's')
      ->where('s.schedule IS NULL')
      ->getQuery()
      ->getResult();
  }

  public function getPrevSchedule(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;

    return $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule','s')
      ->where('s.first_date <= :date')
      ->andWhere('(s.id = :id OR s.schedule = :id)')
      ->setMaxResults(1)
      ->orderBy('s.first_date', 'DESC')
      ->setParameter('date', date('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getSingleResult();
  }
}
