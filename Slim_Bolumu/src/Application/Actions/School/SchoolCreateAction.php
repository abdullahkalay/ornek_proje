<?php


namespace App\Application\Actions\School;


use App\Domain\School\Service\SchoolCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class SchoolCreateAction
{

    private $schoolCreator;

    /**
     * SchoolCreateAction constructor.
     * @param SchoolCreator $schoolCreator
     */
    public function __construct(SchoolCreator $schoolCreator)
    {
        $this->schoolCreator = $schoolCreator;


    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getQueryParams();
        $result = $this->schoolCreator->createSchool($data);


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

}