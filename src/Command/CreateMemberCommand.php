<?php

namespace App\Command;

class CreateMemberCommand
{
    private string $name;
    private string $firstSurname;
    private string $secondSurname;
    private string $position;
    private int $teamId;

    public function __construct(
        string $name,
        string $firstSurname,
        string $secondSurname,
        string $position,
        int $teamId
    ) {
        $this->name = $name;
        $this->firstSurname = $firstSurname;
        $this->secondSurname = $secondSurname;
        $this->position = $position;
        $this->teamId = $teamId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function firstSurname(): string
    {
        return $this->firstSurname;
    }

    public function secondSurname(): string
    {
        return $this->secondSurname;
    }

    public function position(): string
    {
        return $this->position;
    }

    public function teamId(): int
    {
        return $this->teamId;
    }
}
