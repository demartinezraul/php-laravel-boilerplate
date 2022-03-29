<?php

namespace Core\Application\DTOs\Response;

use Core\Domain\Contracts\ArrayableInterface;

/**
 * @OA\Schema(
 *      title="HttpResponseDTO",
 *      description="Representa a resposta a uma solicitação",
 *      type="object",
 *      required={"status", "message"}
 * )
 */
class HttpResponseDTO implements ArrayableInterface
{

    /**
     * @OA\Property(
     *     title="status",
     *     description="Status da Reposta",
     *     example="200",
     *     type="integer"
     * )
     */
    public int $status;

    /**
     * @OA\Property(
     *     title="messages",
     *     description="Mensagem de sucesso ou falha associada a ação aplicada ao recurso",
     *     example="Operação realizada com sucesso ou ocorreu um erro",
     *     type="mixed"
     * )
     */
    public $messages;

    /**
     * @OA\Property(
     *     title="data",
     *     description="Dados do Retornados",
     *     example="Objeto, array, string ou números ",
     *     type="mixed"
     * )
     */
    public $data;

    public function __construct(int $status, $messages, $data = null)
    {
        $this->status = $status;
        $this->messages = $messages;
        $this->data = $data;
    }

    public function toArray(array $merge = []): array
    {
        return [
            'status' => $this->status,
            'message' => $this->messages,
            'data' => $this->data,
        ];
    }
}
