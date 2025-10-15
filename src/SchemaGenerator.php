<?php
class SchemaGenerator
{
    public function generate($root): GraphSchema
    {
        $schema = new GraphSchema();
        $this->collectType($root, $schema);
        return $schema;
    }

    private function collectType($obj, GraphSchema $schema)
    {
        $reflect = new ReflectionClass($obj);
        $typeName = $reflect->getShortName();
        if (isset($schema->types[$typeName])) return;

        $typeDef = new GraphTypeDefinition($typeName);
        foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getNumberOfRequiredParameters() > 0) continue;
            $returnType = $method->getReturnType();
            $returnName = $returnType ? $returnType->getName() : 'Mixed';
            $typeDef->addField(new GraphFieldDefinition($method->getName(), $returnName));
            if (class_exists($returnName)) {
                try {
                    $instance = new $returnName(...[]);
                    $this->collectType($instance, $schema);
                } catch (Throwable $e) {}
            }
        }
        $schema->addType($typeDef);
    }
}
