<?php
/**
 * Created by PhpStorm.
 * User: juliengrima
 * Date: 19/01/2017
 * Time: 09:39
 */

namespace MobileBundle\Services;

use MobileBundle\Entity\MobileList;
use CmsBundle\Entity\Artiste;
use MobileBundle\MobileBundle;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


class MobileService extends Controller
{
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;

    }

    public function getArtistes(){
//        Alias 's' = class searchrepository
//        Alias 'c' = categorie

        $repository = $this->getDoctrine()->getRepository('CmsBundle:Artiste');

        $qb = $repository->createQueryBuilder('p')
            ->select('p.id', 'p.nom', 'p.archive')
            ->where('p.archive = false')
            ->orderBy('p.archive', 'DESC');
        return $qb->getQuery()->getResult();
    }

//    public function getCommercants($m){
////        Alias 's' = class searchrepository
////        Alias 'c' = categorie
//
//        $repository = $this->getDoctrine()
//            ->getRepository('CmsBundle:Commercant');
//
//        $qb = $repository->createQueryBuilder('p')
//            ->select('p.id', 'p.nom')
//            ->orderBy('p.nom', 'DESC');
//        return $qb->getQuery()->getResult();
//    }
}