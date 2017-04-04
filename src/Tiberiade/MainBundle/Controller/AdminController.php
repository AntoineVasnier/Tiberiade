<?php

namespace Tiberiade\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tiberiade\MainBundle\Entity\Actualite;
use Tiberiade\MainBundle\Entity\Article;
use Tiberiade\MainBundle\Forms\actualiteType;
use Tiberiade\MainBundle\Forms\articleType;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('TiberiadeMainBundle:Admin:admin.html.twig');
    }
    
    public function articlesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('TiberiadeMainBundle:Article');
        $articles = $rep->getLastArticles(5);
        return $this->render('TiberiadeMainBundle:Admin:articles.html.twig', array('articles' => $articles));
    }
    
    public function actualitesAction()
    {
        $em = $this-> getDoctrine()->getManager();
        $rep = $em->getRepository('TiberiadeMainBundle:Actualite');
        $actualites = $rep->getLastActualites(5);
        return $this->render('TiberiadeMainBundle:Admin:actualites.html.twig', array('actualites' => $actualites));
    }


    public function ajoutArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(articleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $file = $article->getFile();
                $fileName = $file->getClientOriginalName();
                $file->move($this->getParameter('images_article'), $fileName);
                $article->setUrlImage($fileName);
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute("admin_article");
            }else{
                 return $this->render('TiberiadeMainBundle:Admin:articles_ajout.html.twig', array(
                     'article' => $article,
                     'form' => $form->createView()
                 ));
            }
        }
        return $this->render('TiberiadeMainBundle:Admin:articles_ajout.html.twig', array('article' => $article, 'form' => $form->createView()));
    }
    
    public function ajoutActualiteAction(Request $request)
    {
        $actualite = new Actualite();
        $form = $this->createForm(actualiteType::class, $actualite);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $file = $actualite->getFile();
                $fileName = $file->getClientOriginalName();
                $file->move($this->getParameter('images_actus'), $fileName);
                $actualite->setUrlImage($fileName);
                $em->persist($actualite);
                $em->flush();
                return $this->redirectToRoute("admin_actualite");
            }else{
                 return $this->render('TiberiadeMainBundle:Admin:actualites_ajout.html.twig', array(
                     'actualite' => $actualite,
                     'form' => $form->createView()
                 ));
            }
        }
        return $this->render('TiberiadeMainBundle:Admin:actualites_ajout.html.twig', array('actualite' => $actualite, 'form' => $form->createView()));
    }
    
    protected function getFormulaireAjout(Request $request) {
        
        return array('form' => $form->createView());
    }
}
