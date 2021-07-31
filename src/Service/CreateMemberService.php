<?php

namespace App\Service;

use App\Command\CreateMemberCommand;
use App\Entity\Member;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class CreateMemberService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(CreateMemberCommand $command)
    {
        $team = $this->em->getRepository(Team::class)->findOneBy([
            'id' => $command->teamId()
        ]);

        if (!$team) {
            throw new Exception(
                sprintf(
                    'Team with id %s not found.',
                    $command->teamId()
                )
            );
        }

        $member = (new Member())
            ->setName($command->name())
            ->setFirstSurname($command->firstSurname())
            ->setSecondSurname($command->secondSurname())
            ->setPosition($command->position())
            ->setTeam($team)
        ;

        $this->em->persist($member);
        $this->em->flush();
    }
}
