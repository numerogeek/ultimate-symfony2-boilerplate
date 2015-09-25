<?php

namespace Numerogeek\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Numerogeek\BlogBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Numerogeek\BlogBundle\Form\SearchType;

/**
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="blog_index")
     * @Template
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('NumerogeekBlogBundle:Post')->findLatest($online = true);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, $request->query->getInt('page', 1)/* page number */, 5/* limit per page */
        );

        $search = $this->get('form.factory')->create(new SearchType(), null, array(
            'action' => $this->generateUrl('blog_search'), ));

        return array(
            'pagination' => $pagination,
            'search' => $search->createView(),
        );
    }

    /**
     * @Route("/recherche", name = "blog_search")
     *
     * @Method("POST")
     * @Template
     */
    public function searchAction(Request $request)
    {
        $search = $this->get('form.factory')->create(new SearchType(), null, array(
            'action' => $this->generateUrl('blog_search'), ));
        $search->handleRequest($request);

        $keyword = $search->get('keyword')->getData();

        if ($search->isValid()) {
            $posts = $this->getDoctrine()
                ->getManager()
                ->getRepository('NumerogeekBlogBundle:Post')
                ->search($keyword);

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $posts, $request->query->getInt('page', 1)/* page number */, 5/* limit per page */
            );
        }

        return array('pagination' => $pagination, 'keyword' => $keyword, 'search' => $search->createView());
    }

    /**
     * @Route("/{slug}", name="blog_show")
     * @Template
     */
    public function postShowAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $nextPost = $em->getRepository('NumerogeekBlogBundle:Post')->findNext($post);

        return compact('post', 'nextPost');
    }
}
