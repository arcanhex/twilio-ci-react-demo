<?php 
namespace App\Controllers;

use App\Entities\Pass;

class Password extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\PasswordModel;
    }
    public function index()
    {
        // 4d98df0a72.9d2da7762c431b709da4
        $pass = $this->request->getJSON(true);


        return $this->response->setStatusCode(403)->setBody('Access Forbidden');
    }

    public function create() {
        helper('password');
        $password = bin2hex(random_bytes(10));
        $lookUpID = bin2hex(random_bytes(5));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $pass = new Pass([
            'hashedPassword' => $hashedPassword,
            'lookUpID' => $lookUpID
        ]);

        if ($this->model->insert($pass)) {
            dd($lookUpID.".".$password);
        }
    }
}