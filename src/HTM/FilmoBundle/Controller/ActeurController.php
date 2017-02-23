<?php

namespace HTM\FilmoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HTM\FilmoBundle\Entity\Acteur;
use HTM\FilmoBundle\Form\ActeurType;
use Symfony\Component\HttpFoundation\Response;

class ActeurController extends Controller
{
    public function ajoutAction()
    {

    	$message="Ajouter un Acteur";
    	$em=$this->getDoctrine()->getManager();

    	$Acteur = new Acteur();
    	$form=$this->createForm(new ActeurType(), $Acteur);

    	$request=$this->getRequest();

    	if($request->getMethod()=='POST'){

    		$form->handleRequest($request);

    		if($form->isValid()){

    			$em->persist($Acteur);
    			$em->flush();
    			//$message="valiiiiiiiiiiiiiiiide :) ";
                return $this->redirectToRoute('acteur');
    		}


    	}


        return $this->render('FilmoBundle:Acteur:edit.html.twig',array(
        		'form'=>$form->createView(),
        		'msg'=>$message,
        	)
        );

    }
    public function afficheAction(){

        $em=$this->getDoctrine()->getManager();

        $acteurs=$em->getRepository('FilmoBundle:Acteur')->findAll();

        return $this->render('FilmoBundle:Acteur:acteurs.html.twig',array('acteurs'=>$acteurs));

    }
    public function modifierAction($id){

        $message="Modifier un Acteur";
        $em=$this->getDoctrine()->getManager();

        $Acteur = $em->getRepository('FilmoBundle:Acteur')->find($id);
        $form=$this->createForm(new ActeurType(), $Acteur);

        $request=$this->getRequest();

        if($request->getMethod()=='POST'){

            $form->handleRequest($request);

            if($form->isValid()){                
                $em->flush();
                //$message="valiiiiiiiiiiiiiiiide :) ";
                return $this->redirectToRoute('acteur');
            }


        }


        return $this->render('FilmoBundle:Acteur:edit.html.twig',array(
                'form'=>$form->createView(),
                'msg'=>$message,
            )
        );


    }

    public function supprimerAction($id){

        $em=$this->getDoctrine()->getManager();

        $Acteur = $em->find('FilmoBundle:Acteur',$id);

        if(!$Acteur)
        {
            throw $this->createNotFoundException('Acteur avec l\'id '. $id .' n\'existe pas');
        }

        $em->remove($Acteur);
        $em->flush();

        //return new Response('Acteur supprimer avec succsées !!!!');
        return $this->redirectToRoute('acteur');
    }
}
