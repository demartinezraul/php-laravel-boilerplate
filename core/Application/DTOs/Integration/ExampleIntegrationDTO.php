<?php

namespace Core\Application\DTOs;

/**
 * @OA\Schema(
 *      title="ExampleDTO",
 *      description="Representa os dados da requisição ou resposta para uma API externa",
 *      type="object",
 *      required={"atribute1", "atribute2", "atribute3"}
 * )
 */
class ExampleIntegrationDTO
{

    /**
     * @OA\Property(
     *     title="atribute1",
     *     description="atributo1 do DTO",
     *     example=Uma string qualquer",
     *     type="string"
     * )
     */
    public string $atribute1;

    /**
     * @OA\Property(
     *     title="atribute2",
     *     description="atributo2 do DTO",
     *     example=Uma string qualquer",
     *     type="string"
     * )
     */
    public string $atribute2;

    /**
     * @OA\Property(
     *     title="atribute3",
     *     description="atributo3 do DTO",
     *     example="Uma string qualquer",
     *     type="string"
     * )
     */
    public string $atribute3;

    private function __construct(string $atribute1, string $atribute2, string $atribute3)
    {
        $this->atribute1 = $atribute1;
        $this->atribute2 = $atribute2;
        $this->atribute3 = $atribute3;
    }

    public static function createByEntity($entidade): self
    {
        return new self($entidade->atribute1, $entidade->atribute2, $entidade->atribute3);
    }
}
