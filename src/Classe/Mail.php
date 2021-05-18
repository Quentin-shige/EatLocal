<?php
namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail{
    private $api_key = "463bc8e5bbc6f6dd09e5f121caa9ab94";
    private $api_key_secret ="2478c26fc5c7e4caa719de22de9f9226";

    public function send($to_email, $to_name, $subject, $content){
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "quentin50430@hotmail.fr",
                'Name' => "Eat Local"
            ],
            'To' => [
                [
                    'Email' => $to_email,
                    'Name' => $to_name
                ]
            ],
            'TemplateID' => 2889685,
            'TemplateLanguage' => true,
            'Subject' => $subject,
            'Variables' => [
                "content"=>$content,
            ]
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success() && dd($response->getData());
    }
}
