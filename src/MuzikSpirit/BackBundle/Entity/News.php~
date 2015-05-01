<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * News
 *
 * @ORM\Table(name="news", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="section_id", columns={"section_id"}), @ORM\Index(name="type_article_id", columns={"type_article_id"}), @ORM\Index(name="news_ibfk_4", columns={"artiste_id"})})
 * @ORM\Entity(repositoryClass="MuzikSpirit\BackBundle\Repository\NewsRepository")
 * @UniqueEntity(fields="titre", message="Le Titre doit être unique")
 */
class News
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
     * @Assert\NotBlank (
     *  message = "Ce champ ne doit pas être vide"
     * )
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="artiste", type="string", length=255, nullable=true)
     */
    private $artiste;

    /**
     * @var string
     *
     * @Assert\NotBlank (
     *  message = "Ce champ ne doit pas être vide"
     * )
     * @ORM\Column(name="thumb_news", type="string", length=255, nullable=true)
     */
    private $thumbNews;

    /**
     * @var string
     * @Assert\NotBlank (
     *  message = "Ce champ ne doit pas être vide"
     * )
     * @ORM\Column(name="texte", type="text", nullable=false)
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
     * @Assert\NotBlank (
     *  message = "Ce champ ne doit pas être vide"
     * )
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_coms", type="integer", nullable=false)
     */
    private $nbrComs = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="adult", type="boolean", nullable=false)
     */
    private $adult = false;

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
     * @ORM\Column(name="last_ip", type="string", length=255, nullable=true)
     */
    private $lastIp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_visit", type="datetime", nullable=true)
     */
    private $lastVisit;

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
     * @var \Artiste
     *
     * @ORM\ManyToOne(targetEntity="Artiste")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="artiste_id", referencedColumnName="id")
     * })
     */
    private $artiste2;

    public function __construct(){
        $this->date = new \DateTime();
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

    /**
     * Set titre
     *
     * @param string $titre
     * @return News
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
     * Set artiste
     *
     * @param string $artiste
     * @return News
     */
    public function setArtiste($artiste)
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * Get artiste
     *
     * @return string 
     */
    public function getArtiste()
    {
        return $this->artiste;
    }

    /**
     * Set thumbNews
     *
     * @param string $thumbNews
     * @return News
     */
    public function setThumbNews($thumbNews)
    {
        $this->thumbNews = $thumbNews;

        return $this;
    }

    /**
     * Get thumbNews
     *
     * @return string 
     */
    public function getThumbNews()
    {
        return $this->thumbNews;
    }

    /**
     * Set texte
     *
     * @param string $texte
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * Set nbrComs
     *
     * @param integer $nbrComs
     * @return News
     */
    public function setNbrComs($nbrComs)
    {
        $this->nbrComs = $nbrComs;

        return $this;
    }

    /**
     * Get nbrComs
     *
     * @return integer 
     */
    public function getNbrComs()
    {
        return $this->nbrComs;
    }

    /**
     * Set adult
     *
     * @param boolean $adult
     * @return News
     */
    public function setAdult($adult)
    {
        $this->adult = $adult;

        return $this;
    }

    /**
     * Get adult
     *
     * @return boolean 
     */
    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * Set facebook
     *
     * @param integer $facebook
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * Set artiste2
     *
     * @param \MuzikSpirit\BackBundle\Entity\Artiste $artiste2
     * @return News
     */
    public function setArtiste2(\MuzikSpirit\BackBundle\Entity\Artiste $artiste2 = null)
    {
        $this->artiste2 = $artiste2;

        return $this;
    }

    /**
     * Get artiste2
     *
     * @return \MuzikSpirit\BackBundle\Entity\Artiste 
     */
    public function getArtiste2()
    {
        return $this->artiste2;
    }

    /**
     * Retourne le titre
     * @return string
     */

    public function __toString(){
        return $this->titre;
    }
}
