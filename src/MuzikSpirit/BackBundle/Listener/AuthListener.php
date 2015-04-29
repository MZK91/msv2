<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 10:48
 */

namespace MuzikSpirit\BackBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


/**
 * Class AuthentificationListener
 * @package Store\BackendBundle\Listener
 */
class AuthListener {


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;



    /**
     * Le constructeur de ma classe avec 2 arguments : l'Entity Manager et le  Contexte de Sécurité
     * @param EntityManager $em
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(EntityManager $em, SecurityContextInterface $securityContext) {

        // Je stocke dans 2 attributs les services récupérés
        $this->em = $em;
        $this->securityContext = $securityContext;
    }



    /**
     * Méthode qui est déclenchée après l'événement InteractiveLogin qui est l'action de login dans la sécurité
     * @param InteractiveLoginEvent $event
     */
    public function onAuthentificationSuccess(InteractiveLoginEvent $event) {

        $now = new \DateTime('now');
        // Récupère l'utilisateur courant connecté
        $user = $this->securityContext->getToken()->getUser();

        // Met à jour la date de connexion de l'utilisateur
        $user->setDateAuth($now);

        // Enregistre mon utilisateur avec sa date modifiée
        $this->em->persist($user);
        $this->em->flush();
    }

}