<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shop\Adapters\FakeProductsRepository\Repository;
use Shop\Adapters\SlimAPI\CreateProduct;
use Shop\Adapters\SlimAPI\CreateProduct\InvalidNameException;
use Shop\Domain\Ports\AddProductService;
use Slim\Factory\AppFactory;


require __DIR__ . '/../../../vendor/autoload.php';

$app = AppFactory::create();

$app->post('/products/', function (Request $request, Response $response, array $args) {
    try {
        $domainRequest = new CreateProduct\Request($request->getParsedBody());
    } catch (InvalidNameException $exception) {
        $response->getBody()->write(json_encode(['price' => ['Invalid price']]));
        return $response->withStatus(400)
            ->withHeader('Content-Type', 'application/json');
    } catch (InvalidNameException $exception) {
        $response->getBody()->write(json_encode(['name' => ['Invalid name']]));
        return $response->withStatus(400)
            ->withHeader('Content-Type', 'application/json');
    }
    $domainResponse = new CreateProduct\Response();
    $domainService = new AddProductService(new Repository());

    try{
        $domainService->addProduct($domainRequest, $domainResponse);
    } catch (\Shop\Domain\Model\Product\CreateException $e){
        /**
         * @todo: Log exception.
         */
        $response->getBody()->write(json_encode("Creating product error"));
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'application/json');
    }

    $response->getBody()->write(json_encode($domainResponse->toArray()));
    $response = $response->withHeader('Content-type', 'application/json')->withStatus(201);

    return $response;
});

$app->run();