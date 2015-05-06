<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer toutes les images avec CreateQueryBuilder
     */
    public function getListImageQuery(){
        $query = $this->createQueryBuilder('image')
            ->orderBy('image.id', 'DESC');

        return $query;
    }

    /**
     * Création de la réquete pour récupérer toutes les images avec CreateQueryBuilder
     */
    public function getListImageByTypeQuery($type){
        $query = $this->createQueryBuilder('image')
            ->where('image.typeImage = :type')
            ->orderBy('image.id', 'DESC')
            ->setParameter('type',$type);

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'images avec le paramètre transmis en argument
     */
    public function searchImageQuery($find)
    {
        $query = $this->createQueryBuilder('image')
            ->where('image.titre LIKE :find')
            ->orderBy('image.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'images avec le paramètre transmis en argument ainsi que le type
     */
    public function searchImageByTypeQuery($find,$type)
    {
        $query = $this->createQueryBuilder('image')
            ->where('image.titre LIKE :find')
            ->andWhere("image.typeImage = :type ")
            ->orderBy('image.id', 'DESC')
            ->setParameter('find', '%' . $find . '%')
            ->setParameter('type', $type );

        return $query;
    }

    /**
     * Récupération la liste complète des "Image"
     */
    public function getResultImage(){
        $query = $this->getListNewsQuery()->getQuery();

        return $query->getResult();
    }

}