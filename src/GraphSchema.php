<?php
class GraphSchema {
    public ?GraphTypeDefinition $queryType = null;
    public ?GraphTypeDefinition $mutationType = null;
    public array $types = [];

    public function addType(GraphTypeDefinition $type): void {
        $this->types[$type->name] = $type;
    }

    public function query(object $obj): void {
        $def = new GraphTypeDefinition('Query');
        $this->queryType = $def;
        $this->addType($def);
    }

    public function mutation(object $obj): void {
        $def = new GraphTypeDefinition('Mutation');
        $this->mutationType = $def;
        $this->addType($def);
    }

    public function toSDL(): string {
        $lines = [];
        if ($this->queryType) $lines[] = $this->queryType->toSDL();
        if ($this->mutationType) $lines[] = $this->mutationType->toSDL();
        foreach ($this->types as $t) {
            if ($t !== $this->queryType && $t !== $this->mutationType)
                $lines[] = $t->toSDL();
        }
        return implode("\n\n", $lines);
    }
}
