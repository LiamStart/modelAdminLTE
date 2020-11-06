<?php

namespace App\Exports;

use App\Factura_Ingreso;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromEvents;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FacturaExport implements FromView, WithEvents,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fecha1;
    private $fecha2;
    private $empresa;

    public function __construct($fecha1,$fecha2,$empresa){
        $this->fecha1= $fecha1;
        $this->fecha2= $fecha2;
        $this->empresa= $empresa;
    }
    public function registerEvents(): array{
        $styleArray=[
            'font'=>[
                'bold'=>true,
                'size'=>  20,                
            ]
        ];
        $empresa= $this->empresa;
        $fecha2= $this->fecha2;
        $fecha1= $this->fecha1;
        return [
            AfterSheet::class=>function(AfterSheet $event) use ($styleArray,$empresa,$fecha1,$fecha2){
                
            },
        ];
    }
    public function headings(): array
    {
        return [
           ['dsa', 'dsadas'],
           ['Second row', 'Second row'],
        ];
    }
    public function view(): View{
        $das=Factura_Ingreso::all();
        
        return view('factura_ingreso.export',[
            'factura_ingreso'=>Factura_Ingreso::all(),
            'empresa'=>$this->empresa,
            'fecha_desde'=>$this->fecha1,
            'fecha_hasta'=>$this->fecha2,
        ]
        );
    }
}
