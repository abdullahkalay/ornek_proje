<?php


namespace App\Domain\Student\Service;

use App\Domain\Student\StudentRepository;

final class StudentGetter
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
     * @return array
     */
    public function getAllStudent() : array{
        return $this->repository->getStudents();
    }
    /**
     * @return array
     */
    public function getStudent(array $data) : array{
        $validate = $this->validatePagingData($data);
        if($validate["status"]){
            $data = $data["student_id"];
            $result = $this->repository->getStudent($data);
            return $result;
        }
        $result = [
            "error" => 1,
            "success"=>0,
            "message" => "Öğrenci bilgileri getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin. ". implode("\n",$validate["errors"])];

        return $result;

    }

    /**
     * @return array
     */
    public function getNonDeletedStudents() : array{
        return $this->repository->getNonDeletedStudents();
    }

    /**
     * @return array
     */
    public function getNonDeletedStudentCount() : array{
        return $this->repository->getNonDeletedStudentCount();
    }

    /**
     * @param array $data
     * @return array
     */
    public function getNonDeletedStudentWithPaging(array $data):array{
        $validate = $this->validatePagingData($data);
        if($validate["status"]){
            $data = [
                $data["pageNumber"],
                $data["pageItemCount"]
            ];
            $result = $this->repository->getNonDeletedStudentsWithPaging($data);
            return $result;
        }
        $result = [
            "error" => 1,
            "success"=>0,
            "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin. ". implode("\n",$validate["errors"])];

        return $result;

    }

    /**
     * @param array $data
     * @return array
     */
    public function validatePagingData(array $data) :array {
        $errors = [];
        $error = false;
        if (!isset($data["pageNumber"]) || empty($data["pageNumber"])){
            $error = true;
            $errors['pageNumber']="Sayfa numarası boş olamaz";
        }
        if (!isset($data["pageItemCount"]) || empty($data["pageItemCount"])){
            $error = true;
            $errors['pageItemCount']="Sayfa başına düşen öğrenci sayısı boş olamaz";
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


    /**
     * @param array $data
     * @return array
     */
    public function validateStudentId(array $data) :array {
        $errors = [];
        $error = false;
        if (!isset($data["student_id"]) || empty($data["student_id"])){
            $error = true;
            $errors['student_id']="Öğrenci ID boş olamaz";
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