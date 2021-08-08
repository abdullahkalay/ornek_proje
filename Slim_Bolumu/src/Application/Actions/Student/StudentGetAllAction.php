<?php


namespace App\Application\Actions\Student;


use App\Domain\Student\Service\StudentGetter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class StudentGetAllAction
{
    /**
     * @var StudentGetter
     */
    private $studentGetter;

    /**
     * StudentGetAllAction constructor.
     * @param StudentGetter $studentGetter
     */
    public function __construct(StudentGetter $studentGetter)
    {
        $this->studentGetter = $studentGetter;


    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $result = $this->studentGetter->getAllStudent();


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

}