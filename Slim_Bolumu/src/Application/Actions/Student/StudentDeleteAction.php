<?php


namespace App\Application\Actions\Student;


use App\Domain\Student\Service\StudentDeleter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class StudentDeleteAction
{

    private $studentDeleter;

    public function __construct(StudentDeleter $studentDeleter)
    {
        $this->studentDeleter = $studentDeleter;


    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getQueryParams();
        $result = $this->studentDeleter->deleteStudent($data);


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

}