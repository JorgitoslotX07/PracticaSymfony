<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private UserService $userService;
    private EntityManagerInterface $em;

    public function __construct(UserService $userService, EntityManagerInterface $em)
    {
        $this->userService = $userService;
        $this->em = $em;
    }

    public function list(): Response
    {
        $users = $this->em->getRepository(User::class)->findAll();

        return $this->render('admin/users/list.html.twig', [
            'users' => $users,
        ]);
    }

    public function new(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('plainPassword');
            $roles = $request->request->get('roles', ['ROLE_USER']); // por defecto ROLE_USER

            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);

            if ($plainPassword) {
                $this->userService->registerUser($user, $plainPassword);
            } else {
                $this->addFlash('error', 'La contraseña es requerida.');
                return $this->render('admin/users/new.html.twig');
            }

            $this->addFlash('success', 'Usuario creado correctamente.');

            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('admin/users/new.html.twig');
    }

    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('plainPassword');
            $roles = $request->request->get('roles', ['ROLE_USER']);

            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);

            if ($plainPassword) {
                $this->userService->registerUser($user, $plainPassword);
            } else {
                $this->addFlash('error', 'La contraseña es requerida.');
                return $this->render('admin/users/new.html.twig', ['user' => $user]);
            }

            $this->addFlash('success', 'Usuario creado correctamente.');

            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('admin/users/new.html.twig');
    }


    public function edit(Request $request, int $id): Response
    {
        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('plainPassword');
            $roles = $request->request->get('roles', ['ROLE_USER']);

            $user->setEmail($email);
            $user->setRoles($roles);

            if ($plainPassword) {
                $this->userService->registerUser($user, $plainPassword);
            } else {
                // Sin cambio de contraseña, solo persistimos otros cambios
                $this->em->flush();
            }

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

        $user = $this->em->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        $this->em->remove($user);
        $this->em->flush();

        $this->addFlash('success', 'Usuario eliminado correctamente.');

        return $this->redirectToRoute('admin_users_list');
    }
}
