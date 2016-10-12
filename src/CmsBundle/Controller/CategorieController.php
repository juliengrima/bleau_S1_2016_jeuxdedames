<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Categorie;
use CmsBundle\Form\CategorieType;

/**
 * Categorie controller.
 *
 */
class CategorieController extends Controller
{
    /**
     * Lists all Categorie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('CmsBundle:Categorie')->findBy(array(), array('nomDeLaCategorie' => 'asc'));

        return $this->render('CmsBundle:categorie:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new Categorie entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm('CmsBundle\Form\CategorieType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('categorie_index', array('id' => $categorie->getId()));
        }

        return $this->render('CmsBundle:categorie:new.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }
    

    /**
     * Displays a form to edit an existing Categorie entity.
     *
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $editForm = $this->createForm('CmsBundle\Form\CategorieType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('categorie_edit', array('id' => $categorie->getId()));
        }

        return $this->render('CmsBundle:categorie:edit.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Categorie entity.
     *
     */
    public function deleteAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('CmsBundle:Categorie')->find($id);
        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        if (!$categorie) {
            throw $this->createNotFoundException(
                'Pas de catégorie trouvée' . $id
            );
        }
        else{
            foreach ($artistes as $key => $artiste){
                if ($artiste->getCategorie() == $categorie->getNomDeLaCategorie()){

                    $request->getSession()
                        ->getFlashBag()
                        ->add('error',  'Afin de supprimer cette catégorie, il faut au préalable supprimer tous les artistes concernés par celle ci')
                    ;

                    $url = $this->generateUrl('categorie_index');
                    return $this->redirect($url);
                }
            }
        }

        $em->remove($categorie);
        $em->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success',  'Suppression confirmée')
        ;

        $url = $this->generateUrl('categorie_index');
        return $this->redirect($url);
    }
}
