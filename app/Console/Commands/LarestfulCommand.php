<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LarestfulCommand extends Command
{
    private const CHOICE_FILE_QUESTION = 'Qual tipo arquivo deseja criar?';
    private const CHOICE_FILE_ASK = 'Qual nome deseja dar para o arquivo?';
    private const CHOICE_LAYER_QUESTION = 'A qual camada este arquivo pertence?';

    private const FILE_CREATED_MSG = 'Arquivo criado com sucesso!';
    private const FILE_EXISTS_MSG = 'O arquivo informado já existe em ';

    private $stubFilesPath;
    private $generatedFilePath;
    private $complementaryComponent;

    /**
     * Nome e assinatura do comando.
     *
     * @var string
     */
    protected $name = 'make:file';

    /**
     * A assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'make:file';

    /**
     * Descrição do comando.
     *
     * @var string
     */
    protected $description = 'Este comando serve para gerar componentes específicos
    utilizados na abordagem Domain Driven Design';

    protected $type = 'Generic';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->generatedFilePath = 'core/';
        $this->stubFilesPath = 'resources/stubs/';
        $this->complementaryComponent = [];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $chosenLayer = $this->choice(self::CHOICE_LAYER_QUESTION, getLayersListSuggestion());

        switch ($chosenLayer) {
            case 'Application':
                $chosenFileSuffix = $this->choice(
                    self::CHOICE_FILE_QUESTION,
                    getFileListSuggestion('Application')
                );
                $this->choiceApplicationLayerComponent($chosenFileSuffix);
                break;
            case 'Domain':
                $chosenFileSuffix = $this->choice(
                    self::CHOICE_FILE_QUESTION,
                    getFileListSuggestion('Domain')
                );
                $this->createDomainLayerComponent($chosenFileSuffix);
                break;
            case 'Infrastructure':
                $chosenFileSuffix = $this->choice(
                    self::CHOICE_FILE_QUESTION,
                    getFileListSuggestion('Infrastructure')
                );
                $this->createInfrastructureLayerComponent($chosenFileSuffix);
                break;
        }
    }

    private function choiceApplicationLayerComponent($chosenFileSuffix)
    {
        $chosenFilename = $this->ask(self::CHOICE_FILE_ASK);
        $this->generatedFilePath .= 'Application/';
        $this->complementaryComponent = [
            'serviceInterface' => [
                'suffix' => 'ServiceInterface',
                'folder' => 'core/Application/Services/Contracts',
                'stub' => $this->stubFilesPath . 'application.service.interface',
            ],
            'service' => [
                'suffix' => 'Service',
                'folder' => 'core/Application/Services',
                'stub' => $this->stubFilesPath . 'application.service',
            ],
        ];

        switch ($chosenFileSuffix) {
            case 'ApiController':
                $this->generatedFilePath .= 'Application/Controllers/V1';
                $this->stubFilesPath .= 'controller.api';
                $chosenFileSuffix = 'Controller';
                break;
            case 'Interface':
                $this->generatedFilePath .= 'Contracts';
                $this->stubFilesPath .= 'application.generic.interface';
                break;
            case 'Command':
                $this->generatedFilePath .= 'Commands';
                $this->stubFilesPath .= 'command.handler';
                break;
            case 'ServiceInterface':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['service']['suffix'],
                    $this->complementaryComponent['service']['folder'],
                    $this->complementaryComponent['service']['stub']
                );
                $this->generatedFilePath .= 'Services/Contracts';
                $this->stubFilesPath .= 'application.service.interface';
                break;
            case 'Service':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['serviceInterface']['suffix'],
                    $this->complementaryComponent['serviceInterface']['folder'],
                    $this->complementaryComponent['serviceInterface']['stub']
                );
                $this->generatedFilePath .= 'Services';
                $this->stubFilesPath .= 'application.service';
                break;
            case 'DTO':
                $this->generatedFilePath .= 'DTOs';
                $this->stubFilesPath .= 'dto';
                break;
            case 'IntegrationDTO':
                $this->generatedFilePath .= 'DTOs/Integration';
                $this->stubFilesPath .= 'integration.dto';
                break;
            case 'RequestDTO':
                $this->generatedFilePath .= 'DTOs/Request';
                $this->stubFilesPath .= 'request.dto';
                break;
            case 'ResponseDTO':
                $this->generatedFilePath .= 'DTOs/Response';
                $this->stubFilesPath .= 'response.dto';
                break;
        }

        $this->createFileComponent($chosenFilename, $chosenFileSuffix, $this->generatedFilePath, $this->stubFilesPath);
    }

    private function createDomainLayerComponent($chosenFileSuffix)
    {
        $chosenFilename = $this->ask(self::CHOICE_FILE_ASK);
        $this->generatedFilePath .= 'Domain/';
        $this->complementaryComponent = [
            'httpClient' => [
                'suffix' => 'HttpClient',
                'folder' => 'core/Infrastructure/HttpClients',
                'stub' => $this->stubFilesPath . 'httpclient.implementation',
            ],
            'repository' => [
                'suffix' => 'Repository',
                'folder' => 'core/Infrastructure/Repositories',
                'stub' => $this->stubFilesPath . 'repository.implementation',
            ],
            'service' => [
                'suffix' => 'Service',
                'folder' => 'core/Domain/Services',
                'stub' => $this->stubFilesPath . 'domain.service',
            ],
        ];

        switch ($chosenFileSuffix) {
            case 'Interface':
                $this->generatedFilePath .= 'Contracts';
                $this->stubFilesPath .= 'domain.generic.interface';
                break;
            case 'Enum':
                $this->generatedFilePath .= 'Enums';
                $this->stubFilesPath .= 'enum';
                break;
            case 'Exception':
                $this->generatedFilePath .= 'Exceptions';
                $this->stubFilesPath .= 'exception';
                break;
            case 'HttpClientInterface':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['httpClient']['suffix'],
                    $this->complementaryComponent['httpClient']['folder'],
                    $this->complementaryComponent['httpClient']['stub']
                );
                $this->generatedFilePath .= 'HttpClients';
                $this->stubFilesPath .= 'httpclient.interface';
                break;
            case 'Entity':
                $this->generatedFilePath .= 'Entities';
                $this->stubFilesPath .= 'domain.entity';
                break;
            case 'Event':
                $this->generatedFilePath .= 'Events';
                $this->stubFilesPath .= 'domain.event';
                break;
            case 'RepositoryInterface':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['repository']['suffix'],
                    $this->complementaryComponent['repository']['folder'],
                    $this->complementaryComponent['repository']['stub']
                );
                $this->generatedFilePath .= 'Repositories';
                $this->stubFilesPath .= 'repository.interface';
                break;
            case 'ServiceInterface':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['service']['suffix'],
                    $this->complementaryComponent['service']['folder'],
                    $this->complementaryComponent['service']['stub']
                );
                $this->generatedFilePath .= 'Services/Contracts';
                $this->stubFilesPath .= 'domain.service.interface';
                break;
            case 'Service':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['service']['suffix'],
                    $this->complementaryComponent['service']['folder'],
                    $this->complementaryComponent['service']['stub']
                );
                $this->generatedFilePath .= 'Services';
                $this->stubFilesPath .= 'domain.service';
                break;
            case 'Specification':
                $this->generatedFilePath .= 'Specifications';
                $this->stubFilesPath .= 'specification';
                break;
            case 'SpecificationInterface':
                $this->generatedFilePath .= 'Specifications/Contracts';
                $this->stubFilesPath .= 'specification.interface';
                break;
            case 'SpecificationRule':
                $this->generatedFilePath .= 'Specifications/Conditionals';
                $this->stubFilesPath .= 'specification.rule';
                break;
            case 'ValueObject':
                $this->generatedFilePath .= 'ValueObjects';
                $this->stubFilesPath .= 'value.object';
                break;
        }

        $this->createFileComponent($chosenFilename, $chosenFileSuffix, $this->generatedFilePath, $this->stubFilesPath);
    }

    private function createInfrastructureLayerComponent($chosenFileSuffix)
    {
        $chosenFilename = $this->ask(self::CHOICE_FILE_ASK);

        $this->generatedFilePath .= 'Infrastructure/';
        $this->complementaryComponent = [
            'httpClientInterface' => [
                'suffix' => 'HttpClientInterface',
                'folder' => 'core/Domain/HttpClients',
                'stub' => $this->stubFilesPath . 'httpclient.interface',
            ],
            'repositoryInterface' => [
                'suffix' => 'RepositoryInterface',
                'folder' => 'core/Domain/Repositories',
                'stub' => $this->stubFilesPath . 'repository.interface',
            ],
        ];

        switch ($chosenFileSuffix) {
            case 'Eloquent':
                $this->generatedFilePath .= 'Eloquent';
                $this->stubFilesPath .= 'eloquent.implementation';
                break;
            case 'Helper':
                $this->generatedFilePath .= 'Helpers';
                $this->stubFilesPath .= 'helper.implementation';
                break;
            case 'HttpClient':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['httpClientInterface']['suffix'],
                    $this->complementaryComponent['httpClientInterface']['folder'],
                    $this->complementaryComponent['httpClientInterface']['stub']
                );
                $this->generatedFilePath .= 'HttpClients';
                $this->stubFilesPath .= 'httpclient.implementation';
                break;
            case 'Mapper':
                $this->generatedFilePath .= 'Mappers';
                $this->stubFilesPath .= 'mapper.implementation';
                break;
            case 'Repository':
                $this->createFileComponent(
                    $chosenFilename,
                    $this->complementaryComponent['repositoryInterface']['suffix'],
                    $this->complementaryComponent['repositoryInterface']['folder'],
                    $this->complementaryComponent['repositoryInterface']['stub']
                );
                $this->generatedFilePath .= 'Repositories';
                $this->stubFilesPath .= 'repository.implementation';
                break;
        }

        $this->createFileComponent($chosenFilename, $chosenFileSuffix, $this->generatedFilePath, $this->stubFilesPath);
    }

    private function createFileComponent($chosenFilename, $chosenFileSuffix, $generatedFilePath, $stubFileFullPath)
    {
        $fileFullPath = $generatedFilePath . '/' . ucfirst($chosenFilename . $chosenFileSuffix) . '.php';
        $stubFileContent = '';

        if (!file_exists($generatedFilePath)) {
            mkdir($generatedFilePath, 0775, true);
        }

        if (!file_exists($fileFullPath)) {
            $stubFileContent = file_get_contents($stubFileFullPath . '.stub');
            $stubFileContent = str_replace('{{name}}', $chosenFilename, $stubFileContent);

            file_put_contents($fileFullPath, $stubFileContent);

            $this->info(self::FILE_CREATED_MSG);
        } else {
            $this->error(self::FILE_EXISTS_MSG . $fileFullPath);
        }
    }
}
