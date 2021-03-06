<?php

namespace Core\Application\DTOs;

/**
 * @OA\Schema(
 *      title="ExampleDTO",
 *      description="Representa um objeto que serve apenas para transferir dados e impedir que as
 *      informações do modelo de domínio fiquem expostas a aplicações clientes externas",
 *      type="object",
 *      required={"atributo1", "atributo2"}
 * )
 */
class ExampleDTO
{

    /**
     * @OA\Property(
     *     title="atributo1",
     *     description="atributo1 do DTO",
     *     example=Uma string qualquer",
     *     type="string"
     * )
     */
    public string $atributo1;

    /**
     * @OA\Property(
     *     title="atributo2",
     *     description="atributo2 do DTO",
     *     example=Uma string qualquer",
     *     type="string"
     * )
     */
    public string $atributo2;

    /**
     * @OA\Property(
     *     title="atributo3",
     *     description="atributo3 do DTO",
     *     example="Uma string qualquer",
     *     type="string"
     * )
     */
    public string $atributo3;

    private function __construct(string $atributo1, string $atributo2, string $atributo3)
    {
        $this->atributo1 = $atributo1;
        $this->atributo2 = $atributo2;
        $this->atributo3 = $atributo3;
    }

    public static function createByEntity($entidade): self
    {
        return new self($entidade->atributo, $entidade->atributo2, $entidade->atributo3);
    }
}
