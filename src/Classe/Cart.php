<?php

namespace App\Classe;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $session;

    public function __construct(RequestStack $session)
    {
        $this->session = $session;
    }
    public function add($id)
    {
        $this->session->getSession()->set("cart", [
            [
                "id" => $id,
                "quantity" => 1
            ]
        ]);
    }

    public function get()
    {
        return $this->session->getCurrentRequest()->get("cart");
    }
    public function remove()
    {
        
    }
}