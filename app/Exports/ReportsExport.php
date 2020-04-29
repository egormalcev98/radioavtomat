<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportsExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $reports;
    protected $headings;
    protected $appeals;
	
    public function __construct($reports, array $headings, array $appeals)
    {
        $this->reports = $reports;
        $this->headings = $headings;
        $this->appeals = $appeals;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->reports;
    }
	
	public function map($doc): array
    {
		$mapArr = [];
		
		foreach($this->appeals as $appeal) {
			$mapArr[] = (is_array($appeal)) ? $doc->{$appeal['relation']}->{$appeal['attribute']} : $doc->{$appeal};
		}
		
		return $mapArr;
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
