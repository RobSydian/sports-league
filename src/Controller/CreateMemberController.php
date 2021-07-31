<?php

namespace App\Controller;

use App\Command\CreateMemberCommand;
use App\Service\CreateMemberService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateMemberController extends AbstractController
{
    private CreateMemberService $createMemberService;

    public function __construct(CreateMemberService $createMemberService)
    {
        $this->createMemberService = $createMemberService;
    }

    /**
     * @Route("/api/member", name="create_member")
     */
    public function create(Request $request): Response
    {
        try {
            $body = json_decode($request->getContent(), true);

            $this->createMemberService->__invoke(new CreateMemberCommand(
                $body['name'],
                $body['first_surname'],
                $body['second_surname'],
                $body['position'],
                $body['team_id']
            ));

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            return new JsonResponse(
                [
                    'error' => $e->getMessage()
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}
