<?php
require_once __DIR__ . '/../src/GraphType.php';
require_once __DIR__ . '/Customer.php';

class Mutation extends GraphType
{
    private array $customers = [];

    public function createCustomer(string $name): Customer
    {
        $id = rand(100, 999);
        $customer = new Customer($id, $name);
        $this->customers[$id] = $customer;
        return $customer;
    }
}
