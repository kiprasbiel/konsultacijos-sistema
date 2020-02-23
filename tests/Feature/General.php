<?php

namespace Tests\Feature;

use App\Consultation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class General extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin() {
        $this->actingAs(factory(User::class)->create());
    }

    protected function setUp(): void {
        parent::setUp();


    }

    public function testLoginPageForLoggedOutUsers() {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testLoggedOutCantAccessSite() {
        $response = $this->get('/')->assertRedirect('/login');
    }

    public function test_loggedIn_users_can_see_consultation_list() {

        $this->actingAsAdmin();
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_consultation_can_be_added_through_form() {
        $this->actingAsAdmin();

        $response = $this->post('/konsultacijos', $this->data());

        $this->assertCount(1, Consultation::all());
    }

    public function test_contacts_are_required(){
        $this->actingAsAdmin();

        $response = $this->post('/konsultacijos', array_merge($this->data(), ['contacts' => '']));

        $response->assertSessionHasErrors('contacts');

        $this->assertCount(0, Consultation::all());
    }

    public function test_consultation_break_end_only_requred_when_start_is_present(){
        $this->actingAsAdmin();

        $response = $this->post('/konsultacijos', array_merge($this->data(), ['break_end' => '']));

        $response->assertSessionHasErrors('break_end');

        $this->assertCount(0, Consultation::all());
    }

    private function data(){
        return [
            "company_id" => "1",
            "contacts" => "+370, el@pastas.lt",
            "theme" => "22",
            "reg_county" => "akmenes-r",
            "address" => "Nemuno Krantinė 26-6",
            "user_id" => "3",
            "consultation_date" => "2020-02-23",
            "consultation_start" => "8:00",
            "consultation_length" => "2:00",
            "break_start" => "12:00",
            "break_end" => "13:00",
            "method" => "Skype",
            "action" => "save",
        ];
    }

}
