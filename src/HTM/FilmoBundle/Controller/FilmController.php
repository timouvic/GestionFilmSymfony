<?php

namespace HTM\FilmoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HTM\FilmoBundle\Entity\Film;
use HTM\FilmoBundle\Form\FilmType;

/**
 * Film controller.
 *
 */
class FilmController extends Controller
{

    /**
     * Lists all Film entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request=$this->getRequest();

        $listefilms = $em->getRepository('FilmoBundle:Film')->findAll();

         $entities  = $this->get('knp_paginator')->paginate(
         $listefilms,
         $request->query->get('page', 1)/*page number*/,
         6/*limit per page*/
    );

        return $this->render('FilmoBundle:Film:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Film entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Film();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->upload();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('film_show', array('id' => $entity->getId())));
        }

        return $this->render('FilmoBundle:Film:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Film entity.
     *
     * @param Film $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Film $entity)
    {
        $form = $this->createForm(new FilmType(), $entity, array(
            'action' => $this->generateUrl('film_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Film entity.
     *
     */
    public function newAction()
    {
        $entity = new Film();
        $form   = $this->createCreateForm($entity);

        return $this->render('FilmoBundle:Film:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Film entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FilmoBundle:Film')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Film entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FilmoBundle:Film:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Film entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FilmoBundle:Film')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Film entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FilmoBundle:Film:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Film entity.
    *
    * @param Film $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Film $entity)
    {
        $form = $this->createForm(new FilmType(), $entity, array(
            'action' => $this->generateUrl('film_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Film entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FilmoBundle:Film')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Film entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $entity->upload();
            $em->flush();

            return $this->redirect($this->generateUrl('film_edit', array('id' => $id)));
        }

        return $this->render('FilmoBundle:Film:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Film entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FilmoBundle:Film')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Film entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('film'));
    }

    /**
     * Creates a form to delete a Film entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('film_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        

        $motcle=$request->get('motcle');

        $listefilms = $em->getRepository('FilmoBundle:Film')->findFilmsBytitre($motcle);
        

         $entities  = $this->get('knp_paginator')->paginate(
         $listefilms,
         $request->query->get('page', 1)/*page number*/,
         1/*limit per page*/
    );

        return $this->render('FilmoBundle:Film:index.html.twig', array(
            'entities' => $entities,
        ));
    }
}
