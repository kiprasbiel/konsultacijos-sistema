<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ConsultationExport extends DefaultValueBinder  implements WithHeadings, FromArray, WithEvents, ShouldAutoSize, WithCustomValueBinder
{
    protected $data;
    protected $updated_data;
    public function __construct($data, $updated_data)
    {
        $this->data = $data;
        $this->updated_data = $updated_data;
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
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
        return [
            [
                ' ',
            ],
            [
                ' ',
                'Ataskaita apie būsimas konsultacijas',
            ],
            [
                ' ',
            ],
            [
                ' ',
                'VšĮ "Promas LT"',
                ' ',
                ' ',
                date("Y.m.d"),
            ],
            [
                ' ',
            ],
            [
                ' ',
                'Eksporto konsultacijos',
            ],
            ["Eil.\nNr.",
            "Paslaugos gavėjas\n(Pavadinimas/ Vardas pavardė)",
            "Paslaugų gavėjo kontaktinė\ninformacija (el. paštas/\ntelefonas)",
            "Konsultacijos tema",
            "Paslaugų teikimo\nsavivaldybė (tikslus\nadresas)",
            "Numatoma\nkonsultacijos\ndata",
            "Numatomas\nkonsultacijos\npradžios laikas\n(val.:min.)",
            "Numatoma\nkonsultacijos\ntrukmė\n(val.:min.)",
            "Numatomas\nkonsultacijos būdas\n(Susitikimas, telefonu,\nSkype)",]
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array {
        $change_collumns_names = [
            'contacts' => 'C',
            'address' => 'E',
            'consultation_date' => 'F',
            'consultation_time' => 'G',
            'consultation_length' => 'H',
            'method' => 'I',
            'county' => 'E',
            'break_start' => 'G',
            'break_end' => 'G',
        ];

        $changes_column_array = array_intersect_key($change_collumns_names, array_flip($this->updated_data));
        $column_names = array_values($changes_column_array);
        if (!empty($this->updated_data)){
            $color_array = [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00',
                    ],
                ],
            ];
        }
        else {
            $color_array = [];
        }

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $styleArray2 = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => 'medium',
                    'color' => ['argb' => '00000000'],
                ],
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

        return [
            // Handle by a closure.
            AfterSheet::class => function(AfterSheet $event) use ($styleArray, $styleArray2, $styleArray3, $styleArray4, $color_array, $column_names){
                $highestRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:L6')->applyFromArray($styleArray);
                $event->sheet->getStyle('B4')->applyFromArray($styleArray2);
                $event->sheet->getStyle('E4')->applyFromArray($styleArray2);
                $event->sheet->getStyle('A7:I'.$highestRow)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A7:I'.$highestRow)->applyFromArray($styleArray4);
                $event->sheet->getStyle('A7:I'.$highestRow)->applyFromArray($styleArray3);
                if (!empty($color_array)){
                    foreach ($column_names as $column){
                        $event->sheet->getStyle($column . '8')->applyFromArray($color_array);
                    }

                }
            },
        ];
    }
}
