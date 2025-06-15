<?php

namespace App\Controller;

use App\Service\ProveedorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProveedorController extends AbstractController
{
    private ProveedorService $proveedorService;

    public function __construct(ProveedorService $proveedorService) {
        $this->proveedorService = $proveedorService;
    }

    public function list(): Response
    {
        return $this->render('proveedor/list.html.twig', [
            'proveedores' => $this->proveedorService->getAllProveedores(),
            'tipos'       => $this->proveedorService->getTipos(),
        ]);
    }

    public function new(): Response
    {
        return $this->render('admin/proveedor/new.html.twig', [
            'tipos' => $this->proveedorService->getTipos(),
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $data = $request->request->all();
        $proveedor = $this->proveedorService->createProveedor($data);

        if (!$proveedor) {
            $this->addFlash('error', 'Los campos nombre, email y tipo son obligatorios.');
            return $this->redirectToRoute('proveedor_new');
        }

        $this->addFlash('success', 'Proveedor creado exitosamente.');
        return $this->redirectToRoute('proveedor_list');
    }

    public function show(int $id): Response
    {
        $p = $this->proveedorService->getProveedorById($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        return $this->render('admin/proveedor/show.html.twig', [
            'proveedor' => $p,
        ]);
    }

    public function edit(int $id): Response
    {
        $p = $this->proveedorService->getProveedorById($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        return $this->render('admin/proveedor/edit.html.twig', [
            'proveedor' => $p,
        ]);
    }

    public function update(int $id, Request $request): RedirectResponse
    {
        $p = $this->proveedorService->getProveedorById($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        $data = $request->request->all();
        if (empty($data['nombre']) || empty($data['email']) || empty($data['tipo'])) {
            $this->addFlash('error', 'Los campos nombre, email y tipo son obligatorios.');
            return $this->redirectToRoute('proveedor_edit', ['id' => $id]);
        }

        $this->proveedorService->updateProveedor($p, $data);
        $this->addFlash('success', 'Proveedor actualizado.');

        return $this->redirectToRoute('proveedor_show', ['id' => $id]);
    }

    public function delete(int $id, Request $request): RedirectResponse
    {
        $p = $this->proveedorService->getProveedorById($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->proveedorService->deleteProveedor($p);
            $this->addFlash('success', 'Proveedor eliminado.');
        } else {
            $this->addFlash('error', 'Token CSRF inválido.');
        }

        return $this->redirectToRoute('proveedor_list');
    }
}
