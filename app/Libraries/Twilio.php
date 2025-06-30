<?php
namespace App\Libraries;

require '../vendor/autoload.php';
use Twilio\Rest\Client;

/**
 *
 */
class Twilio
{

  public function sendMsg($phoneNumber, $msg)
  {
    // Your Account SID and Auth Token from twilio.com/console
    $account_sid = $_ENV["ACCOUNT_SID"];
    $auth_token = $_ENV["AUTH_TOKEN"];
    // In production, these should be environment variables. E.g.:
    // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

    // A Twilio number you own with SMS capabilities
    $twilio_number = "+16083364380";

    $client = new Client($account_sid, $auth_token);
    try {
      $client->messages->create(
          // Where to send a text message (your cell phone?)
          $phoneNumber,
          array(
              'from' => $twilio_number,
              'body' => $msg
          )
      );
    } catch (\Twilio\Exceptions\RestException $e) {
      
    }
  }
}
