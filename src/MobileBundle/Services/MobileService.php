<?php
/**
 * Created by PhpStorm.
 * User: juliengrima
 * Date: 19/01/2017
 * Time: 09:39
 */

namespace MobileBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


class MobileService extends Controller
{
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;

    }

    public function getjsonArtistesFalse(){
//        Alias 'a' = artiste
//        Alias 'ca' = categorie
//        Alias 'co1' = commercant1
//        Alias 'co2' = commercant2
//        Alias 'co3' = commercant3

        $repository = $this->getDoctrine()
            ->getRepository('CmsBundle:Artiste');

        $qb = $repository->createQueryBuilder('a')
            ->select('a.id', 'a.nom')
            ->Where ('a.archive = false')
            ->join ('a.categorie', 'ca')
            ->addSelect('ca.nomDeLaCategorie')
            ->join ('a.commercant1', 'co1')
            ->addSelect ('co1.nom as nomco1', 'co1.adresse as adresseco1',
                                'co1.code as codeco1', 'co1.ville as villeco1', 'co1.lat as latco1', 'co1.lng as lngco1')
            ->join ('a.commercant2', 'co2')
            ->addSelect ('co2.nom as nomco2', 'co2.adresse as adresseco2',
                                'co2.code as codeco2', 'co2.ville as villeco2', 'co2.lat as latco2', 'co2.lng as lngco2')
            ->join ('a.commercant3', 'co3')
            ->addSelect ('co3.nom as nomco3', 'co3.adresse as adresseco3',
                                'co3.code as codeco3', 'co3.ville as villeco3', 'co3.lat as latco3', 'co3.lng as lngco3');

        return $qb->getQuery()->getResult();
    }

//    public function getjsonArtistesFalse(){
////        Alias 'p' = class mobileList
////        Alias 'ca' = categorie
////        Alias 'co' = commercants
////        Alias 'i' = artistess
//
//        $repository = $this->getDoctrine()
//            ->getRepository('MobileBundle:MobileList');
//
//        $qb = $repository->createQueryBuilder('p')
//            ->select('p.id')
//            ->Where ('p.dateFin > CURRENT_DATE()')
//            ->andWhere ('p.dateDebut >= CURRENT_DATE()')
//            ->join ('p.artistess', 'i')
//            ->addSelect('i.nom', 'i.archive')
//            ->andWhere ('i.archive = false')
//            ->orderBy ('i.nom', 'DESC')
//            ->join ('i.categorie', 'ca')
//            ->addSelect ('ca.nomDeLaCategorie')
//            ->join ('p.commercants', 'co')
//            ->addSelect ('co.nom as nomco', 'co.adresse', 'co.code', 'co.ville', 'co.lat', 'co.lng');
//
//        return $qb->getQuery()->getResult();
//    }
//
//    public function getjsonCommercant(){
////        Alias 'p' = class mobileList
////        Alias 'ca' = categorie
////        Alias 'co' = commercants
////        Alias 'i' = artistess
//
//        $repository = $this->getDoctrine()
//            ->getRepository('MobileBundle:MobileList');
//
//        $qb = $repository->createQueryBuilder('p')
//            ->select('p.id')
//            ->Where ('p.dateFin > CURRENT_DATE()')
//            ->andWhere ('p.dateDebut >= CURRENT_DATE()')
//            ->join ('p.artistess', 'i')
//            ->addSelect('i.nom', 'i.archive')
//            ->andWhere ('i.archive = false')
//            ->join ('i.categorie', 'ca')
//            ->addSelect ('ca.nomDeLaCategorie')
//            ->join ('p.commercants', 'co')
//            ->addSelect ('co.nom as nomco', 'co.adresse', 'co.code', 'co.ville', 'co.lat', 'co.lng')
//            ->orderBy ('co.nomco', 'DESC');
//
//        return $qb->getQuery()->getResult();
//    }
//
//    public function getjsonJob(){
////        Alias 'p' = class mobileList
////        Alias 'ca' = categorie
////        Alias 'co' = commercants
////        Alias 'i' = artistess
//
//        $repository = $this->getDoctrine()
//            ->getRepository('MobileBundle:MobileList');
//
//        $qb = $repository->createQueryBuilder('p')
//            ->select('p.id')
//            ->Where ('p.dateFin > CURRENT_DATE()')
//            ->andWhere ('p.dateDebut >= CURRENT_DATE()')
//            ->join ('p.artistess', 'i')
//            ->addSelect('i.nom', 'i.archive')
//            ->andWhere ('i.archive = false')
//            ->join ('i.categorie', 'ca')
//            ->addSelect ('ca.nomDeLaCategorie')
//            ->orderBy ('ca.nomDeLaCategorie', 'DESC')
//            ->join ('p.commercants', 'co')
//            ->addSelect ('co.nom as nomco', 'co.adresse', 'co.code', 'co.ville', 'co.lat', 'co.lng');
//
//        return $qb->getQuery()->getResult();
//    }
}