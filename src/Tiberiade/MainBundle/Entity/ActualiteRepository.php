<?php

namespace Tiberiade\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ActualiteRepository extends EntityRepository{
    
    public function getLastActualites($nbActualites)
    {
        $request = 'SELECT a
            FROM TiberiadeMainBundle:Actualite a
            ORDER BY a.dateDebut DESC';
        $query = $this->getEntityManager()->createQuery($request);
        $query->setFirstResult(0);
        $query->setMaxResults($nbActualites);
        return $query->getResult();
    }
}
