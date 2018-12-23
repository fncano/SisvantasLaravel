<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table ='venta';
    protected $primaryKey='idventa';
    public $timestamps=false;


    protected $fillable =[
    	'idcliente',
    	'tipocomprobante',
    	'seriecomprobante',
    	'numcomprobante',
    	'fecha_hora',
    	'impuesto',
    	'totalventa',
    	'estado'
    ];

    protected $guarded =[

    ];
}
