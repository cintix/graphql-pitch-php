<?php
class GraphExecutor
{
    public function execute($root, array $queryAst): array
    {
        $result = [];
        $reflect = new ReflectionClass($root);
        foreach ($queryAst as $field => $subFields) {
            $args = $subFields['args'] ?? [];
            $nested = $subFields['fields'] ?? [];

            if ($reflect->hasMethod($field)) {
                $method = $reflect->getMethod($field);
                $value = $method->invokeArgs($root, array_values($args));
            } elseif ($reflect->hasProperty($field)) {
                $property = $reflect->getProperty($field);
                $property->setAccessible(true);
                $value = $property->getValue($root);
            } else {
                continue;
            }

            if (is_object($value) && !empty($nested)) {
                $result[$field] = $this->execute($value, $nested);
            } elseif (is_array($value) && !empty($nested)) {
                $result[$field] = array_map(fn($v) => $this->execute($v, $nested), $value);
            } else {
                $result[$field] = $value;
            }
        }
        return $result;
    }
}
