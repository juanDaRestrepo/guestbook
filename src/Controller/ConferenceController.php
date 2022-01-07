<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class ConferenceController extends AbstractController
{
    #[Route('/hello/{name}', name: 'conference')]
    public function index(string $name): Response
    {
        
        return $this->render('conference/index.html.twig',[
            'name'=>$name,
        ]);    
    
    }
}
