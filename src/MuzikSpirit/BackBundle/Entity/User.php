<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Exception\UnsupportedException;

/**
 * User
 * @ORM\Table(name="user",
 * indexes={
 *      @ORM\Index(name="id", columns={"id"}),
 *      @ORM\Index(name="token_key", columns={"token_key"}),
 *      @ORM\Index(name="username", columns={"username"}),
 *      @ORM\Index(name="facebook_id", columns={"facebook_id"})
 * },
 * uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D64992FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_8D93D649A0D96FBF", columns={"email_canonical"})}
 * )
 * @ORM\Entity(repositoryClass="MuzikSpirit\BackBundle\Repository\UserRepository")
 */

class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="groups_id", type="integer", nullable=false)
     */
    private $groupsId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    private $bio;

    /**
     * @var string
     * @ORM\Column(name="website", type="string",length=255, nullable=true)
     */
    private $website;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean", nullable=true)
     */
    private $locked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expired", type="boolean", nullable=true)
     */
    private $expired;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=255, nullable=true)
     */
    private $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=255, nullable=true)
     */
    private $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="credentials_expired", type="boolean", nullable=true)
     */
    private $credentialsExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    private $credentialsExpireAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var string
     *
     * @ORM\Column(name="password_requested_at", type="string", length=255, nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="fid", type="integer", nullable=true)
     */
    private $fid;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, nullable=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountNonLocked", type="boolean", nullable=true)
     */
    private $accountnonlocked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accountNonExpired", type="boolean", nullable=true)
     */
    private $accountnonexpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_auth", type="datetime", nullable=true)
     */
    private $dateAuth;

    /**
     * @ORM\ManyToOne(targetEntity="Groups", inversedBy="user")
     * @ORM\JoinColumn(name="groups_id", referencedColumnName="id")
     **/

    private $groups;

    /**
     * @var string
     *
     * @ORM\Column(name="token_key", type="string", length=255, nullable=true)
     */
    private $tokenKey;

    /**
     * @var integer
     * @ORM\Column(name="facebook_id", type="integer", nullable=true)
     */
    private $facebookId;


    public function __construct()
    {
        $this->setDefaultValues();
    }

    public function setDefaultValues()
    {
        $this->dateCreated        = new \DateTime('now');
        $this->type               = 1;
        $this->enabled            = 1;
        $this->accountnonlocked   = 1;
        $this->accountnonexpired  = 1;
        $this->credentialsExpired = 1;
        $this->expired            = 0;
        $this->locked             = 0;
        $this->salt               = md5(uniqid(mt_rand(),true));
    }


    public function serialize(){
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized){
        list(
            $this->id,
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        // return array('ROLE_JEWELER');
        // retourne mon attribut groups en tableau
        // ArrayCollection => Array
        return array($this->groups->getName());
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

    public function eraseCredentials(){
        return null;
    }

    public function isEqualTo(UserInterface $user){
        return $this->username === $user->getUsername();
    }

    public function isAccountNonExpired(){
        /*  $dateCreated = $this->dateCreated;
          $dateoldyear = new \DateTime('-5 year');
          if($dateCreated < $dateoldyear){
              return false;
          }
        */
        return true;
    }

    public function isAccountNonLocked(){
        return $this->accountnonlocked;
    }
    public function isCredentialsNonExpired(){
        return $this->credentialsExpired;
    }

    public function isEnabled(){
        return $this->enabled;
    }
    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return User
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return User
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
     * Set type
     *
     * @param integer $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set usernameCanonical
     *
     * @param string $usernameCanonical
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * Get usernameCanonical
     *
     * @return string
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * Set emailCanonical
     *
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * Get emailCanonical
     *
     * @return string
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Set credentialsExpireAt
     *
     * @param \DateTime $credentialsExpireAt
     * @return User
     */
    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    /**
     * Get credentialsExpireAt
     *
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set passwordRequestedAt
     *
     * @param string $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return string
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Set fid
     *
     * @param integer $fid
     * @return User
     */
    public function setFid($fid)
    {
        $this->fid = $fid;

        return $this;
    }

    /**
     * Get fid
     *
     * @return integer
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return User
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
     * Set accountnonlocked
     *
     * @param boolean $accountnonlocked
     * @return User
     */
    public function setAccountnonlocked($accountnonlocked)
    {
        $this->accountnonlocked = $accountnonlocked;

        return $this;
    }

    /**
     * Get accountnonlocked
     *
     * @return boolean
     */
    public function getAccountnonlocked()
    {
        return $this->accountnonlocked;
    }

    /**
     * Set accountnonexpired
     *
     * @param boolean $accountnonexpired
     * @return User
     */
    public function setAccountnonexpired($accountnonexpired)
    {
        $this->accountnonexpired = $accountnonexpired;

        return $this;
    }

    /**
     * Get accountnonexpired
     *
     * @return boolean
     */
    public function getAccountnonexpired()
    {
        return $this->accountnonexpired;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    /**
     * @param string $tokenKey
     */
    public function setTokenKey($tokenKey)
    {
        $this->tokenKey = $tokenKey;
    }

    /**
     * Set groupsId
     *
     * @param integer $groupsId
     * @return User
     */
    public function setGroupsId($groupsId)
    {
        $this->groupsId = $groupsId;

        return $this;
    }

    /**
     * Get groupsId
     *
     * @return integer
     */
    public function getGroupsId()
    {
        return $this->groupsId;
    }

    /**
     * Set groups
     *
     * @param \MuzikSpirit\BackBundle\Entity\Groups $groups
     * @return User
     */
    public function setGroups(\MuzikSpirit\BackBundle\Entity\Groups $groups = null)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Get groups
     *
     * @return \MuzikSpirit\BackBundle\Entity\Groups
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return \DateTime
     */
    public function getDateAuth()
    {
        return $this->dateAuth;
    }

    /**
     * @param \DateTime $dateAuth
     */
    public function setDateAuth($dateAuth)
    {
        $this->dateAuth = $dateAuth;
    }

    /**
     * Set facebookId
     *
     * @param integer $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return integer
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Retourne le montant
     * @return float
     */
    public function __toString(){
        return $this->username;
    }
}
