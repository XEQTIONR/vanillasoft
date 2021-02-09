<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendEmailJob;
class SendEmailsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSendingEmailsEndpoint()
    {


        Queue::fake();

        Queue::assertNothingPushed();


        $data = [
            "emails" => [
                [
                    "to" => "someone@gmail.com",
                    "subject" => "Some subject",
                    "body" => "<h1> This is the heading/body of the email </h1>",
                    "attachments" => [
                        [
                            "name" => "name.jpg",
                            "value" => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAk8AAAJPCAIAAADqp'
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->post('/api/send?api_key=12334ASDB', $data);

        $response->assertStatus(201);

        Queue::assertPushed(SendEmailJob::class);

        $multiple_attachments = [
            [
                "name" => "name2.jpg",
                "value" => 'test_text'
            ],
            [
                "name" => "name3.jpg",
                "value" => 'test_text'
            ],
            [
                "name" => "name4.jpg",
                "value" => 'test_text'
            ]
        ];

        $data['emails']['attachments'] = $multiple_attachments;

        $response = $this->post('/api/send?api_key=12334ASDB', $data, ['Accept' => 'application/json']);

        $response->assertStatus(201);

        Queue::assertPushed(SendEmailJob::class, 3);
    }

    public function testNotSentWithValidationErrors()
    {
        Queue::fake();

        Queue::assertNothingPushed();


        $data = [
            "emails" => [
                [
                    "to" => "someone@gmail.com",
                    "subject" => "Some subject",
                    "body" => "<h1> This is the heading/body of the email </h1>",
                    "attachments" => [
                        [
                            "name" => "name.jpg",
                            "value" => "data:img"
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->post('/api/send', $data, ['Accept' => 'application/json']);

        $response->assertStatus(422);

        $response = $this->post('/api/send?api_key=12334ASDB', [], ['Accept' => 'application/json']);

        $response->assertStatus(422);

        Queue::assertNothingPushed();
    }
}
