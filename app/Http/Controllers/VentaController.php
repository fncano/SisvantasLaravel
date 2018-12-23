<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;

use sisventas\Venta;
use sisventas\DetalleVenta;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\VentaFormRequest;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct(){


    }
    public function index(Request $request){

    	if ($request){
    		$query=trim($request->get('searchText'));
    		$ventas=DB::table('Venta as v')
    		->join('persona as p','v.idcliente','=','p.idpersona')
    		->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		->select('v.idventa','v.fecha_hora','p.nombre','v.tipocomprobante','v.seriecomprobante','v.numcomprobante','v.impuesto','v.estado','v.totalventa')
    		->where('v.numcomprobante', 'LIKE','%'.$query.'%')
    		->orderBy('v.idventa','desc')
    		->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipocomprobante','v.seriecomprobante','v.numcomprobante','v.impuesto','v.estado','v.totalventa')
    		->paginate(7);
    		return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
    		}
    }

  	public function create(){
    	$personas=DB::table('persona')->where('tipopersona','=','Cliente')->get();
    	$articulos=DB::table('articulo as art')
    		->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
	    	->select(DB::raw('CONCAT(art.codigo, " - ",art.nombre) AS articulo'),'art.idarticulo','art.stock',DB::raw('avg(di.precio_venta) as promedio'))
	    	->where('art.estado','=','Activo')
	    	->where('art.stock','>','0')
	    	->groupBy('articulo','art.idarticulo','art.stock')
	    	->get();
	    	return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos]);
    }

    public function store(VentaFormRequest $request){
    	try{
    		DB::beginTransaction();
    			$venta=new Venta;
    			$venta->idcliente=$request->get('idcliente');
    			$venta->tipocomprobante=$request->get('tipocomprobante');
    			$venta->seriecomprobante=$request->get('seriecomprobante');
    			$venta->numcomprobante=$request->get('numcomprobante');
    			$venta->totalventa=$request->get('totalventa');
    			$mytime = Carbon::now('America/Bogota');
    			$venta->fecha_hora=$mytime->toDateTimeString();
    			$venta->impuesto='19';
    			$venta->estado='A';
    			$venta->save();

    			$idarticulo =$request->get('idarticulo');
    			$cantidad =$request->get('cantidad');
    			$descuento = $request->get('descuento');
    			$precioventa = $request->get('precioventa');

    			$cont = 0;
    			while ($cont < count($idarticulo)) {
    				$detalle = new DetalleVenta();
    				$detalle->idventa=$venta->idventa;
    				$detalle->idarticulo=$idarticulo[$cont];
    				$detalle->cantidad=$cantidad[$cont];
    				$detalle->descuento=$descuento[$cont];
    				$detalle->precioventa=$precioventa[$cont];
    				$detalle->save();
    				$cont=$cont+1;
    			}
    		DB::commit();
    	}catch(\Exception $e){
    		DB::rollback();
    	}
    	return Redirect::to('ventas/venta');
    }

    public function show($id){
    	$venta=DB::table('venta as v')
    		->join('persona as p','v.idcliente','=','p.idpersona')
    		->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		->select('v.idventa','v.fecha_hora','p.nombre','v.tipocomprobante','v.seriecomprobante','v.numcomprobante','v.impuesto','v.estado','v.totalventa')
    		->where('v.idventa','=',$id)
    		->first();

    	$detalles=DB::table('detalle_venta as d')
    		->join('articulo as a','d.idarticulo', '=', 'a.idarticulo')#es la union de las dos tablas
    		->select('a.nombre as articulo', 'd.cantidad','d.descuento','d.precioventa')
    		->where('d.idventa', '=', $id)
    		->get();
    		
    	return view("ventas.venta.show",["venta"=>$venta, "detalles"=>$detalles]);
    }

    public function destroy($id){
    	$venta = Venta::findOrFail($id);
    	$venta->estado='C';
    	$venta->update();
    	return Redirect::to('ventas/venta');
    }
}
