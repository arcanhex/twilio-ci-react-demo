<?php

namespace App\Controllers;

use App\Entities\Mant;

class Message extends BaseController
{
    public function __construct()
    {
        $this->user_model = new \App\Models\UserModel;
        $this->twilio = new \App\Libraries\Twilio;
        $this->mant_model = new \App\Models\MantModel;
        $this->current_user = service('auth')->getCurrentUser();
    }
    public function index()
    {
        $response = service('response');

        $response->setStatusCode(403);
        echo "No tienes permiso para entrar aqui";

    }

    public function mant()
    {
        $mants = $this->mant_model->where('retired', 'no')
            ->findAll();
        foreach ($mants as $mant) {
            $user = $this->user_model->where('id', $mant->user_id)
                ->first();
            $currentDate = date('m-d');
            $futureMant = date('m-d', strtotime(esc($mant->updated_at)) + 15552000);
            $yearLater = date('m-d', strtotime(esc($mant->created_at)) + 31104000);
            echo $futureMant . " " . $yearLater . "<br />";

            $arrPhone = str_split($user->phone);
            $displayPhone = '(' . $arrPhone[0] . $arrPhone[1] . $arrPhone[2] . ') ' . $arrPhone[3] . $arrPhone[4] . $arrPhone[5] . '-' . $arrPhone[6] . $arrPhone[7] . $arrPhone[8] . $arrPhone[9];

            if ($currentDate === $futureMant) {
                $msg = "Buen dia $mant->fullName su producto de Royal Prestige necesita mantenimiento. Por favor contacte a $user->user al $displayPhone para agendar una cita.";
                if ($yearLater == $futureMant) {
                    $userMsg = "$mant->fullName esta de mantenimiento $mant->phoneNumber . Tipo de filtro $mant->filterType. Cambio de cartucho, ya ha pasado un año desde registracion. Cliente sera descartado. Inscribir de nuevo.";
                } else {
                    $userMsg = "$mant->fullName esta de mantenimiento $mant->phoneNumber . Tipo de filtro $mant->filterType.";
                }

                try {
                    $this->twilio->sendMsg($mant->phoneNumber, $msg);
                    $this->twilio->sendMsg($user->phone, $userMsg);
                    echo "Yes";
                    if ($yearLater == $futureMant) {
                        $updateMant = ['isSent' => '1', 'retired' => 'yes'];

                        $prueba = $this->mant_model->update($mant->id, $updateMant);
                    } else {
                        $updateMant = ['isSent' => '1'];

                        $prueba = $this->mant_model->update($mant->id, $updateMant);
                    }


                } catch (\Twilio\Exceptions\RestException $e) {
                    echo $e;
                }
            }
        }
    }
}
