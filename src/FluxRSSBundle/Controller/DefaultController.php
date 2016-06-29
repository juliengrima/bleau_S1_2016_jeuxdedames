<?php

namespace FluxRSSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FluxRSSBundle:Default:index.html.twig');
    }
$format = $this->getRequest()->getRequestFormat();

return $this->render('FluxRSSBundle:Category:show.html.twig', array(
'category' => $category,
'last_page' => $last_page,
'previous_page' => $previous_page,
'current_page' => $page,
'next_page' => $next_page,
'total_jobs' => $total_jobs,
'feedId' => sha1($this->get('router')->generate('FluxRSSBundle_category', array('slug' =>  $category->getSlug(), '_format' => 'atom'), true)),
));
}
