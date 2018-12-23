<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table ='ingreso';
    protected $primaryKey='idingreso';
    public $timestamps=false;


    protected $fillable =[
    	'idproveedor',
    	'tipocomprobante',
    	'seriecomprobante',
    	'numcomprobante',
    	'fecha_hora',
    	'impuesto',
    	'estado'
    ];

    protected $guarded =[

    ];
}
