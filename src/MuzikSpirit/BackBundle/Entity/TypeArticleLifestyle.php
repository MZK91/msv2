<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeArticleLifestyle
 *
 * @ORM\Table(name="type_article_lifestyle", indexes={@ORM\Index(name="url", columns={"url"})})
 * @ORM\Entity
 */
class TypeArticleLifestyle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=125, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=125, nullable=false)
     */
    private $url;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return TypeArticleLifestyle
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return TypeArticleLifestyle
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Retourne le titre
     * @return string
     */

    public function __toString(){
        return $this->titre;
    }
}
