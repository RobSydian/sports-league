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

class EditMemberController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/member/{id}", name="edit_member", methods={"PUT"})
     */
    public function __invoke(Request $request, $id): Response
    {
        $body = json_decode($request->getContent(), true);

        $team = $this->em->getRepository(Team::class)->findOneBy([
            'id' => $body['team_id']
        ]);

        $memberRepository = $this->em->getRepository(Member::class);
        $member = $memberRepository->findOneBy([
            'id' => $id,
        ]);
        $member
            ->setName($body['name'])
            ->setFirstSurname($body['first_surname'])
            ->setSecondSurname($body['second_surname'])
            ->setPosition($body['position'])
            ->setTeam($team)
        ;

        $this->em->persist($member);
        $this->em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
