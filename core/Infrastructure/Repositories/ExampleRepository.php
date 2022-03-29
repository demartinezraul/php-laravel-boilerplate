<?php

namespace Core\Infrastructure\Repositories;

use Core\Domain\Repositories\ExampleRepositoryInterface;

/**
* Este padrão é uma abstração da camada de dados e tem como um de seus objetivos centralizar o uso
 * dos objetos de domínio e permitir o acesso a dados.
*
* Entre os outros objetivos estão a separação da lógica de acesso a dados da regra de negócio,
 * centralizar uma estratégia de armazenamento (Cache, banco, arquivo),
* permitir a troca do ORM ou fornecedor de banco de dados sem afetar o funcionamento da aplicação, entre outros.
*
* No contexto de aplicações Laravel é dificil implementar este padrão de design de forma purista.
 * Pois ele se confronta diretamente com o padrão Active Record aplicado
* ao ORM Eloquent e a necessidade de evitar que o eloquent vase para a camada de domínio.
*
* O que motiva a aplicação desse padrão neste projeto é a tentativa de reduzir o acoplamento dos modelos
 * de domínio com o ORM Eloquent e o vazamento da camada de acesso
* a dados para outras camadas, além disso, remover a violação do principio da responsabilidade única que
 * ocorre no modelo. Que além de conter acesso direto ao mecanismo
* de persistência é também o centralizador de regras de negócio e relacionamento entre entidades. Sabe-se
 * que no laravel este padrão pode ser confundido com uma fachada,
* já que o repositório emula os comportamentos do eloquente.
*
* Observação: Este padrão de design não é aplicado de forma purista neste projeto. Neste contexto o
 * objetivo não é resolver todos os problemas que o padrão se propõe.
*
* Este padrão deve ser implementado aqui da seguinte forma:
* - Defina a interface para o repositório na camada de domínio e e sua assinaturas
* - Crie a classe que implementará essa interface
* - Herde o repositório abstrado base para obter os métodos comuns a todos os repositórios
* - Crie a classe AlgumaCoisaEloquentModel e invoque a por injeção de dependência no construtor do seu repositório
*
* Referências:
* @see https://martinfowler.com/eaaCatalog/repository.html
* @see https://docs.microsoft.com/en-us/previous-versions/msp-n-p/ff649690(v=pandp.10)?redirectedfrom=MSDN
**/
class ExampleRepository extends AbstractBaseRepository implements ExampleRepositoryInterface
{

    public function __construct($eloquentModel)
    {
        parent::__construct($eloquentModel);
    }
}
