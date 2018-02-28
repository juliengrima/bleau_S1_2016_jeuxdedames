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

    public function getjsonArtistesFalse(){
//        Alias 'p' = class mobileList
//        Alias 'ca' = categorie
//        Alias 'co' = commercants
//        Alias 'a' = artistess

        $repository = $this->getDoctrine()
            ->getRepository('MobileBundle:MobileList');

        $qb = $repository->createQueryBuilder('p')
            ->select('p.id')
            ->Where ('p.dateFin < CURRENT_DATE()')
            ->join ('p.artistess', 'i')
            ->addSelect('i.nom', 'i.archive')
            ->where ('i.archive = false')
            ->orderBy ('i.nom', 'DESC')
            ->join ('i.categorie', 'ca')
            ->addSelect ('ca.nomDeLaCategorie')
            ->join ('p.commercants', 'co')
            ->addSelect ('co.nom as nomco', 'co.adresse', 'co.code', 'co.ville', 'co.lat', 'co.lng');

        return $qb->getQuery()->getResult();
    }
}

//            ->setParameter('dateNow', new \DateTime(), \Doctrine\DBAL\Types\Type::DATETIME)