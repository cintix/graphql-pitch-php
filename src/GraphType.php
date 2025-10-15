<?php
abstract class GraphType
{
    public function getFields(): array
    {
        $fields = [];
        $reflect = new ReflectionClass($this);
        foreach ($reflect->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getNumberOfRequiredParameters() === 0 && $method->getDeclaringClass()->getName() !== 'GraphType') {
                $fields[$method->getName()] = $method;
            }
        }
        return $fields;
    }
}
