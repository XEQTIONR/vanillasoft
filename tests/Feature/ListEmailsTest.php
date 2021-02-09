<?php

namespace Tests\Feature;

use App\Models\Attachment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Email;
use Tests\TestCase;

class ListEmailsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testListEmails()
    {
        Email::factory()
            ->has(Attachment::factory()->count(3))
            ->create();

        $this->assertCount(1, Email::all());

        $this->assertCount(3, Attachment::all());

        $response = $this->get('/api/list?api_key=1234545', ['Accept' => 'application/json']);

        $response->assertJsonCount(1);

        $content = $response->decodeResponseJson();

        $this->assertEquals(count($content[0]['attachments']), 3);

        Email::factory()
            ->has(Attachment::factory()->count(1))
            ->count(5)
            ->create();

        $this->assertCount(6, Email::all());

        $this->assertCount(8, Attachment::all());

        $response = $this->get('/api/list?api_key=1234545', ['Accept' => 'application/json']);

        $response->assertJsonCount(6);

        $content = $response->decodeResponseJson();

        $this->assertEquals(count($content[1]['attachments']), 1);
    }
}
