<?php

namespace Tiberiade\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tiberiade\MainBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repArticle = $em->getRepository('TiberiadeMainBundle:Article');
        $articles = $repArticle->getLastArticles(10);
        return $this->render('TiberiadeMainBundle:Default:index.html.twig', array('articles' => $articles));
    }
    
    public function connexionAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('TiberiadeMainBundle:Default:connexion.html.twig', ['last_username' => $lastUsername,
            'error'         => $error,
            ]);
    }
    
    public function creerCompteAction(Request $request){
        if (empty($request->request->all())){
            return $this->render('TiberiadeMainBundle:Default:creationCompte.html.twig');
        }else{
            $utilisateur = new Utilisateur();
            $utilisateur->setUsername($request->request->get('username'))
                    ->setPassword($request->request->get('password'))
                    ->setNom($request->request->get('nom'))
                    ->setPrenom($request->request->get('prenom'))
                    ->setEmail($request->request->get('email'))
                    ->setRole('utilisateur');
            $password = $this->get('security.password_encoder')->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirect($this->generateUrl('connexion'));
        }
    }
}
