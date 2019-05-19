<?php


namespace App\Controller\Rest;

use App\Application\Service\UserService;
use App\Domain\Model\User;
use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractFOSRestController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/users", name="create_user",  methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);
        if ($form->isValid()) {
            $user = $this->userService->addUser($user);
            $view = $this->view(array('id' => $user->getId()), JsonResponse::HTTP_CREATED);

            return $this->handleView($view);
        }
        $view = $this->view($form->getErrors(true, true), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        return $this->handleView($view);
    }

    /**
     * @Route("/users", name="get_users",  methods={"GET"})
     */
    public function listAction()
    {
        $view = $this->view($this->userService->getAll(), JsonResponse::HTTP_OK);

        return $this->handleView($view);
    }
}
