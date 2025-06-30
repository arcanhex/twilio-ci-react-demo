<?php

namespace App\Controllers;

use App\Entities\Mant;

class Home extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->twilio = new \App\Libraries\Twilio;
        $this->model = new \App\Models\MantModel;
        $this->passModel = new \App\Models\PasswordModel;
    }

    public function list()
    {
        // $mant = $this->model->findAll(); 

        return $this->response->setJSON([
            'msg' => "If you're here that means you did something funny"
        ]);
    }

    public function create()
    {
        $mants = $this->request->getJSON(true);

        // return $this->response->setJSON([
        //     'isSaved' => $mants
        // ]);

        $tokenParts = explode('.', $mants['password'], 2);

        if (count($tokenParts) !== 2) {
            return $this->response->setJSON([
                'isSaved' => false,
                'errors' => [
                    'password' => 'The token is invalid, please try again'
                ]
            ]);
        }
        
        [$lookUpID, $submittedPass] = $tokenParts;
        $token = $this->passModel->where('lookUpID', $lookUpID)
                             ->first();

        if (!password_verify($submittedPass, $token->hashedPassword)) {
            return $this->response->setJSON([
                'isSaved' => false,
                'errors' => [
                    'password' => 'The token is invalid, please try again'
                ]
            ]);
        }

        if ($this->model->validate($mants)) {
            $msg = "Thanks {$mants['fullName']} for registering to receive alerts when your water filter cartridge needs replacement. You'll receive alerts every 6 months to remind you. Have a great day!";
            
            $this->twilio->sendMsg($mants->phoneNumber, $msg);

            return $this->response->setJSON([
                'isSaved' => true, 
                'name' => $mants['fullName']
            ]);
        } else {
            return $this->response->setJSON([
                'isSaved' => false,
                'errors' => $this->model->errors()
            ]);
        }
    }
}
