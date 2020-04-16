<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class IncomingDocumentExport implements FromArray, WithHeadings, WithEvents
{
    protected $incomingDocs;
    protected $headings;

    public function __construct(array $incomingDocs, array $headings)
    {
        $this->incomingDocs = $incomingDocs;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->incomingDocs;
    }
	
	public function headings(): array
    {
        return $this->headings;
    }
	
	public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }
}
