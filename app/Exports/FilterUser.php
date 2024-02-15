<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class FilterUser implements FromArray, WithHeadings, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        if (empty($this->data)) {
            return [
                ['Data tidak ada']
            ];
        }

        $filteredData = array_map(function ($row) {
            return array_values(array_diff_key($row, ['id' => '']));
        }, $this->data);

        return $filteredData;
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Email',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                if (empty($this->data)) {
                    $event->sheet->mergeCells('A2:C2');
                    $event->sheet->setCellValue('A2', 'Data tidak ada');
                    $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                }
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);
            },
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 30,
        ];
    }

    public function rowHeight(): float
    {
        return 15;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',

        ];
    }

    public function columnAlignment(): array
    {
        return [
            'A' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'B' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'C' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ];
    }
}
