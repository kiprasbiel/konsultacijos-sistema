<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExportConsultations extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();
        $this->actingAs(factory(User::class)->create());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExport() {
        $this->withoutExceptionHandling();

        $response = $this->post('/configure', [
            "ex-date" => "2020-02",
            "con_payment" => "2",
            "con_type" => "VKT",
            "action" => "download",
        ]);

        $response->assertRedirect('/');
    }
}
