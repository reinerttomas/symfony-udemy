<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\FlashTrait;
use App\Dto\UserChangePasswordRequest;
use App\Dto\UserCreateRequest;
use App\Dto\UserUpdateRequest;
use App\Entity\User;
use App\Exception\Logic\NotFoundException;
use App\Exception\ORM\ORMStoreException;
use App\Exception\Runtime\AuthenticationException;
use App\Form\UserChangePasswordType;
use App\Form\UserCreateType;
use App\Form\UserUpdateType;
use App\Services\UserCreateService;
use App\Services\UserFetchService;
use App\Services\UserPasswordService;
use App\Services\UserUpdateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    use FlashTrait;

    private UserFetchService $userFetchService;
    private UserCreateService $userCreateService;
    private UserUpdateService $userUpdateService;
    private UserPasswordService $userPasswordService;

    public function __construct(
        UserFetchService $userFetchService,
        UserCreateService $userCreateService,
        UserUpdateService $userUpdateService,
        UserPasswordService $userPasswordService,
    ) {
        $this->userFetchService = $userFetchService;
        $this->userCreateService = $userCreateService;
        $this->userUpdateService = $userUpdateService;
        $this->userPasswordService = $userPasswordService;
    }

    #[Route('/user', name: 'admin-user-list')]
    public function index(): Response
    {
        $users = $this->userFetchService->list();

        return $this->render(
            'admin/user/index.html.twig',
            [
                'users' => $users,
            ],
        );
    }

    #[Route('/user/detail/{id}', name: 'admin-user-detail')]
    public function detail(int $id): Response
    {
        try {
            $user = $this->userFetchService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->render(
            'admin/user/detail.html.twig',
            [
                'user' => $user,
            ],
        );
    }

    #[Route('/user/create', name: 'admin-user-create')]
    public function create(Request $request): Response
    {
        $userCreatedRequest = new UserCreateRequest();

        $form = $this->createForm(UserCreateType::class, $userCreatedRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->userCreateService->createFromRequest($userCreatedRequest);
                $this->addFlashSuccess('User create success.');

                return $this->redirectToDetail($user);
            } catch (ORMStoreException) {
                $this->addFlashError('User form error.');
            }
        }

        return $this->render(
            'admin/user/create.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }

    #[Route('/user/update/{id}', name: 'admin-user-update')]
    public function update(Request $request, int $id): Response
    {
        try {
            $user = $this->userFetchService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $userUpdateRequest = UserUpdateRequest::from($user);

        $form = $this->createForm(UserUpdateType::class, $userUpdateRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->userUpdateService->updateFromRequest($user, $userUpdateRequest);
                $this->addFlashSuccess('User updated success.');

                return $this->redirectToDetail($user);
            } catch (ORMStoreException) {
                $this->addFlashError('User form error.');
            }
        }

        return $this->render(
            'admin/user/update.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }

    #[Route('/user/password/{id}', name: 'admin-user-password')]
    public function password(Request $request, int $id): Response
    {
        try {
            $user = $this->userFetchService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $userChangePasswordRequest = new UserChangePasswordRequest();

        $form = $this->createForm(UserChangePasswordType::class, $userChangePasswordRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->userPasswordService->changeFromRequest($user, $userChangePasswordRequest);
                $this->addFlashSuccess('Password change success.');

                return $this->redirectToDetail($user);
            } catch (AuthenticationException) {
                $this->addFlashWarning('Password is not valid.');
            } catch (ORMStoreException) {
                $this->addFlashError('Password form error.');
            }
        }

        return $this->render(
            'admin/user/password.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ],
        );
    }

    private function redirectToDetail(User $user): Response
    {
        return $this->redirectToRoute(
            'admin-user-detail',
            [
                'id' => $user->getId(),
            ],
        );
    }
}
