<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function list(): Response
    {
        return $this->render('admin/users/list.html.twig', [
            'users' => $this->userService->getAllUsers(),
        ]);
    }

    public function new(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('plainPassword');
            $roles = $request->request->get('roles', ['ROLE_USER']);

            if (!$plainPassword) {
                $this->addFlash('error', 'La contraseña es requerida.');
                return $this->render('admin/users/new.html.twig');
            }

            $user = (new User())
                ->setEmail($email)
                ->setRoles($roles);

            $this->userService->registerUser($user, $plainPassword);
            $this->addFlash('success', 'Usuario creado correctamente.');

            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('admin/users/new.html.twig');
    }

    public function create(Request $request): Response
    {
        $email = $request->request->get('email');
        $plainPassword = $request->request->get('plainPassword');
        $roles = $request->request->get('roles', ['ROLE_USER']);

        if (!$plainPassword) {
            $this->addFlash('error', 'La contraseña es requerida.');
            return $this->render('admin/users/new.html.twig');
        }

        $user = (new User())
            ->setEmail($email)
            ->setRoles($roles);

        $this->userService->registerUser($user, $plainPassword);

        $this->addFlash('success', 'Usuario creado correctamente.');

        return $this->redirectToRoute('admin_users_list');
    }


    public function edit(Request $request, int $id): Response
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('plainPassword');
            $roles = $request->request->get('roles', ['ROLE_USER']);

            $user->setEmail($email);
            $user->setRoles($roles);

            $this->userService->updateUser($user, $plainPassword);
            $this->addFlash('success', 'Usuario actualizado correctamente.');

            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
        ]);
    }

    public function delete(Request $request, int $id): Response
    {
        if (!$this->isCsrfTokenValid('delete_user_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF inválido');
            return $this->redirectToRoute('admin_users_list');
        }

        $user = $this->userService->getUserById($id);
        if (!$user) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $this->userService->deleteUser($user);
        $this->addFlash('success', 'Usuario eliminado correctamente.');

        return $this->redirectToRoute('admin_users_list');
    }
}
