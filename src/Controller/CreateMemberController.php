<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateMemberController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/member", name="create_member")
     */
    public function create(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);
        
        $team = $this->em->getRepository(Team::class)->findOneBy([
            'id' => $body['team_id']
        ]);
        
        $member = (new Member())
            ->setName($body['name'])
            ->setFirstSurname($body['first_surname'])
            ->setSecondSurname($body['second_surname'])
            ->setPosition($body['position'])
            ->setTeam($team)
        ;

        $this->em->persist($member);
        $this->em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
