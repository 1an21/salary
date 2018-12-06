<?php

namespace AppBundle\Entity\Repository;

class EmployeeRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchQuery()
    {
        return $this->_em->getRepository('AppBundle:Employee')->createQueryBuilder('e');
    }
    public function searchByQuery()
    {
        return $this->_em->getRepository('AppBundle:Employee')->createQueryBuilder('e');


    }

    public function searchInQuery($project)
    {
        return $this->_em->getRepository('AppBundle:Employee')->createQueryBuilder('e');

    }

    public function searchDoneQuery($project)
    {
        return $this->_em->getRepository('AppBundle:Employee')->createQueryBuilder('e');

    }

    public function searchDelayQuery($project)
    {
        return $this->_em->getRepository('AppBundle:Employee')->createQueryBuilder('e');

    }

    public function searchTrashQuery()
    {
        return $this->_em->getRepository('AppBundle:Employee')->createQueryBuilder('e')->where('e.status=1');
    }
    public function findOneByIdQuery($id)
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            WHERE p.id = :id
            "
        );
        $query->setParameter('id', $id);
        return $query;
    }
    public function findAllQuery()
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        return $query;
    }
    public function findInProgressQuery()
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        return $query;
    }
    public function findDoneQuery()
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        return $query;
    }

    public function findDelayQuery()
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        return $query;
    }

    public function findTrashQuery()
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        return $query;
    }

    public function findOnlyOwnByIdQuery($id, $userId)
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        $query->setParameter('id', $id);
        $query->setParameter('userId', $userId);
        return $query;
    }

    public function findOnlyOwnQuery( $userId)
    {
        $query = $this->_em->createQuery(
            "
            SELECT p
            FROM AppBundle:Employee p
            "
        );
        $query->setParameter('userId', $userId);
        return $query;
    }

    public function deleteQuery($id)
    {
        $query = $this->_em->createQuery(
            "
            DELETE 
            FROM AppBundle:Employee p        
            "
        );
        $query->setParameter('id', $id);

        return $query;
    }


//    public function getTimeQuery()
//    {
//        $query = $this->_em->createQuery(
//            "
//            SELECT SUBSTRING(SEC_TO_TIME(SUM(TIME_TO_SEC(p.dateFinished) - TIME_TO_SEC(p.dateStarted))),1,5)
//            FROM AppBundle:Employee p
//            "
//        );
//
//        return $query;
//    }
//
//    public function getTimeByQuery($project)
//    {
//        $query = $this->_em->createQuery(
//            "
//            SELECT SUBSTRING(SEC_TO_TIME(SUM(TIME_TO_SEC(p.dateFinished) - TIME_TO_SEC(p.dateStarted))),1,5)
//            FROM AppBundle:Employee p
//            JOIN AppBundle:Project pr WITH pr.id=p.project
//            WHERE pr.title = :project
//
//            "
//        );
//        $query->setParameter('project', $project);
//        return $query;
//    }


}
