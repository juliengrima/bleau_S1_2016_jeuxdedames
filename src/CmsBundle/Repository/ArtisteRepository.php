<?php

namespace CmsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArtisteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtisteRepository extends EntityRepository
{
    public function getIdItemArtiste()
        {
            return $this->getEntityManager()
                ->createQuery(
                    'SELECT MAX(a.item_id) FROM CmsBundle:Artiste a'
                )
                ->getResult();
        }
}
