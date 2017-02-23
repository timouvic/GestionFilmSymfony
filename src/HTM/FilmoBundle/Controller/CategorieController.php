<?php

namespace HTM\FilmoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HTM\FilmoBundle\Entity\Categorie;

class CategorieController extends Controller
{
    public function ajoutAction()
    {

    	$em=$this->getDoctrine()->getManager();

    	$categorie= new Categorie();

    	$categorie->setNom('romance');
    	$em->persist($categorie);

    	$categorie1= new Categorie();

    	$categorie1->setNom('action');
    	$em->persist($categorie1);

    	$categorie2= new Categorie();

    	$categorie2->setNom('thriller');
    	$em->persist($categorie2);

    	$em->flush();

        return $this->render('FilmoBundle:Categorie:ajout.html.twig');
    }

    public function afficheAction(){

    	$em=$this->getDoctrine()->getManager();

    	$categories=$em->getRepository('FilmoBundle:Categorie')->findAll();

    	return $this->render('FilmoBundle:Categorie:affiche.html.twig', array(
    			'categ'=>$categories
    		));

    }

}
