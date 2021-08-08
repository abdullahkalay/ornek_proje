<?php


namespace App\Application\Actions\Student;


use App\Domain\Student\Service\StudentUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class StudentUpdateAction
{

    private $studentUpdater;

    public function __construct(StudentUpdater $studentUpdater)
    {
        $this->studentUpdater = $studentUpdater;


    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getQueryParams();
        $result = $this->studentUpdater->updateStudent($data);


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

}