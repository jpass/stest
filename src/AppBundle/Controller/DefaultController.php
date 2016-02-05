<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/varnish", name="varnish")
     */
    public function varnishAction(Request $request)
    {
        $file = $this->get('kernel')->getRootDir().'/../'.$this->getParameter('varnish_log_file');

        $varnishLogReader = $this->get('reader.varnishlog');
        $varnishLogReader->read($file);

        $topHosts = $varnishLogReader->getTopHosts(5);
        $topFiles = $varnishLogReader->getTopPaths(5);

        return new JsonResponse(array(
            'topHosts' => $topHosts,
            'topFiles' => $topFiles
        ));
    }

    /**
     * @Route("/rss", name="rss")
     */
    public function rssAction(Request $request)
    {
        $uri = $this->getParameter('rss_uri');

        $rssReader = $this->get('reader.rss');
        $parsed = $rssReader->read($uri);

        return new JsonResponse(array(
            'articles' => $parsed
        ));
    }
}
