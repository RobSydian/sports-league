<?php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTeamsController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/teams", name="list_teams", methods={"GET"})
     */
    public function __invoke(): Response
    {
        $teams = $this->em->getRepository(Team::class)->findAll();
        $data = array_map(function (object $team) {
            return [
                'id' => $team->getId(),
                'name' => $team->getName(),
            ];
        }, $teams);

        return new JsonResponse(
            ['data' => $data],
            JsonResponse::HTTP_OK
        );
    }
}
