<?php


namespace App\Application\Actions\School;


use App\Domain\School\Service\SchoolGettter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class SchoolGetAllAction
{

    private $schoolGetter;

    /**
     * SchoolGetAllAction constructor.
     * @param SchoolGettter $schoolGetter
     */
    public function __construct(SchoolGettter $schoolGetter)
    {
        $this->schoolGetter = $schoolGetter;


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
        $result = $this->schoolGetter->getAllSchools();


        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

}