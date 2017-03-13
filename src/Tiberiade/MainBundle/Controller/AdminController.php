<?php

namespace Tiberiade\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tiberiade\MainBundle\Entity\Article;

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
        $articles = $rep->findAll();
        return $this->render('TiberiadeMainBundle:Admin:articles.html.twig', array('articles' => $articles));
    }
    
    public function ajoutArticleAction()
    {
        $article = new Article();
        $form = $this->getFormulaireAjout($article);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $article->getUrlImage();
            $fileName = $file->getClientOriginalName();
            $file->move($this->getParameter('images_article'), $fileName);

            $article->setTitre($form->get('titre')->getData())
                    ->setDescription($form->get('description')->getData())
                    ->setResume($form->get('resume')->getData())
                    ->setUrlImage($fileName)
                    ->setDatePublication(new DateTime(date('Y-m-d')));
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('index'));
        }
        return array('article' => $article, 'form' => $form->createView());
    }
    
    protected function getFormulaireAjout($article) {
        $builder = $this->createFormBuilder($article);
        //Add form fields
        $builder->add('titre', 'text', array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 5,
                            'max' => 50,
                            'minMessage' => 'Le titre de l\'article doit comporter au minimum {{ limit }} caractères',
                            'maxMessage' => 'Le titre de l\'article doit comporter au maximum {{ limit }} caractères',
                                ))),
                    'label' => 'Titre de l\'article : '
                ))
                ->add('description', 'textarea', array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 20,
                            'max' => 2000,
                            'minMessage' => 'La description de l\'article doit comporter au minimum {{ limit }} caractères',
                            'maxMessage' => 'La description de l\'article doit comporter au maximum {{ limit }} caractères',
                                ))),
                    'label' => 'Description de l\'article : '
                ))
                ->add('resume', 'text', array(
                    'constraints' => array(new NotBlank(), new Length(array(
                            'min' => 5,
                            'max' => 50,
                            'minMessage' => 'Le résumé de l\'article doit comporter au minimum {{ limit }} caractères',
                            'maxMessage' => 'Le résumé de l\'article doit comporter au maximum {{ limit }} caractères',
                                ))),
                    'label' => 'Résumé de l\'article : '
                ))
                ->add('url_image', 'file')
                ->add('valider', 'submit');
        $form = $builder->getForm();
        $form->handleRequest($this->get('request'));

        return $form;
    }
}
