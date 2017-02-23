<?php 
namespace HTM\FilmoBundle\Repository;


class FilmRepository extends \Doctrine\ORM\EntityRepository
{


	public function findFilmsBytitre($motcle){
		$query = $this->createQueryBuilder('f')
            ->where('f.titre like :titre')
            ->setParameter('titre', $motcle.'%')
            ->orderBy('f.titre', 'ASC')
            ->getQuery();

        return $query->getResult();
	}
}