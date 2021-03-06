<?php

namespace AppBundle\Controller;

use AppBundle\Entity\comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("", name="blog")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository("AppBundle:article");

        return $this->render("@App/index.html.twig", [
            'articles'=> $repo->findAll()
        ]);
    }

    /**
     * @Route("/article/{id}")
     */
    public function ArticleView(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = new comment();

        $form = $this->get("form.factory")->createBuilder(FormType::class, $comment)
            ->add('body', TextareaType::class)
            ->add('Poster', SubmitType::class)
            ->getForm()
        ;

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $comment->setArticleId($id);
            if ($form->isValid()) {
                $em->persist($comment);
                $em->flush();
            }
        }

        return $this->render("@App/articleView.html.twig", [
            'article' => $em->getRepository("AppBundle:article")->find($id),
            'comments' => $em->getRepository("AppBundle:comment")->findBy(["articleId" => $id]),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function ViewCV(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository("AppBundle:formation")->findAll();
        $experiences = $em->getRepository("AppBundle:experience")->findAll();
        return $this->render("AppBundle::CV.html.twig", [
            'formations' => $formations,
            'experiences' => $experiences
        ]);
    }
}
