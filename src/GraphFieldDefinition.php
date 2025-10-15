<?php
class GraphFieldDefinition {
    public string $name;
    public string $type;
    public array $args = [];
    public function __construct(string $name, string $type) {
        $this->name = $name;
        $this->type = $type;
    }
}
