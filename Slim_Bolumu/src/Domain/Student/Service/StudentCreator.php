<?php


namespace App\Domain\Student\Service;

use App\Domain\Student\StudentRepository;

final class StudentCreator
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
    public function createStudent(array $data): array
    {
        $validate = $this->validateNewStudent($data);
        if($validate["status"]){

           $result = $this->repository->insertStudent($data);


            return $result;
        }

        $result = [
            "error" => 1,
            "success"=>0,
            "message" => "Öğrenci eklenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin. ". implode("\n",$validate["errors"])];

        return $result;


    }

    /**
     * @param array $data
     * @return array
     */
    private function validateNewStudent(array $data): array
    {
        $errors = [];
        $error = false;
        if (!isset($data["school_id"]) || empty($data["school_id"])){
            $error = true;
            $errors['school_id']="Okul alanı boş bırakılamaz";
        }
        if (!isset($data["school_no"]) || empty($data["school_no"])){
            $error = true;
            $errors['school_no']="Okul numarası alanı boş bırakılamaz";
        }
        if (!isset($data["student_name"]) || empty($data["student_name"])){
            $error = true;
            $errors['student_name']="Öğrenci adı alanı boş bırakılamaz";
        }
        if (!isset($data["student_surname"]) || empty($data["student_surname"])) {
            $error = true;
            $errors['student_surname']="Öğrenci soyadı alanı boş bırakılamaz";
        }

        if (!isset($data["student_tcno"]) || empty($data["student_tcno"])){
            $error = true;
            $errors["student_tcno"]="TC Kimlik no alanı boş olamaz";
        }else {
            $tc= $data["student_tcno"];
            $totalOdd = 0;
            $totalEven= 0;
            if($tc[0]==0) {
                $error = true;
                $errors["student_tc_2"]="Tc Kimlik no geçersizdir.";
            }
            if(!isset($errors["student_tc_2"]) && strlen($tc)!=11){
                $error = true;
                $errors["student_tc_2"]="Tc Kimlik no geçersizdir.";
            }
            if(!isset($errors["student_tc_2"])){

                for($i=0; $i<11;$i++)
                {
                    if($i%2==0) $totalOdd+= $tc[$i]; else $totalEven+= $tc[$i] ;
                }
            }
            if(!isset($errors["student_tc_2"]) && ($totalOdd+$totalEven)%10!=$tc[10]) {
                $error = true;
                $errors["student_tc_2"]="Tc Kimlik no geçersizdir.";
            }
            if( !isset($errors["student_tc_2"]) && (($totalOdd*7)-($totalEven-$tc[9]))%10!=$tc[9]) {
                $error = true;
                $errors["student_tc_2"]="Tc Kimlik no geçersizdir.";
            }
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