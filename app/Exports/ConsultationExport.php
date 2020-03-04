<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ConsultationExport extends DefaultValueBinder implements WithHeadings, FromArray, WithEvents, ShouldAutoSize, WithCustomValueBinder, WithColumnFormatting
{
    protected $data;
    protected $updated_data;
    protected $header;

    public function __construct($data, $updated_data, $excel_header) {
        $this->data = $data;
        $this->updated_data = $updated_data;
        $this->header = $excel_header;
    }

    public function bindValue(Cell $cell, $value) {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_TIME4,
        ];
    }

    public function array(): array {


        $all_data = [];


        $i = 0;
        foreach ($this->data as $key => $single_theme) {
            if ($key == 'VKT') {
                $key = 'Verslo';
            }

            $theme_head = [[
                ' ',
                $key . ' konsultacijos',
            ],
                ["Eil.\nNr.",
                    "Paslaugos gavėjas\n(Pavadinimas/ Vardas pavardė)",
                    "Paslaugų gavėjo kontaktinė\ninformacija (el. paštas/\ntelefonas)",
                    "Konsultacijos tema",
                    "Paslaugų teikimo\nsavivaldybė (tikslus\nadresas)",
                    "Numatoma\nkonsultacijos\ndata",
                    "Numatomas\nkonsultacijos\npradžios laikas\n(val.:min.)",
                    "Numatoma\nkonsultacijos\ntrukmė\n(val.:min.)",
                    "Numatomas\nkonsultacijos būdas\n(Susitikimas, telefonu,\nSkype)",]];

            if ($i == 0) {
                $all_data[] = $theme_head;
            } else {
                array_push($all_data[0], $theme_head[0]);
                array_push($all_data[0], $theme_head[1]);
            }

            foreach ($single_theme as $single_data) {
                array_push($all_data[0], $single_data);
            }
            $i++;
        }


        return $all_data;
    }

    public function headings(): array {
        return [
            [
                ' ',
            ],
            [
                ' ',
                $this->header,
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
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array {
        $count_arr = [];
        foreach ($this->data as $key => $single_theme) {
            $count_arr[] = count($single_theme);
        }

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
            'user_id' => 'D'
        ];

        $changes_column_array = array_intersect_key($change_collumns_names, array_flip($this->updated_data));
        $column_names = array_values($changes_column_array);
        if (!empty($this->updated_data)) {
            $color_array = [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFFF00',
                    ],
                ],
            ];
        } else {
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
            AfterSheet::class => function (AfterSheet $event) use ($styleArray, $styleArray2, $styleArray3, $styleArray4, $color_array, $column_names, $count_arr) {
                $highestRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:L6')->applyFromArray($styleArray);
                $event->sheet->getStyle('B4')->applyFromArray($styleArray2);
                $event->sheet->getStyle('E4')->applyFromArray($styleArray2);

                $current_start = 7;
                $current_end = 7;
                for ($x = 1; $x <= count($count_arr); $x++) {
                    $current_end += $count_arr[$x - 1];
                    $event->sheet->getStyle('A' . $current_start . ':I' . $current_end)->getAlignment()->setWrapText(true);
                    $event->sheet->getStyle('A' . $current_start . ':I' . $current_end)->applyFromArray($styleArray4);
                    $event->sheet->getStyle('A' . $current_start . ':I' . $current_end)->applyFromArray($styleArray3);
                    $event->sheet->getStyle('A'.($current_end+1).':L'.($current_end+1))->applyFromArray($styleArray);
                    $current_start = $current_end + 2;
                    $current_end = $current_start;
                }


                if (!empty($color_array)) {
                    foreach ($column_names as $column) {
                        $event->sheet->getStyle($column . '8')->applyFromArray($color_array);
                    }

                }
            },
        ];
    }
}
