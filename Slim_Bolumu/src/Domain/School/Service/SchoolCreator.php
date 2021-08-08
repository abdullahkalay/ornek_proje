<?php


namespace App\Domain\School\Service;

use App\Domain\School\SchoolRepository;

final class SchoolCreator
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
     * @param array $data
     * @return array
     */
    public function createSchool(array $data):array{
        $validate = $this->validateSchoolData($data);
        if($validate["status"]){
            $result = $this->repository->insertSchool($data["schoolname"]);
            return $result;
        }
        $result = [
            "error" => 1,
            "success"=>0,
            "message" => "Okul eklenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin. ". implode("\n",$validate["errors"])];

        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function validateSchoolData(array $data):array {
        $errors = [];
        $error = false;
        if (!isset($data["schoolname"]) || empty($data["schoolname"])){
            $error = true;
            $errors['schoolname']="Okul adı boş bırakılamaz";
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