<?php

declare(strict_types=1);

namespace App;

abstract class Model 
{
    private DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }
}