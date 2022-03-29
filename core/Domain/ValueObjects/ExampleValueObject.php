<?php

namespace Core\Domain\ValueObjects;

use InvalidArgumentException;

/**
* Os Objetos de Valor representam valores digitados e um tipo personalizado, diferente dos tipos primitivos
 * (string, int, float, etc..).
* É um dos componentes que serve para entrada ou saída de dados.
*
* Características Principais:
*
* - Igualdade de Valor: Os objetos de valor são definidos por seus atributos. Eles são iguais se seus atributos
 * forem iguais. Não possuem identidade (ID) como uma entidade
*
* - Imutabilidade: Uma vez criado, um objeto de valor deve ser sempre igual. A única maneira de mudar seu valor
 * é por substituição total.
*   Em código significa criar uma nova instância com o novo valor e não atualizar os dados de uma instância existente
*
* - Autovalidação: O objeto de valor deve verificar a validade de seus atributos ao ser criado. Se algum de seus
 * atributos for inválido,
*   o objeto não deve ser criado e um erro ou exceção deve ser levantado ou uma notificação de domínio pode ser criada.
*
* As vantagens arquitetônicas do Objeto de Valor é que reduz a obsessão por tipos primitivos, aumenta a segurança
 * e certeza sobre os dados informados,
* da mais flexibilidade para lidar com um número maior de dados, autovalidação (o próprio objeto é responsável
 * por garantir a consistência dos dados que recebe),
* redução de duplicação de código (Adeus a variáiveis ou indices de vetor duplicados), facilidade de leitura
 * pois o código é mais expressivo, melhor desempenho
* (Pois pode ser usado em paralelização sem risco), facilidade de cachear e criptografar (Pois são imutaveis)
*
* @see https://martinfowler.com/bliki/ValueObject.html
* @see https://martinfowler.com/articles/refactoring-adaptive-model.html#RemovePrimitiveObsession
**/

final class ExampleValueObject
{
    private string $street;

    private int $number;

    private string $postalCode;

    private const NUMERIC_INVALID_DATA = 'The number and postal code is invalid!';
    private const REQUIRED_DATA_EMPTY = 'The street and number is required';

    public function __construct(string $street, int $number, string $postalCode = null)
    {
        $this->street = $street;
        $this->number = $number;
        $this->postalCode = $postalCode;
    }

    public function isValid(): bool
    {
        if (!is_numeric($this->number) || !is_numeric($this->postalCode)) {
            throw new InvalidArgumentException(self::NUMERIC_INVALID_DATA);
        }

        if (empty($this->street) || empty($this->number)) {
            throw new InvalidArgumentException(self::REQUIRED_DATA_EMPTY);
        }

        return true;
    }

    public function equals($otherValueObject): bool
    {
        if (
            $otherValueObject->getStreet() === $this->street &&
            $otherValueObject->getNumber() === $this->number &&
            $otherValueObject->getPostalCode() === $this->postalCode
        ) {
            return true;
        }

        return false;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function __toString(): string
    {
        return "{Street $this->street}, number {$this->number} in postal code {$this->postalCode}";
    }
}
