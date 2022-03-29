<?php

namespace Core\Infrastructure\Mappers;

use Illuminate\Database\Eloquent\Model;
use Core\Domain\Entities;

/**
* O objetivo deste padrão de design é mapear os dados vindos de uma fonte de dados para algum tipo de objeto.
* Além disso, é um contém operações que manipulam a persistência dos dados. Como insert, select, etc...
*
* Contudo, também pode ser utilizado somente para o mapeamento de dados.
*
* Nest contexto este padrão é utilizado em conjunto com o padrão de design repositório,
 * para evitar que a lógica de persistência
* de dados vase para outras camadas e para auxiliar na redução do acoplamento com o ORM Eloquent.
*
* Sabe-se que a combinação desses padrões no Laravel gera uma anti-padrão. A decisão de
 * usá-lo ou não fica sob sua responsabilidade.
* Se para seu contexto compensa o trabalho de aplicar este padrão ou combiná-lo a outros, utilize-o.
*
* Referências:
* @see https://martinfowler.com/eaaCatalog/dataMapper.html
**/
class ExampleMapper
{

    public function criarPorEloquent($eloquent): AbstractBaseEntity
    {
    }

    public function criarPorEntidade($entidade): AbstractBaseEntity
    {
    }

    public function createPorArray(array $dados): AbstractBaseEntity
    {
    }
}
