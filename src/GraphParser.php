<?php
class GraphParser
{
    private string $input;
    private int $pos = 0;

    public function parse(string $input): array
    {
        $this->input = trim($input);
        $this->pos = 0;
        $this->skipWhitespace();

        // Default operation type
        $operation = 'query';

        // Tjek for "mutation" i starten
        if (stripos($this->input, 'mutation') === 0) {
            $operation = 'mutation';
            $this->pos += strlen('mutation');
        }

        $this->skipWhitespace();
        $fields = $this->parseBlock();

        return [
            'operation' => $operation,
            'fields' => $fields
        ];
    }

    private function parseBlock(): array
    {
        $this->consume('{');
        $fields = [];

        while (true) {
            $this->skipWhitespace();
            if ($this->peek() === '}') {
                $this->consume('}');
                break;
            }

            $name = $this->parseName();
            $this->skipWhitespace();

            // Læs evt. argumenter
            $args = [];
            if ($this->peek() === '(') {
                $args = $this->parseArguments();
                $this->skipWhitespace();
            }

            if ($this->peek() === '{') {
                $fields[$name] = [
                    'args' => $args,
                    'fields' => $this->parseBlock()
                ];
            } else {
                $fields[$name] = [
                    'args' => $args,
                    'fields' => []
                ];
            }

            $this->skipWhitespace();
        }

        return $fields;
    }

    private function parseArguments(): array
    {
        $args = [];
        $this->consume('(');

        while (true) {
            $this->skipWhitespace();
            if ($this->peek() === ')') {
                $this->consume(')');
                break;
            }

            $name = $this->parseName();
            $this->skipWhitespace();
            $this->consume(':');
            $this->skipWhitespace();

            $value = $this->parseValue();
            $args[$name] = $value;

            $this->skipWhitespace();
            if ($this->peek() === ',') {
                $this->consume(',');
                continue;
            }
        }

        return $args;
    }

    private function parseValue(): mixed
    {
        $char = $this->peek();

        // String literal
        if ($char === '"') {
            $this->consume('"');
            $start = $this->pos;
            while ($this->pos < strlen($this->input) && $this->input[$this->pos] !== '"') {
                $this->pos++;
            }
            $value = substr($this->input, $start, $this->pos - $start);
            $this->consume('"');
            return $value;
        }

        // Number literal
        $start = $this->pos;
        while ($this->pos < strlen($this->input) && preg_match('/[0-9.\-]/', $this->input[$this->pos])) {
            $this->pos++;
        }
        $numStr = substr($this->input, $start, $this->pos - $start);
        return is_numeric($numStr) ? $numStr + 0 : $numStr;
    }

    private function parseName(): string
    {
        $start = $this->pos;
        while ($this->pos < strlen($this->input) && preg_match('/[A-Za-z0-9_]/', $this->input[$this->pos])) {
            $this->pos++;
        }
        return substr($this->input, $start, $this->pos - $start);
    }

    private function skipWhitespace(): void
    {
        while ($this->pos < strlen($this->input) && ctype_space($this->input[$this->pos])) {
            $this->pos++;
        }
    }

    private function consume(string $char): void
    {
        $this->skipWhitespace();
        if ($this->pos >= strlen($this->input) || $this->input[$this->pos] !== $char) {
            throw new Exception("Expected '$char' at position {$this->pos}");
        }
        $this->pos++;
    }

    private function peek(): ?string
    {
        return $this->pos < strlen($this->input) ? $this->input[$this->pos] : null;
    }
}
