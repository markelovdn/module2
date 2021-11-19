<?php

namespace src;

use Delight\Auth\Auth;
use Delight\Auth\UnknownIdException;
use Exception;
use League\Plates\Engine;
use PDO;
use src\exceptions\AccountIsBlocked;
use src\exceptions\NotEnoughMoney;
use src\QueryBuilder;
use src\a;


class HomeController {

    private $templates;
    private $auth;
    private $qb;

    public function __construct(QueryBuilder $qb, Engine $engine, Auth $auth)
    {
        $this->qb = $qb;
        //$db = new PDO("mysql:host=localhost;dbname=posts", "root", "");
        $this->auth = $auth;
        $this->templates = $engine;
    }

    public function index (a $a) {


        d($a);

        try {
            $this->auth->admin()->addRoleForUserById(1, \Delight\Auth\Role::ADMIN);
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            die;
            ('Unknown user ID');
        }

        $this->auth->getRoles();
        $post = $this->qb->getAll('post');
        echo $this->templates->render('homepage', ['post' => $post]);
    }

    public function about () {


        try {
            $userId = $this->auth->register('markelovdn@gmail.com', '123', 'markelovdn', function ($selector, $token) {
                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
                echo '  For SMS, consider using a third-party service and a compatible SDK';
            });

            echo 'We have signed up a new user with the ID ' . $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        echo $this->templates->render('about', ['name' => 'Jonathan']);
    }


    public function emailVerify () {
        try {
            $this->auth->confirmEmail('X1yJWRfoX8wZj3qn', 'emIoVSOXeh-P72Mq');

            echo 'Email address has been verified';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function login() {
        try {
            $this->auth->login('markelovdn@gmail.com', '123');

            echo 'User is logged in';
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function logout() {
        //$this->auth->destroySession();

        $this->auth->logOut();

//        try {
//            $this->auth->logOutEverywhereElse();
//        }
//        catch (\Delight\Auth\NotLoggedInException $e) {
//            die('Not logged in1');
//        }

        try {
            $this->auth->logOutEverywhere();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in2');
        }
    }

}