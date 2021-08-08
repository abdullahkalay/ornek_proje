<?php


namespace App\Domain\Student\Service;

use App\Domain\Student\StudentRepository;

final class StudentDeleter
{
    /**
     * @var StudentRepository
     */
    private $repository;

    /**
     * StudentCreator constructor.
     * @param StudentRepository $repository
     */
    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function deleteStudent(array $data): array
    {
        $validate = $this->validateStudentId($data);
        if($validate["status"]){

           $result = $this->repository->deleteStudent((int)$data["student_id"]);


            return $result;
        }

        $result = [
            "error" => 1,
            "success"=>0,
            "message" => "Öğrenci silinirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin. ". implode("\n",$validate["errors"])];

        return $result;


    }

    /**
     * @param array $data
     * @return array
     */
    private function validateStudentId(array $data): array
    {
        $errors = [];
        $error = false;
        if (!isset($data["student_id"]) || empty($data["student_id"])){
            $error = true;
            $errors['student_id']="Öğrenci id si boş bırakılamaz";
        }

        if ($error) {
            return  [
                "status"=>false,
                "errors"=>$errors,
            ];
        }
        return [
            "status" => true,
            "errors"=>null
        ];
    }
}