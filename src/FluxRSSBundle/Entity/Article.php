<?php

namespace FluxRSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 */
class Article
{
    /**
     * @var int
     */
    private $id;
    public function indexAction()
    {
        $format = $this->getRequest()->getRequestFormat();

        return $this->render('FluxRSSBundle:Article:index.'.$format.'.twig');
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
