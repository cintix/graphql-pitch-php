<?php
require_once __DIR__ . '/../src/GraphType.php';
require_once __DIR__ . '/Customer.php';
class Query extends GraphType {
    public function customer(): Customer { return new Customer(); }
    public function message(): string { return "Hello from PHP GraphQL Pitch!"; }
}
