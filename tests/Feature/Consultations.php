<?php

namespace Tests\Feature;

use App\Client;
use App\Consultation;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class Consultations extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->actingAs(factory(User::class)->create());
        $this->seed('ThemesTableSeeder');
        Consultation::truncate();
    }

    protected function factories(): void {
        factory(Client::class)->create();
        factory(Consultation::class, 50)->state('ECO')->create();
        factory(Consultation::class, 50)->state('EXPO')->create();
        factory(Consultation::class, 50)->state('VKT')->create();
    }

    public function test_factories() {
        $this->factories();
        $this->assertCount(150, Consultation::all());
        $this->assertCount(50, Consultation::whereBetween('theme_id', [1, 5])->get());
        $this->assertCount(50, Consultation::whereBetween('theme_id', [6, 11])->get());
        $this->assertCount(50, Consultation::whereBetween('theme_id', [12, 30])->get());
    }

    public function data(){

        return [
            "company_id" => "1",
            "contacts" => "labas@vakaras.com",
            "theme" => "1",
            "reg_county" => "kelmes-r",
            "address" => "499 Eloisa River Suite 65",
            "user_id" => "1",
            "consultation_date" => Carbon::tomorrow()->format('Y-m-d'),
            "consultation_start" => "00:24",
            "consultation_length" => "02:00",
            "break_start" => "14:53:50",
            "break_end" => "11:02:22",
            "method" => "Skype",
            "_method" => "PUT",
            "action" => "update",
        ];
    }

    public function test_consultation_edit_page() {
        $this->factories();
        $con = Consultation::first();

        $response = $this->get('/konsultacijos/' . $con->id . '/edit');

        $response->assertStatus(200);
    }

    public function test_consultation_edit_data() {
        $this->withoutExceptionHandling();
        $this->factories();
        $con = Consultation::first();
        $client = Client::first();
        $user = User::first();

        $response = $this->post('konsultacijos/' . $con->id, array_merge($this->data(), [
            "company_id" => $client->id,
            "user_id" => $user->id
        ]));
        $response->assertRedirect('/konsultacijos');
    }


}
