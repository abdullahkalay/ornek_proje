<?php


namespace App\Domain\Student;
use PDO;


final class StudentRepository
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * StudentRepository constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $student
     * @return array
     */
    public function insertStudent(array $student): array
    {
        $data = [
            $student["school_id"],
            $student["school_no"],
            $student["student_name"],
            $student["student_surname"],
            $student["student_tcno"]
        ];


        $addStudent = $this->connection->prepare('CALL AddStudent(?,?,?,?,?)');
        try {
            if($addStudent->execute($data)){
                $resultdata = $addStudent->fetchAll(PDO::FETCH_ASSOC);
                $result = [
                    "error" => $resultdata[0]["errorstatus"],
                    "success" =>$resultdata[0]["successstatus"],
                    "message" => $resultdata[0]["message"],
                ];

            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenci eklenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenci eklenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getStudents() : array {
       $getStudents = $this->connection->prepare('CALL GetAllStudents()');
        try {
            if($getStudents->execute(array())){
                $result = $getStudents->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;
    }
    /**
     * @return array
     */
    public function getStudent($id) : array {
       $getStudent = $this->connection->prepare('CALL GetStudent(?)');
        try {
            if($getStudent->execute(array($id))){
                $result = $getStudent->fetchAll(PDO::FETCH_ASSOC);
                $result = $result[0];
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenci bilgileri getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenci bilgileri getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getNonDeletedStudents(): array {
        $getStudents = $this->connection->prepare('CALL GetNonDeletedStudents()');
        try {
            if($getStudents->execute(array())){
                $result = $getStudents->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getNonDeletedStudentCount(): array {
        $getStudentCount = $this->connection->prepare("CALL GetNonDeletedStudentCount()");
        try {
            if($getStudentCount->execute(array())){
                $data = $getStudentCount->fetchAll(PDO::FETCH_ASSOC);
                $result= [
                    "error" => 0,
                    "success"=>1,
                    "message" => "Öğrenci sayısı başarıyla getirildi",
                    "student_count" => $data[0]["TotalStudentCount"],
                ];
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenci sayısı getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenci sayısı getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getNonDeletedStudentsWithPaging(array $data):array {
        $getStudents = $this->connection->prepare('CALL GetNonDeletedStudentsWithPaging(?,?)');
        try {
            if($getStudents->execute($data)){
                $result = $getStudents->fetchAll(PDO::FETCH_ASSOC);
            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenciler getirilirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }
        return $result;
    }

    /**
     * @param int $student_id
     * @return array
     */
    public function deleteStudent(int $student_id):array {

        $deleteStudent = $this->connection->prepare('CALL DeleteStudent(?)');
        try {
            if($deleteStudent->execute(array($student_id))){

                $result = [
                    "error" => 0,
                    "success"=>1,
                    "message" => "Öğrenci başarıyla silindi."
                ];

            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenci silinirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenci silinirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }

        return $result;
    }

    /**
     * @param array $student
     * @return array
     */
    public function updateStudent(array $student):array {

        $updateStudent = $this->connection->prepare('CALL UpdateStudent(?,?,?,?,?,?)');
        try {
            if($updateStudent->execute($student)){
                $resultdata = $updateStudent->fetchAll(PDO::FETCH_ASSOC);
                $result = [
                    "error" => $resultdata[0]["errorstatus"],
                    "success" =>$resultdata[0]["successstatus"],
                    "message" => $resultdata[0]["message"],
                ];

            }else {
                $result = [
                    "error" => 1,
                    "success"=>0,
                    "message" => "Öğrenci bilgileri güncellenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
                ];
            }
        }catch (\PDOException $e){
            $result = [
                "error" => 1,
                "success"=>0,
                "message" => "Öğrenci bilgileri güncellenirken bir hatayla karşılaşıldı. Daha sonra tekrar deneyin."
            ];
        }

        return $result;
    }



}