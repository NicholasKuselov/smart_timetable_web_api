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
        $stmt = $this->con->prepare("SELECT idtimetable, Subject, Date, Day, Week, Teacher, Group, Course, Time FROM timetable");
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
        $stmt = $this->con->prepare("SELECT idgroup, name FROM group");
        $stmt->execute();
        $stmt->bind_result($idgroup, $name);

        $groups = array();

        while($stmt->fetch()){
            $group  = array();
            $group['idgroup'] = $idgroup;
            $group['name'] = $name;


            array_push($groups, $group);
        }

        return $groups;
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


            array_push($lessons, $day);
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


}