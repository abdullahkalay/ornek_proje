<?php


namespace App\Domain\School\Service;

use App\Domain\School\SchoolRepository;

final class SchoolGettter
{
    /**
     * @var SchoolRepository
     */
    private $repository;

    /**
     * SchoolCreator constructor.
     * @param SchoolRepository $repository
     */
    public function __construct(SchoolRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getAllSchools():array{
        return $this->repository->getAllSchools();
    }

    public function getAllActiveSchools():array{
        return $this->repository->getAllActiveSchools();
    }

}