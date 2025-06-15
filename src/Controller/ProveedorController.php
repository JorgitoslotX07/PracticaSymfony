<?php

namespace App\Controller;

use App\Doctrine\DBAL\Types\TipoProveedorType;
use App\Entity\Proveedor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProveedorController extends AbstractController
{

    public function list(EntityManagerInterface $em): Response
    {
        $proveedores = $em->getRepository(Proveedor::class)->findAll();
        $tipos = TipoProveedorType::getValues();
        return $this->render('proveedor/list.html.twig', [
            'proveedores' => $proveedores,
            'tipos'       => $tipos,
        ]);
    }

    public function new(): Response
    {
        $tipos = TipoProveedorType::getValues();

        return $this->render('admin/proveedor/new.html.twig', [
            'tipos' => $tipos,
        ]);
    }

    public function create(Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $nombre   = $request->request->get('nombre');
        $email    = $request->request->get('email');
        $telefono = $request->request->get('telefono');
        $tipo     = $request->request->get('tipo');
        $activo   = $request->request->get('activo');

        if (!$nombre || !$email || !$tipo) {
            $this->addFlash('error', 'Los campos nombre, email y tipo son obligatorios.');
            return $this->redirectToRoute('proveedor_new'); // ← ruta actualizada
        }

        $now = new \DateTime();
        $p = new Proveedor();
        $p->setNombre($nombre)
            ->setEmail($email)
            ->setTelefono($telefono ?: null)
            ->setTipo($tipo)
            ->setActivo($activo === '1')
            ->setCreatedAt($now)
            ->setUpdatedAt($now);

        $em->persist($p);
        $em->flush();

        $this->addFlash('success', 'Proveedor creado exitosamente.');

        return $this->redirectToRoute('proveedor_list');  // ← ruta correcta
    }

    public function show(int $id, EntityManagerInterface $em): Response
    {
        $p = $em->getRepository(Proveedor::class)->find($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        return $this->render('admin/proveedor/show.html.twig', [
            'proveedor' => $p,
        ]);
    }

    public function edit(int $id, EntityManagerInterface $em): Response
    {
        $p = $em->getRepository(Proveedor::class)->find($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        return $this->render('admin/proveedor/edit.html.twig', [
            'proveedor' => $p,
        ]);
    }

    public function update(int $id, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $p = $em->getRepository(Proveedor::class)->find($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        $nombre   = $request->request->get('nombre');
        $email    = $request->request->get('email');
        $telefono = $request->request->get('telefono');
        $tipo     = $request->request->get('tipo');
        $activo   = $request->request->get('activo');

        if (!$nombre || !$email || !$tipo) {
            $this->addFlash('error', 'Los campos nombre, email y tipo son obligatorios.');
            return $this->redirectToRoute('proveedor_edit', ['id' => $id]);
        }

        $p->setNombre($nombre)
            ->setEmail($email)
            ->setTelefono($telefono ?: null)
            ->setTipo($tipo)
            ->setActivo($activo === '1')
            ->setUpdatedAt(new \DateTime());

        $em->flush();

        $this->addFlash('success', 'Proveedor actualizado.');

        $returnTo = $request->request->get('_return_to');
        if ($returnTo) {
            return $this->redirect($returnTo);
        }

        return $this->redirectToRoute('proveedor_show', ['id' => $id]);
    }

    public function delete(int $id, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $p = $em->getRepository(Proveedor::class)->find($id);
        if (!$p) {
            throw $this->createNotFoundException('Proveedor no encontrado.');
        }

        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em->remove($p);
            $em->flush();
            $this->addFlash('success', 'Proveedor eliminado.');
        } else {
            $this->addFlash('error', 'Token CSRF inválido.');
        }

        return $this->redirectToRoute('proveedor_list'); // ← ruta actualizada
    }
}
