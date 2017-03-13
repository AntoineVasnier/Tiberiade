<?php

namespace Tiberiade\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository{
    
    public function getLastArticles($nbArticles)
    {
        $request = 'SELECT a
            FROM TiberiadeMainBundle:Article a
            ORDER BY a.datePublication DESC';
        $query = $this->getEntityManager()->createQuery($request);
        $query->setFirstResult(0);
        $query->setMaxResults($nbArticles);
        return $query->getResult();
    }
}
