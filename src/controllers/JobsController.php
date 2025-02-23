<?php

namespace controllers;

use models\NewsModel;
use models\UserModel;

class JobsController
{
    public function index() {
        die("salam");
    }

    public function fetchNews()
    {
       global $conn;

       $newsModel = new NewsModel($conn);
       $newsModel->fetchNews();
    }

    public function checkTokens() {
        global $conn;
        $userModel = new UserModel($conn);

        $userModel->nobTokenCecker();
    }
}