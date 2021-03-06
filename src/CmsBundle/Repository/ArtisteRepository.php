<?php

namespace CmsBundle\Repository;

use CmsBundle\Entity\Categorie;
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


    /**
     * @param $min integer
     * @param $max integer
     * @param $quantity integer
     * @return array
     * Generate array with random id
     */
    private function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    /**
     * @return mixed
     * Get nb rows in Artiste where imageSlider = true
     */
    private function getNbRowsInArtisteWhereAjoutSliderTrue(){
        $qb = $this->createQueryBuilder('a');
        $qb->select('count(a.id)')
            ->where('a.ajouterslider = true');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return array
     * Get random image
     */
    public function getImageSlider(){
        $random_ids = $this->UniqueRandomNumbersWithinRange(1, $this->getNbRowsInArtisteWhereAjoutSliderTrue(),15);
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.image')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $random_ids);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $categorie Categorie
     * @return array
     * Get All artistes where Archive == false
     * And if search form, where Categorie is defined
     */
    public function getAllArtisteArchiveFalse($categorie){
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.nom', 'a.image', 'a.id', 'a.lien')
            ->where('a.archive = false')
            ->join('a.categorie', 'c')
            ->addSelect('c.nomDeLaCategorie as categorie');
        if ($categorie != null){
            $qb->where('c = :categorie')
                ->setParameter('categorie', $categorie);
        }
            $qb->orderBy('a.nom', 'ASC');
        return $qb->getQuery()->getResult();
    }
}
