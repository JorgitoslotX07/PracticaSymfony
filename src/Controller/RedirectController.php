<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class RedirectController
{
    #[Route('/', name: 'homepage_redirect')]
    public function redirectToProveedores(RouterInterface $router): RedirectResponse
    {
        return new RedirectResponse($router->generate('proveedor_list'));
    }
}
