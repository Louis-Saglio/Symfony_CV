<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getManager()->getRepository("AppBundle:article");
        return $this->render("@App/index.html.twig", ['articles'=>$repo->findAll()]);
    }

    /**
     * @Route("/article/{id}")
     */
    public function ArticleView($id)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository("AppBundle:article");
        return$this->render("@App/articleView.html.twig", ['article'=>$repo->find($id)]);
    }


}
