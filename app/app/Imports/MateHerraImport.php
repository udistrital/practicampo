<?php

namespace PractiCampoUD\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PractiCampoUD\materiales_herramientas_proyeccion;
use Maatwebsite\Excel\Concerns\ToModel;

class MateHerraImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row)
        {
            
            $mate_herra = materiales_herramientas_proyeccion::create([
                'id'=>$mate_herra_proyeccion->id,
                'det_materiales_rp'=>$row['materiales_rp']
            ]);
            
        }
    }
}
