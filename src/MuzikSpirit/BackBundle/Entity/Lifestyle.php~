<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Lifestyle
 *
 * @ORM\Table(name="lifestyle", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="section_id", columns={"section_id"}), @ORM\Index(name="type_article_id", columns={"type_article_id"}), @ORM\Index(name="category_lifestyle_id", columns={"category_lifestyle_id"})})
 * @ORM\Entity
 */
class Lifestyle
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="text", nullable=true)
     */
    private $media;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text", nullable=true)
     */
    private $texte;

    /**
     * @var integer
     *
     * @ORM\Column(name="vues", type="integer", nullable=false)
     */
    private $vues = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="vues_dif", type="integer", nullable=false)
     */
    private $vuesDif = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=false)
     */
    private $duration = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="facebook", type="integer", nullable=false)
     */
    private $facebook = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="twitter", type="integer", nullable=false)
     */
    private $twitter = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="last_ip", type="string", length=255, nullable=false)
     */
    private $lastIp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_visit", type="datetime", nullable=false)
     */
    private $lastVisit = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer", nullable=false)
     */
    private $likes = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="dislikes", type="integer", nullable=false)
     */
    private $dislikes = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float", precision=10, scale=0, nullable=false)
     */
    private $score = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255, nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     * })
     */
    private $section;

    /**
     * @var \TypeArticle
     *
     * @ORM\ManyToOne(targetEntity="TypeArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_article_id", referencedColumnName="id")
     * })
     */
    private $typeArticle;

    /**
     * @var \TypeArticleLifestyle
     *
     * @ORM\ManyToOne(targetEntity="TypeArticleLifestyle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_lifestyle_id", referencedColumnName="id")
     * })
     */
    private $categoryLifestyle;



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
     * @return Lifestyle
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
     * Set media
     *
     * @param string $media
     * @return Lifestyle
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set texte
     *
     * @param string $texte
     * @return Lifestyle
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set vues
     *
     * @param integer $vues
     * @return Lifestyle
     */
    public function setVues($vues)
    {
        $this->vues = $vues;

        return $this;
    }

    /**
     * Get vues
     *
     * @return integer 
     */
    public function getVues()
    {
        return $this->vues;
    }

    /**
     * Set vuesDif
     *
     * @param integer $vuesDif
     * @return Lifestyle
     */
    public function setVuesDif($vuesDif)
    {
        $this->vuesDif = $vuesDif;

        return $this;
    }

    /**
     * Get vuesDif
     *
     * @return integer 
     */
    public function getVuesDif()
    {
        return $this->vuesDif;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Lifestyle
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Lifestyle
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Lifestyle
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set facebook
     *
     * @param integer $facebook
     * @return Lifestyle
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return integer 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param integer $twitter
     * @return Lifestyle
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return integer 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     * @return Lifestyle
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string 
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set lastVisit
     *
     * @param \DateTime $lastVisit
     * @return Lifestyle
     */
    public function setLastVisit($lastVisit)
    {
        $this->lastVisit = $lastVisit;

        return $this;
    }

    /**
     * Get lastVisit
     *
     * @return \DateTime 
     */
    public function getLastVisit()
    {
        return $this->lastVisit;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     * @return Lifestyle
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer 
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set dislikes
     *
     * @param integer $dislikes
     * @return Lifestyle
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;

        return $this;
    }

    /**
     * Get dislikes
     *
     * @return integer 
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * Set score
     *
     * @param float $score
     * @return Lifestyle
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Lifestyle
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Lifestyle
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set user
     *
     * @param \MuzikSpirit\BackBundle\Entity\User $user
     * @return Lifestyle
     */
    public function setUser(\MuzikSpirit\BackBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MuzikSpirit\BackBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set section
     *
     * @param \MuzikSpirit\BackBundle\Entity\Section $section
     * @return Lifestyle
     */
    public function setSection(\MuzikSpirit\BackBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \MuzikSpirit\BackBundle\Entity\Section 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set typeArticle
     *
     * @param \MuzikSpirit\BackBundle\Entity\TypeArticle $typeArticle
     * @return Lifestyle
     */
    public function setTypeArticle(\MuzikSpirit\BackBundle\Entity\TypeArticle $typeArticle = null)
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    /**
     * Get typeArticle
     *
     * @return \MuzikSpirit\BackBundle\Entity\TypeArticle 
     */
    public function getTypeArticle()
    {
        return $this->typeArticle;
    }

    /**
     * Set categoryLifestyle
     *
     * @param \MuzikSpirit\BackBundle\Entity\TypeArticleLifestyle $categoryLifestyle
     * @return Lifestyle
     */
    public function setCategoryLifestyle(\MuzikSpirit\BackBundle\Entity\TypeArticleLifestyle $categoryLifestyle = null)
    {
        $this->categoryLifestyle = $categoryLifestyle;

        return $this;
    }

    /**
     * Get categoryLifestyle
     *
     * @return \MuzikSpirit\BackBundle\Entity\TypeArticleLifestyle 
     */
    public function getCategoryLifestyle()
    {
        return $this->categoryLifestyle;
    }

    /**
     * Retourne le titre
     * @return string
     */

    public function __toString(){
        return $this->titre;
    }
}
