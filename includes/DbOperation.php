<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();


    }


    /*
    * The read operation
    * When this method is called it is returning all the existing record of the database
    */
    function getLessons(){
        $stmt = $this->con->prepare("SELECT idtimetable, Subject, Date, Day, Week, Teacher, `Group`, Course, Time FROM timetable");
        $stmt->execute();
        $stmt->bind_result($idtimetable, $Subject, $Date, $Day, $Week, $Teacher, $Group, $Course, $Time);

        $lessons = array();

        while($stmt->fetch()){
            $lesson  = array();
            $lesson['idtimetable'] = $idtimetable;
            $lesson['Subject'] = $Subject;
            $lesson['Date'] = $Date;
            $lesson['Day'] = $Day;
            $lesson['Week'] = $Week;
            $lesson['Teacher'] = $Teacher;
            $lesson['Group'] = $Group;
            $lesson['Course'] = $Course;
            $lesson['Time'] = $Time;

            array_push($lessons, $lesson);
        }

        return $lessons;
    }

    function getSubjects(){
        $stmt = $this->con->prepare("SELECT idsubject, name FROM subject");
        $stmt->execute();
        $stmt->bind_result($idsubject, $name);

        $subjects = array();

        while($stmt->fetch()){
            $subject  = array();
            $subject['idsubject'] = $idsubject;
            $subject['name'] = $name;


            array_push($subjects, $subject);
        }

        return $subjects;
    }

    function getWeeks(){
        $stmt = $this->con->prepare("SELECT idweek, dateFrom, dateTo FROM week");
        $stmt->execute();
        $stmt->bind_result($idweek, $dateFrom, $dateTo);

        $weeks = array();

        while($stmt->fetch()){
            $week  = array();
            $week['idweek'] = $idweek;
            $week['dateFrom'] = $dateFrom;
            $week['dateTo'] = $dateTo;


            array_push($weeks, $week);
        }

        return $weeks;
    }

    function getGroups(){
        $stmt = $this->con->prepare("SELECT idgroup, name FROM `group`");

        if($stmt->execute()) {
            $stmt->bind_result($idgroup, $name);

            $groups = array();

            while ($stmt->fetch()) {
                $currGroup = array();
                $currGroup['idgroup'] = $idgroup;
                $currGroup['name'] = $name;

                array_push($groups, $currGroup);
            }

            return $groups;
        }else{
            return array();
        }
    }

    function getCourse(){
        $stmt = $this->con->prepare("SELECT idcourse, number FROM course");
        $stmt->execute();
        $stmt->bind_result($idcourse, $number);

        $courses = array();

        while($stmt->fetch()){
            $course  = array();
            $course['idcourse'] = $idcourse;
            $course['number'] = $number;


            array_push($courses, $course);
        }

        return $courses;
    }

    function getDays(){
        $stmt = $this->con->prepare("SELECT idDay, name FROM day");
        $stmt->execute();
        $stmt->bind_result($idDay, $name);

        $days = array();

        while($stmt->fetch()){
            $day  = array();
            $day['idDay'] = $idDay;
            $day['name'] = $name;


            array_push($days, $day);
        }

        return $days;
    }

    function getTeachers(){
        $stmt = $this->con->prepare("SELECT idTeacher, name, mail FROM teacher");
        $stmt->execute();
        $stmt->bind_result($idTeacher, $name, $mail);

        $teachers = array();

        while($stmt->fetch()){
            $teacher  = array();
            $teacher['idTeacher'] = $idTeacher;
            $teacher['name'] = $name;
            $teacher['mail'] = $mail;


            array_push($teachers, $teacher);
        }

        return $teachers;
    }
    function GetLessonsByWeekId($weekid){

        $stmt = $this->con->prepare("SELECT idtimetable, Subject, Date, Day, Week, Teacher, `Group`, Course, Time FROM timetable WHERE Week = '$weekid'");
        $stmt->execute();
        $stmt->bind_result($idtimetable, $Subject, $Date, $Day, $Week, $Teacher, $Group, $Course, $Time);

        $lessons = array();
        $stmt->store_result();
        while($stmt->fetch()) {
            $lesson = array();
            $lesson['idtimetable'] = $idtimetable;
            $lesson['Subject'] = $Subject;

            $lesson['Day'] = $Day;
            $lesson['Week'] = $Week;
            $lesson['Teacher'] = $Teacher;
            $lesson['Group'] = $Group;
            $lesson['Course'] = $Course;


            $Sql_Query = "select * from times where idtimes = '$Time'";
            $res = mysqli_fetch_array(mysqli_query($this->con,$Sql_Query));
            $lesson['Time'] = $res['timeFrom']." - ".$res['timeTo'];

            $Sql_Query = "select * from dates where iddates = '$Date'";
            $res = mysqli_fetch_array(mysqli_query($this->con,$Sql_Query));
            $lesson['Date'] = $res['date'];



            array_push($lessons, $lesson);
        }
        return $lessons;
    }

    function SetDefault()
    {


        $Sql_Query = "INSERT INTO `day` (`name`) VALUES ('пнд');
                      INSERT INTO `day` (`name`) VALUES ('втр');
                      INSERT INTO `day` (`name`) VALUES ('срд');
                      INSERT INTO `day` (`name`) VALUES ('чтв');
                      INSERT INTO `day` (`name`) VALUES ('птн');
                      INSERT INTO `day` (`name`) VALUES ('сбт');
                      INSERT INTO `day` (`name`) VALUES ('вск');";

        if(!mysqli_query($this->con,$Sql_Query))
        {
            return "error_with_adding_password";
        }
        return true;
    }


}