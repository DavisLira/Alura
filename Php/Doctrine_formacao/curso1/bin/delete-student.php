<?php

use Alura\Doctrine\Entity\Student;
use Alura\Doctrine\Helper\EntityManagerCreator;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$student = $entityManager->getReference(Student::class, $argv[1]);

$entityManager->remove($student);
$entityManager->flush();