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

class ConsultationDeleteExport extends DefaultValueBinder implements WithHeadings, FromArray, WithEvents, ShouldAutoSize, WithCustomValueBinder
{
    protected $data;
    public function __construct($data, $main_theme)
    {
        $this->data = $data;
        $this->main_theme = $main_theme;
        if ($main_theme == 'VKT'){
            $this->main_theme = 'Verslo';
        }
    }

    public function bindValue(Cell $cell, $value) {
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
                'Atšauktos konsultacijos',
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
                $this->main_theme . ' konsultacijos',
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
        $color_array_deleted = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFF0000',
                ],
            ],
        ];

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
            AfterSheet::class => function(AfterSheet $event) use ($styleArray, $styleArray2, $styleArray3, $styleArray4, $color_array_deleted){
                $highestRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A1:L6')->applyFromArray($styleArray);
                $event->sheet->getStyle('B4')->applyFromArray($styleArray2);
                $event->sheet->getStyle('E4')->applyFromArray($styleArray2);
                $event->sheet->getStyle('A7:I'.$highestRow)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A7:I'.$highestRow)->applyFromArray($styleArray4);
                $event->sheet->getStyle('A7:I'.$highestRow)->applyFromArray($styleArray3);
                $event->sheet->getStyle('H8')->applyFromArray($color_array_deleted);
            },
        ];
    }
}
