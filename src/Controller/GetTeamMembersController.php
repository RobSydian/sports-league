<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Team;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTeamMembersController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/team/{teamId}/members", name="list_team_members", methods={"GET"})
     */
    public function __invoke(Request $request, $teamId): Response
    {
        $team = $this->em->getRepository(Team::class)->findOneBy(['id' => $teamId]);
        if (!$team) {
            return new JsonResponse(
                ['error' => sprintf('Team with id %s does not exist', $teamId)],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $members = $this->em
            ->getRepository(Member::class)
            ->findBy(['team' => $teamId])
        ;

        $teamMembers = array_map(function (object $member) {
            return [
                'id' => $member->getId(),
                'name' => $member->getName(),
                'firstSurname' => $member->getFirstSurname(),
                'secondSurname' => $member->getSecondSurname(),
                'position' => $member->getPosition(),
                'team' => $member->getTeam()->getName()
            ];
        }, $members);

        return new JsonResponse(
            ['data' => $teamMembers],
            JsonResponse::HTTP_OK
        );
    }
}
