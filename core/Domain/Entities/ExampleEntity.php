<?php

namespace Core\Domain\Entities;

class ExampleEntity extends AbstractBaseEntity
{

    private string $attribute1;
    private float $attribute2;

    private const REQUIRED_ATTRIBUTE = 'Essa informação é obrigatória';

    public function __construct(string $attribute1, float $attribute2)
    {
        $this->attribute1 = $attribute1;
        $this->attribute2 = $attribute2;
    }

    public function criar(array $dados): self
    {
        return self($dados['attribute1'], $dados['attribute2']);
    }

    public function validate(): void
    {
    }

    public function getAttribute1(): string
    {
        return $this->attribute1;
    }

    public function getAttribute2(): float
    {
        return $this->attribute2;
    }

    public function toArray(): array
    {
        return [
            'atributo_1' => $this->attribute1,
            'atributo_2' => $this->attribute2,
        ];
    }
}
