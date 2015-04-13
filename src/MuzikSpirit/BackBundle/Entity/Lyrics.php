<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lyrics
 *
 * @ORM\Table(name="lyrics", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="section_id", columns={"section_id"}), @ORM\Index(name="type_article_id", columns={"type_article_id"}), @ORM\Index(name="lyrics_ibfk_4", columns={"artiste_id"})})
 * @ORM\Entity
 */
class Lyrics
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
     * @var integer
     *
     * @ORM\Column(name="album_id", type="integer", nullable=true)
     */
    private $albumId;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="artiste", type="string", length=255, nullable=false)
     */
    private $artiste;

    /**
     * @var string
     *
     * @ORM\Column(name="son", type="string", length=255, nullable=false)
     */
    private $son;

    /**
     * @var string
     *
     * @ORM\Column(name="featuring", type="string", length=255, nullable=true)
     */
    private $featuring;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @var string
     *
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
     * @var boolean
     *
     * @ORM\Column(name="vide", type="boolean", nullable=false)
     */
    private $vide = '0';

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
     * Set albumId
     *
     * @param integer $albumId
     * @return Lyrics
     */
    public function setAlbumId($albumId)
    {
        $this->albumId = $albumId;

        return $this;
    }

    /**
     * Get albumId
     *
     * @return integer 
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Lyrics
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
     * @return Lyrics
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
     * Set son
     *
     * @param string $son
     * @return Lyrics
     */
    public function setSon($son)
    {
        $this->son = $son;

        return $this;
    }

    /**
     * Get son
     *
     * @return string 
     */
    public function getSon()
    {
        return $this->son;
    }

    /**
     * Set featuring
     *
     * @param string $featuring
     * @return Lyrics
     */
    public function setFeaturing($featuring)
    {
        $this->featuring = $featuring;

        return $this;
    }

    /**
     * Get featuring
     *
     * @return string 
     */
    public function getFeaturing()
    {
        return $this->featuring;
    }

    /**
     * Set media
     *
     * @param string $media
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * Set vide
     *
     * @param boolean $vide
     * @return Lyrics
     */
    public function setVide($vide)
    {
        $this->vide = $vide;

        return $this;
    }

    /**
     * Get vide
     *
     * @return boolean 
     */
    public function getVide()
    {
        return $this->vide;
    }

    /**
     * Set user
     *
     * @param \MuzikSpirit\BackBundle\Entity\User $user
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
     * @return Lyrics
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
}
