<?php

namespace App\Controllers;

use App\Entities\Mant;
use DateTime;

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

        if (!$token || !password_verify($submittedPass, $token->hashedPassword) || $token->attempts >= 5) {
            return $this->response->setJSON([
                'isSaved' => false,
                'errors' => [
                    'password' => 'The token is invalid, please try again'
                ]
            ]);
        }

        if ($token->expires_at == null) {
            $token->expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // $this->passModel->disableValidation();

            $this->passModel->update($token->id, $token);
        } else {
            $now = new DateTime();
            $expiresAt = new DateTime($token->expires_at);

            if ($now > $expiresAt) {
                return $this->response->setJSON([
                    'isSaved' => false,
                    'errors' => [
                        'password' => 'The token is invalid, please try again'
                    ]
                ]);
            }
        }

        

        if ($this->model->validate($mants)) {

            $attempts = $token->attempts;

            $msg = "Thanks {$mants['fullName']} for registering to receive alerts when your water filter cartridge needs replacement. You'll receive alerts every 6 months to remind you. Have a great day!";
            
            // $this->twilio->sendMsg($mants['phoneNumber'], $msg);

            $token->attempts = $attempts + 1;

            $this->passModel->update($token->id, $token);

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
