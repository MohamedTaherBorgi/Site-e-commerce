<?php

namespace App\Class;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private string $api_key = 'f61f3fb9c5a59276f2a09ef620c94249';
    private string $api_key_secret = 'a73efe1157ddf39c34c596a65335bba5';

    public function send($to_email, $to_name, $subject, $content): void
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "medtaherborgi@gmail.com",
                        'Name' => "Ecosanté"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5751049,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];

        // Uncomment this section to actually send the email
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()) {
            // Email sent successfully
            $responseData = $response->getData();
            // Handle success if needed
        } else {
            // Email sending failed
            $errorData = $response->getData();
            // Handle error if needed
        }
    }
}