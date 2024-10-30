<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get('/api/v1/notebook/');
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $response = $this->post('/api/v1/notebook/', [
            'full_name' => 'Ольга Викторовна',
            'company' => 'Tech Solutions',
            'phone' => '+79876543210',
            'email' => 'exampleemail@gmail.com',
            'birth_date' => '1985-06-15',
            'photo_path' => '',
        ]);
        $response->assertStatus(201);
    }
}
