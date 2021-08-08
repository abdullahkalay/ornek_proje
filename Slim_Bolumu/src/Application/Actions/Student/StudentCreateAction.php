<?php


namespace App\Application\Actions\Student;


use App\Domain\Student\Service\StudentCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class StudentCreateAction
{

    private $studentCreator;

    public function __construct(StudentCreator $studentCreator)
    {
        $this->studentCreator = $studentCreator;


    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getQueryParams();
        $result = $this->studentCreator->createStudent($data);


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

}