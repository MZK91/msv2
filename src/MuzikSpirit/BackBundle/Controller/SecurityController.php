<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\User;
use MuzikSpirit\BackBundle\Form\UserRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
/*        $username = $request->request->get('_username');

        if($username != null) {
            exit(dump($username));
            $em = $this->getDoctrine()->getManager();

            $dql = "SELECT user FROM MuzikSpiritBackBundle:User user WHERE user.username = :username OR user.email = :email";
            $query = $em->createQuery($dql);
            $query->setParameter(':username', $username);
            $query->setParameter(':email', $username);

            try {
                $user = $query->getSingleResult();
                $password = $user->getPassword();
            } catch (\Doctrine\Orm\NoResultException $e) {
                $user = $password = null;
            }

            if ($password == '' && $user != NULL) {

                $user->setTokenKey(uniqid() . uniqid());
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('muzikspirit_front_statics_mailmdp', array('username' => $user->getUsername()));

            }
        }
*/

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('MuzikSpiritBackBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'action' => 'muzikspirit_back_security_login_check',
            'error' => $error,
        ));
    }



    public function registerAction(Request $request){

        //creation du formulaire via le type
        $form = $this->createForm(new UserRegisterType());
        $em = $this->getDoctrine()->getEntityManager();
        $user = new User();
        $form = $this->createForm(new UserRegisterType(), $user, [
            'attr' =>
                [
                    'method' => 'post',
                    //Permet de définir un scope de validation
                    'novalidate' => 'novalidate', //Permet de zaper la validation required html5
                    'action' => $this->generateUrl('muzikspirit_back_security_register')
                ]
        ]);

        //Hydratation du formulaire
        $form->handleRequest($request);

        //Test la validité des datas envoyés
        if ($form->isValid()) {

            //Recupération du factory encoder
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            //J'encode le mdp avec le salt en utilisant le factory
            $password = $form['password']->getData();
            $password = $encoder->encodePassword($password, $user->getSalt());
            $user->setPassword($password);

            //Récupération du groupe et ajout du group au nouvel utilisateur
            $group = $this->getDoctrine()->getEntityManager()->getRepository('MuzikSpiritBackBundle:Groups')->find(3);
            $user->setGroups($group);

            //exit(dump($user));
            //Persist and flush
            $em->persist($user);
            $em->flush();
            //J'envoie un message flash de confirmation
            $this->get('session')->getFlashbag()->add('success','Votre compte à bien été enregistré. ');
            $this->get('session')->getFlashbag()->add('info','Vous devez valider votre compte par email');

            //Je redirige l'utilisateur vers la page de login
            return $this->redirect($this->generateUrl('muzikspirit_back_security_login'));
        }

        return $this->render('MuzikSpiritBackBundle:Security:register.html.twig',
            array(
                'form'=> $form->createView(),
                'error'=> ''
            )
        );

    }

    public function checkAction(Request $request){
        return $this->render('MuzikSpiritBackBundle:Security:login.html.twig',array('error'=> ''));

    }

}