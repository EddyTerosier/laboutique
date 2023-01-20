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
        $methodset = $this->session->getSession();
        $cart = $this->session->$methodset->get("cart", []);

        if (!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $methodset->set("cart", $cart);
    }

    public function get()
    {
        $methodget = $this->session->getSession();
        return $methodget->get("cart");
    }
    public function remove()
    {
        $methodremove = $this->session->getSession();
        return $methodremove->remove("cart");
    }
}