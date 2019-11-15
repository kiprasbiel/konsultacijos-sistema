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
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array {
        $all_data = [];
        $tarpine_array = [];
        foreach ($this->data as $single_data){

            $tarpine_array[] = $single_data;
        }
        $all_data[] = $tarpine_array;
        return $all_data;

    }

    public function headings(): array
    {
        $menesiai = ['sausis', 'vasaris', 'kovas', 'balandis', 'gegužė', 'birželis', 'liepa', 'rugpjūtis', 'rugsėjis', 'spalis', 'lapkritis', 'gruodis'];
        return [
            [
                ' ',
            ],
            [
                ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
                '2016 m. liepos 1 d. bendradarbiavimo sutarties Nr. 1',
            ],
            [
                ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
                '1 priedas'
            ],
            [
                ' ',
                'Ataskaita apie apmokėtų per ataskaitinį laikotarpį konsultacijų pagal priemonę "Verslo konsultantas LT" teikimą',
            ],
            [
                ' ',' ',' ',' ',' ',' ',' ',' ',
                'Data',
                ' ',' ',
                'Pirminė',
                'x'
            ],
            [
                ' ',' ',
                'Atskaitinis laikotarpis: ' . date("Y") . 'm. ' . $menesiai[date("m")-1] . ' mėn.',
                ' ',' ',' ',' ',' ',
                date("Y.m.d"),
                ' ',' ',
                'Taisyta'
            ],
            [
                ' ',
            ],
            [
                'Bendra informacija apie konsultantą',
                ' ',
                'Bendra informacija apie paslaugos gavėją',
                ' ', ' ', ' ',
                'Informacija apie dalyvavimą konsultacijose',
                ' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',
                'VL pastabos'
            ],
            [
                "Konsultanto pavadinimas",
                "Konsultanto kodas (įmonės\nkodas arba asmens kodas)",
                "Paslaugos gavėjo\npavadinimas",
                "Paslaugos gavėjo kodas\n(įmonės kodas arba asmens\nkodas)",
                "Paslaugos gavėjo\nregistracijos data",
                "Savivaldybė (kurioje\nregistruotas paslaugos\ngavėjas)",
                "Konsultacijos tipas (jei verslo\npradžios (iki 1 metų) - žymima\n\"PR\", jei verslo plėtros (nuo 1\nmetų iki 5 metų) - žymima \"PL\"",
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
            ],
            [
                " ", " "," ", " "," ", " ", " ", " "," ",  " ", " ", " ",
                "Valandų skaičius",
                "Minučių skaičius",
                "Valanda",
                "Minutės",
                " ", " ", " ", " ",
            ],
            [
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'
            ],
        ];
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
            AfterSheet::class => function(AfterSheet $event) use ($styleArray, $styleArray3, $styleArray4, $row_color_array, $mini_tables){
                $highestRow = $event->sheet->getHighestRow();

                //Horizontalus mergas
                $event->sheet->mergeCells('N2:S2');
                $event->sheet->mergeCells('B4:I4');
                $event->sheet->mergeCells('C6:E6');
                $event->sheet->mergeCells('A8:B8');
                $event->sheet->mergeCells('C8:F8');
                $event->sheet->mergeCells('G8:R8');
                $event->sheet->mergeCells('S8:T8');

                $event->sheet->mergeCells('M9:N9');
                $event->sheet->mergeCells('O9:P9');

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
                $event->sheet->mergeCells('L9:L10');
                $event->sheet->mergeCells('Q9:Q10');
                $event->sheet->mergeCells('R9:R10');
                $event->sheet->mergeCells('S9:S10');
                $event->sheet->mergeCells('T9:T10');

                //Kiti pakeitimai
                $event->sheet->getStyle('A1:L6')->applyFromArray($styleArray);
                $event->sheet->getStyle('A1:T'.$highestRow)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A8:T'.$highestRow)->applyFromArray($styleArray4);
                $event->sheet->getStyle('A8:T'.$highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('A8:B'.$highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('C8:F'.$highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('G8:R'.$highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('S8:T'.$highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('A11:T11')->applyFromArray($row_color_array);

                //Mini tables top
                $event->sheet->getStyle('I5:I6')->applyFromArray($mini_tables);
                $event->sheet->getStyle('L5:M6')->applyFromArray($mini_tables);

                //Teksto sukimas
                $event->sheet->getStyle('A9:L9')->getAlignment()->setTextRotation(90);
                $event->sheet->getStyle('Q9:T9')->getAlignment()->setTextRotation(90);
                $event->sheet->getRowDimension('9')->setRowHeight(100);

                //Fonto keitimas
                $event->sheet->getStyle('A12:A'.$highestRow)->getFont()->setSize(9);

                //Columns resize
                $event->sheet->getColumnDimension('A')->setWidth(20);
                $event->sheet->getColumnDimension('B')->setWidth(10);
                $event->sheet->getColumnDimension('C')->setWidth(18);
                $event->sheet->getColumnDimension('D')->setWidth(10);
                $event->sheet->getColumnDimension('E')->setWidth(13);
                $event->sheet->getColumnDimension('F')->setWidth(15);
                $event->sheet->getColumnDimension('H')->setWidth(8);
                $event->sheet->getColumnDimension('I')->setWidth(13);
                $event->sheet->getColumnDimension('L')->setWidth(15);
                $event->sheet->getColumnDimension('L')->setWidth(15);
                $event->sheet->getColumnDimension('Q')->setWidth(13);
            },
        ];
    }
}
