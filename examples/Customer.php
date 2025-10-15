<?php
require_once __DIR__ . '/../src/GraphType.php';
class Customer extends GraphType {
    public function __construct(private int $id = 42, private string $name = 'Mix') {}
    public function id() { return $this->id; }
    public function name() { return $this->name; }
}
