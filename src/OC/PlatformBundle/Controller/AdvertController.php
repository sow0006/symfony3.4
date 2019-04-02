<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse; // N'oubliez pas ce use
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class AdvertController extends Controller
{
  public function indexAction()
  {
       // Recuperer URL de l'annonce
       $url = $this->generateURL('oc_platform_view', // 1er argument
                              array('id' => 5)    // 2eme argument
                             );
    return new Response ("L'URL de l'annonce d'id 5 est : ".$url);
  }

  // on doit donc définir la méthode viewAction.
  // On donne à cette méthode l'argument $id, pour
  // correspondre au paramètre {id} de la route
  public function viewAction($id, Request $request)
  {
    // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
    //$response = new Response(json_encode(array('id' => $id)));

    // Ici, nous définissons le Content-type pour dire au navigateur
    // que l'on renvoie du JSON et non du HTML
    //$response->headers->set('Content-Type', 'application/json');

    //return new JsonResponse(array('id' => $id));

    // Récupération de la session
    $session = $request->getSession();

    // On recupere le contenu de la variable user_id
    $userId = $request->get('user_id');

    // On definit une nouvelle valeur pour cette variable user_id
    $session->set('user_id', 91);

    // on oublie pas de renvoyer une réponse
    return new Response("Je suis une page de test, je n'ai rien à dire");
  }

  public function viewSlugAction($slug, $year, $_format)
  {
    return new Response("On pourrait afficher l'annonce correspondant du 
    slug '".$slug."', créée en ".$year." et au format ".$_format.".");
  }
}