<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class Blocker extends Controller
{
    public function index()
    {
        return $this->response->setStatusCode(403)->setBody('Access Forbidden');
    }
}