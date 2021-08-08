<?php


namespace App\Domain\School;
use PDO;

final class SchoolRepository
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * SchoolRepository constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $school_name
     * @return array
     */
    public function insertSchool(string $school_name):array {
        $addschool = $this->connection->prepare("CALL AddSchool(?)");
        try {
            if($addschool->execute(array($school_name))){
                $result = [
                    "error" => 0,
                    "success"=>1,
                    "message" => "Okul başarıyla eklendi."
                ];
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Okul eklenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }

        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Okul eklenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getAllSchools():array{
        $getSchools = $this->connection->prepare('CALL GetSchools()');
        try {
            if($getSchools->execute(array())){
                $result = $getSchools->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Okullar getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Okullar getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;

    }

    /**
     * @return array
     */
    public function getAllActiveSchools():array{
        $getSchools = $this->connection->prepare('CALL GetActiveSchools()');
        try {
            if($getSchools->execute(array())){
                $result = $getSchools->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Okullar getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Okullar getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;

    }

}