<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ConferenceRepository;
use App\Repository\CommentRepository;
use App\Entity\Conference;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;
class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ConferenceRepository $conferenceRepository, SessionInterface $session): Response
    {
        dump($session->get('prueba'));
        $conferences = $conferenceRepository->findAll();
        return $this->render('conference/index.html.twig',[
            'conferences'=>$conferences
        ]);    
        
    }
    #[Route('/conference/{id}', name: 'conference')]
    public function show(Request $request, Environment $twig, Conference $conference, CommentRepository $commentRepository)
    {
        $offset = max(0, $request->query->getInt('offset', 0));
                $paginator = $commentRepository->getCommentPaginator($conference, $offset);
        
                 return new Response($twig->render('conference/show.html.twig', [
                     'conference' => $conference,
                    /* 'comments' => $commentRepository->findBy(['conference' => $conference], ['createdAt' => 'DESC']), */
                    'comments' => $paginator,
                    'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
                    'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
                 ]));
    }
}
