<?php

namespace Tests\Feature;

use App\Client;
use App\Consultation;
use App\Exports\ConsultationMonthExport;
use App\Http\Controllers\ExcelExportController;
use App\User;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class Exports extends TestCase
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
        factory(Consultation::class, 50)->state('ECO')->create([
            'consultation_date' => '2020-02-15',
            'is_paid' => 0,
        ]);
        factory(Consultation::class, 50)->state('EXPO')->create([
            'consultation_date' => '2020-02-15',
            'is_paid' => 0
        ]);
        factory(Consultation::class, 50)->state('VKT')->create([
            'consultation_date' => '2020-02-15',
            'is_paid' => 0
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_export_conf_index()
    {
        $response = $this->get('/conf-month-gen');

        $response->assertStatus(200);
    }

    public function test_factories()
    {
        $this->factories();
        $this->withoutExceptionHandling();
        $this->assertCount(150, Consultation::all());
        $this->assertCount(50, Consultation::whereBetween('theme_id', [1, 5])->get());
        $this->assertCount(50, Consultation::whereBetween('theme_id', [6, 11])->get());
        $this->assertCount(50, Consultation::whereBetween('theme_id', [12, 30])->get());
    }

     public function test_export_only_eco_cons(){
        $this->factories();
        $this->withoutExceptionHandling();
        Excel::fake();
        $response = $this->post('/configure', [
            "ex-date" => "2020-02",
            "con_payment" => "2",
            "con_type" => "ECO",
            "action" => "download",
        ]);

        $response->assertSessionMissing('error');

        //Check if XLSX has 50 lines of consultations
        Excel::assertDownloaded('menesio-ataskaita.xlsx');

    }

    public function test_export_only_expo_cons(){
        $this->withoutExceptionHandling();
        $this->factories();
        Excel::fake();
        $response = $this->post('/configure', [
            "ex-date" => "2020-02",
            "con_payment" => "2",
            "con_type" => "EXPO",
            "action" => "download",
        ]);

        //Check if XLSX has 50 lines of consultations
        Excel::assertDownloaded('menesio-ataskaita.xlsx');


    }

    public function test_export_only_vkt_cons(){
        $this->factories();
        Excel::fake();
        $response = $this->post('/configure', [
            "ex-date" => "2020-02",
            "con_payment" => "2",
            "con_type" => "vkt",
            "action" => "download",
        ]);

        //Check if XLSX has 50 lines of consultations
        Excel::assertDownloaded('menesio-ataskaita.xlsx');

    }

}
