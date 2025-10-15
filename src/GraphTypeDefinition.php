<?php
class GraphTypeDefinition {
    public string $name;
    public array $fields = [];
    public function __construct(string $name) { $this->name = $name; }
    public function addField(GraphFieldDefinition $field): void { $this->fields[$field->name] = $field; }
    public function toSDL(): string {
        $lines = ["type {$this->name} {"];
        foreach ($this->fields as $field) { $lines[] = "  {$field->name}: {$field->type}"; }
        $lines[] = "}";
        return implode("\n", $lines);
    }
}
