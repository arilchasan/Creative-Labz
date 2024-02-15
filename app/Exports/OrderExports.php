<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class OrderExports implements FromArray, WithHeadings, WithColumnWidths , WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        if (empty($this->data)) {
            return [['No', 'Customer', 'Subtotal', 'Total', 'Promo', 'Status', 'Address', 'Payment', 'Resi']];
        }

        $filteredData = array_map(function ($row, $index) {
            return array_merge([++$index], array_values(array_diff_key($row, ['id' => ''])));
        }, $this->data, array_keys($this->data));

        return $filteredData;
    }

    public function headings(): array
    {

        return [
            'No',
            'Customer',
            'Subtotal',
            'Total',
            'Promo',
            'Status',
            'Address',
            'Payment',
            'Resi',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                if (empty($this->data)) {
                    $event->sheet->mergeCells('A2:I2');
                    $event->sheet->setCellValue('A2', 'Data tidak ada');
                    $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
                }
                $event->sheet->getStyle('A1:J1')->applyFromArray([
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
            'C' => 15,
            'D' => 15,
            'E' => 10,
            'F' => 20,
            'G' => 50,
            'H' => 15,
            'I' => 10,
        ];
    }

    public function rowHeight(): float
    {
        return 15;
    }


    public function columnAlignment(): array
    {
        return [
            'A' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'B' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'C' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'D' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'E' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'F' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'G' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'H' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'I' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ];
    }
}
