<?php
require_once __DIR__ . '/../src/GraphParser.php';
require_once __DIR__ . '/../src/GraphExecutor.php';
require_once __DIR__ . '/Query.php';
require_once __DIR__ . '/Mutation.php';

$mutationString = <<<GQL
mutation {
  createCustomer(name: "Sara") {
    id
    name
  }
}
GQL;

$queryString = <<<GQL
{
  customer {
    id
    name
  }
  message
}
GQL;

$parser = new GraphParser();
$executor = new GraphExecutor();

$ast = $parser->parse($queryString);
$result = $executor->execute(new Query(), $ast['fields']);

$ast2 = $parser->parse($mutationString);
$result2 = $executor->execute(new Mutation(), $ast2['fields']);


header('Content-Type: application/json');
echo json_encode(['data' => $result, 'data2' => $result2], JSON_PRETTY_PRINT);
