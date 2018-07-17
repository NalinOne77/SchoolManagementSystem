<?php
    include 'lib/Session.php';
    Session::init();
    include 'lib/Database.php';
    include 'helpers/Format.php';

    spl_autoload_register(function($class){
       include_once "classes/".$class.".php";
    });

    $db = new Database();
    $fm = new Format();
    $user = new User();
    $school = new School();
    $role = new Role();
    $subject = new Subject();
    $notification = new Notification();
    $page = new Pagination();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CloudSchool</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/slick.css">
</head>
<body>
