<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ConsultationMonthExport implements WithHeadings, FromArray, WithEvents
{
    protected $data;

    public function __construct($data, $type, $month, $year) {
        $this->data = $data;
        $this->type = $type;
        $this->month = $month;
        $this->year = $year;
    }

    public function array(): array {
        $all_data = [];
        $tarpine_array = [];
        foreach ($this->data as $single_data) {

            $tarpine_array[] = $single_data;
        }
        $all_data[] = $tarpine_array;
        return $all_data;

    }

    public function headings(): array {
        switch ($this->type) {
            case 'VKT':
                $full_type = 'Verslo';
                $additive = 1;
                $header_text = "Konsultacijos tipas (jei verslo pradžios (iki 1 metų) - žymima \"PR\", jei verslo plėtros (nuo 1 metų iki 5 metų) - žymima \"PL\")";
                break;
            case 'EXPO':
                $full_type = 'Expo';
                $additive = 3;
                $header_text = "Konsultacijos tipas (jei\niki 3 metų - žymima\n\"IKI3\", jei virš 3 metų -\nžymima \"PO3\")";
                break;
            case 'ECO':
                $full_type = 'Eco';
                $additive = 1;
                $header_text = '';
                break;
        }
        $menesiai = ['sausio', 'vasario', 'kovo', 'balandžio', 'gegužės', 'birželio', 'liepos', 'rugpjūčio', 'rugsėjo', 'spalio', 'lapkričio', 'gruodžio'];
        $return_array = [
            [
                ' ',
            ],
            [
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                '2016 m. liepos 1 d. bendradarbiavimo sutarties Nr. 1',
            ],
            [
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                $additive . ' priedas'
            ],
            [
                ' ',
                'Ataskaita apie apmokėtų per ataskaitinį laikotarpį konsultacijų pagal priemonę "' . $full_type . ' konsultantas LT" teikimą',
            ],
            [
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                'Data',
                ' ', ' ',
                'Pirminė',
                'x'
            ],
            [
                ' ', ' ',
                'Atskaitinis laikotarpis: ' . $this->year . 'm. ' . $menesiai[intval($this->month) - 1] . ' mėn.',
                ' ', ' ', ' ', ' ', ' ',
                date("Y.m.d"),
                ' ', ' ',
                'Taisyta'
            ],
            [
                ' ',
            ],

        ];

        if($this->type == 'VKT' || $this->type == 'EXPO'){
            $top_columns_headers = [
                'Bendra informacija apie konsultantą',
                ' ',
                'Bendra informacija apie paslaugos gavėją',
                ' ', ' ', ' ',
                'Informacija apie dalyvavimą konsultacijose',
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                'VL pastabos'
            ];
            $columns_headers = [
                "Konsultanto pavadinimas",
                "Konsultanto kodas (įmonės\nkodas arba asmens kodas)",
                "Paslaugos gavėjo\npavadinimas",
                "Paslaugos gavėjo kodas\n(įmonės kodas arba asmens\nkodas)",
                "Paslaugos gavėjo\nregistracijos data",
                "Savivaldybė (kurioje\nregistruotas paslaugos\ngavėjas)",
                $header_text,
                "Konsultacijos temos kodas",
                "Data, kada paslaugų gavėjas\ndalyvavo konsultacijose\n(metai, mėnuo, diena)",
                "Dalyvavo (žymima \"Taip\"\narba \"Ne\")",
                "Ar pateikta konsultanto ir\npaslaugų gavėjo pasirašyta\nsąskaita faktųra (žymima \"Taip\"\narba \"Ne\")",
                "Savivaldybė, kurioje vyko\npaslauga",

                "Konsultacijos\ntrukmė",
                " ",
                "Konsultacijos\nprad. laikas",
                " ",

                "Apmokėjimo už konsultacijas\ndata",
                "Apmokėta už konsultaicjas\n(žymima \"Taip\" arba \"Ne\")",
                "Pastaba",
                "VL veiksmai",
            ];

            $colums_numbers = [
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'
            ];

            $lower_columns_headers = [
                " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ",
                "Valandų skaičius",
                "Minučių skaičius",
                "Valanda",
                "Minutės",
                " ", " ", " ", " ",
            ];
        }
        else{
            $top_columns_headers = [
                'Bendra informacija apie konsultantą',
                ' ',
                'Bendra informacija apie paslaugos gavėją',
                ' ', ' ', ' ',
                'Informacija apie dalyvavimą konsultacijose',
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                'VL pastabos'
            ];
            $columns_headers = [
                "Konsultanto pavadinimas",
                "Konsultanto kodas (įmonės\nkodas arba asmens kodas)",
                "Paslaugos gavėjo\npavadinimas",
                "Paslaugos gavėjo kodas\n(įmonės kodas arba asmens\nkodas)",
                "Paslaugos gavėjo\nregistracijos data",
                "Savivaldybė (kurioje\nregistruotas paslaugos\ngavėjas)",
                "Konsultacijos temos kodas",
                "Data, kada paslaugų gavėjas\ndalyvavo konsultacijose\n(metai, mėnuo, diena)",
                "Dalyvavo (žymima \"Taip\"\narba \"Ne\")",
                "Ar pateikta konsultanto ir\npaslaugų gavėjo pasirašyta\nsąskaita faktųra (žymima \"Taip\"\narba \"Ne\")",
                "Savivaldybė, kurioje vyko\npaslauga",

                "Konsultacijos\ntrukmė",
                " ",
                "Konsultacijos\nprad. laikas",
                " ",

                "Apmokėjimo už konsultacijas\ndata",
                "Apmokėta už konsultaicjas\n(žymima \"Taip\" arba \"Ne\")",
                "Pastaba",
                "VL veiksmai",
            ];

            $colums_numbers = [
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19'
            ];

            $lower_columns_headers = [
                " ", " ", " ", " ", " ", " ", " ", " ", " ", " ", " ",
                "Valandų skaičius",
                "Minučių skaičius",
                "Valanda",
                "Minutės",
                " ", " ", " ", " ",
            ];
        }
        $return_array[] = $top_columns_headers;
        $return_array[] = $columns_headers;
        $return_array[] = $lower_columns_headers;
        $return_array[] = $colums_numbers;


        return $return_array;
    }

    /**
     * @return array
     */
    public function registerEvents(): array {
        $row_color_array = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'BDBDBD',
                ],
            ],
        ];

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $styleArray3 = [
            'borders' => [
                'outline' => [
                    'borderStyle' => 'medium',
                    'color' => ['argb' => '00000000'],
                ],
                'inside' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => '00000000'],
                ],

            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
        ];
        $styleArray4 = [
            'alignment' => [
                'vertical' => 'center',
            ],
        ];
        $mini_tables = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => '00000000'],
                ],

            ],
        ];

        return [
            // Handle by a closure.
            AfterSheet::class => function (AfterSheet $event) use ($styleArray, $styleArray3, $styleArray4, $row_color_array, $mini_tables) {
                $highestRow = $event->sheet->getHighestRow();
                //Horizontalus mergas
                $event->sheet->mergeCells('N2:S2');
                $event->sheet->mergeCells('B4:I4');
                $event->sheet->mergeCells('C6:E6');
                $event->sheet->mergeCells('A8:B8');
                $event->sheet->mergeCells('C8:F8');

                if ($this->type == 'VKT' ||$this->type == 'EXPO'){
                    $event->sheet->mergeCells('G8:R8');
                    $event->sheet->mergeCells('S8:T8');
                    $event->sheet->mergeCells('M9:N9');
                    $event->sheet->mergeCells('O9:P9');
                    $event->sheet->mergeCells('T9:T10');

                    //Vertikalus
                    $event->sheet->mergeCells('L9:L10');

                    //Teksto sukimas
                    $event->sheet->getStyle('A9:L9')->getAlignment()->setTextRotation(90);
                    $event->sheet->getStyle('Q9:T9')->getAlignment()->setTextRotation(90);

                    //Spalvinimas
                    $event->sheet->getStyle('A11:T11')->applyFromArray($row_color_array);

                    //Borders
                    $event->sheet->getStyle('A8:T' . $highestRow)->applyFromArray($styleArray3);
                    $event->sheet->getStyle('G8:R' . $highestRow)->applyFromArray($styleArray3);
                    $event->sheet->getStyle('S8:T' . $highestRow)->applyFromArray($styleArray3);

                    //Fonts
                    $event->sheet->getColumnDimension('H')->setWidth(8);
                    $event->sheet->getColumnDimension('I')->setWidth(13);
                    $event->sheet->getColumnDimension('L')->setWidth(15);
                    $event->sheet->getColumnDimension('Q')->setWidth(13);
                }
                else{
                    $event->sheet->mergeCells('G8:Q8');
                    $event->sheet->mergeCells('R8:S8');
                    $event->sheet->mergeCells('L9:M9');
                    $event->sheet->mergeCells('N9:O9');

                    //Vertikalus
                    $event->sheet->mergeCells('P9:P10');

                    //Teksto sukimas
                    $event->sheet->getStyle('A9:K9')->getAlignment()->setTextRotation(90);
                    $event->sheet->getStyle('P9:T9')->getAlignment()->setTextRotation(90);

                    //Spalvinimas
                    $event->sheet->getStyle('A11:S11')->applyFromArray($row_color_array);

                    //Borders
                    $event->sheet->getStyle('A8:S' . $highestRow)->applyFromArray($styleArray3);
                    $event->sheet->getStyle('G8:Q' . $highestRow)->applyFromArray($styleArray3);
                    $event->sheet->getStyle('R8:S' . $highestRow)->applyFromArray($styleArray3);

                    //Fonts
                    $event->sheet->getColumnDimension('H')->setWidth(13);
                    $event->sheet->getColumnDimension('K')->setWidth(15);
                    $event->sheet->getColumnDimension('P')->setWidth(13);
                    $event->sheet->getColumnDimension('I')->setWidth(10);
                }





                //Vertikalus mergas
                $event->sheet->mergeCells('A9:A10');
                $event->sheet->mergeCells('B9:B10');
                $event->sheet->mergeCells('C9:C10');
                $event->sheet->mergeCells('D9:D10');
                $event->sheet->mergeCells('E9:E10');
                $event->sheet->mergeCells('F9:F10');
                $event->sheet->mergeCells('G9:G10');
                $event->sheet->mergeCells('H9:H10');
                $event->sheet->mergeCells('I9:I10');
                $event->sheet->mergeCells('J9:J10');
                $event->sheet->mergeCells('K9:K10');

                $event->sheet->mergeCells('Q9:Q10');
                $event->sheet->mergeCells('R9:R10');
                $event->sheet->mergeCells('S9:S10');


                //Kiti pakeitimai
                $event->sheet->getStyle('A1:L6')->applyFromArray($styleArray);
                $event->sheet->getStyle('A1:T' . $highestRow)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A8:T' . $highestRow)->applyFromArray($styleArray4);

                $event->sheet->getStyle('A8:B' . $highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('C8:F' . $highestRow)->applyFromArray($styleArray3);



                //Mini tables top
                $event->sheet->getStyle('I5:I6')->applyFromArray($mini_tables);
                $event->sheet->getStyle('L5:M6')->applyFromArray($mini_tables);



                $event->sheet->getRowDimension('9')->setRowHeight(100);

                //Fonto keitimas
                $event->sheet->getStyle('A12:A' . $highestRow)->getFont()->setSize(9);

                //Columns resize
                $event->sheet->getColumnDimension('A')->setWidth(20);
                $event->sheet->getColumnDimension('B')->setWidth(10);
                $event->sheet->getColumnDimension('C')->setWidth(18);
                $event->sheet->getColumnDimension('D')->setWidth(10);
                $event->sheet->getColumnDimension('E')->setWidth(13);
                $event->sheet->getColumnDimension('F')->setWidth(15);





            },
        ];
    }
}
