<?php
// Lab - 02
// PHP OOP tasks
// Full Name: M. Mahdi Karimi
// Student ID: R24002210


// Task 1
class Library {
    const MAX_BOOKS = 3;
}

echo "Maximum books allowed: " . Library::MAX_BOOKS . "<br><br>";

// Task 2
class StudentCounter {
    public static $count = 0;

    public static function addStudent() {
        self::$count++;
    }
}

StudentCounter::addStudent();
StudentCounter::addStudent();
StudentCounter::addStudent();

echo "Total students: " . StudentCounter::$count . "<br><br>";

// Task 3
abstract class Vehicle {
    abstract public function start();
}

class Car extends Vehicle {
    public function start() {
        echo "Car engine started.<br>";
    }
}

class Bike extends Vehicle {
    public function start() {
        echo "Bike started.<br>";
    }
}

$car = new Car();
$bike = new Bike();

$car->start();
$bike->start();
?>
