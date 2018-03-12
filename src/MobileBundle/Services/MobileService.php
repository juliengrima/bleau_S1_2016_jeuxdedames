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

//        $repository = $this->getDoctrine()
//            ->getRepository('CmsBundle:Artiste');

        $em = $this->getDoctrine ()->getManager ();
        $repository = $em->getRepository ('CmsBundle:Artiste');

        $qb = $repository->createQueryBuilder('a')
            ->select('a.id', 'a.nom')
            ->Where ('a.archive = false')
//            ->andWhere ('a.commercant1 >= 0' ANd )
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
                'co3.code as codeco3', 'co3.ville as villeco3', 'co3.lat as latco3', 'co3.lng as lngco3')
            ->orderBy ('a.nom');

        return $qb->getQuery()->getResult();

    }



    public function getjsonJob(){
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
                'co3.code as codeco3', 'co3.ville as villeco3', 'co3.lat as latco3', 'co3.lng as lngco3')
            ->orderBy ('ca.nomDeLaCategorie');

        return $qb->getQuery()->getResult();
    }

//    ---------------------------------------------------------------------------------------------------


}