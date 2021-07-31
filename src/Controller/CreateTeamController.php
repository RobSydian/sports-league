<?php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTeamController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/team", name="create_team")
     */
    public function create(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);
        $team = (new Team())->setName($body['name']);

        $this->em->persist($team);
        $this->em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
