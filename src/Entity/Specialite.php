<?php
namespace App\Entity;

enum Specialite: string
{
    case FULLSTACK = 'FULLSTACK';
    case BACKEND = 'BACKEND';
    case FRONTEND = 'FRONTEND';
}
