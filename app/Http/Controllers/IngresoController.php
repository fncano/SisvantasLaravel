<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;

use sisventas\Ingreso;
use sisventas\DetalleIngreso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\IngresoFormRequest;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    public function __construct(){


    }
    public function index(Request $request){

    	if ($request){
    		$query=trim($request->get('searchText'));
    		$ingresos=DB::table('ingreso as i')
    		->join('persona as p','i.idproveedor','=','p.idpersona')
    		->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		->select('i.idingreso','i.fecha_hora','p.nombre','i.tipocomprobante','i.seriecomprobante','i.numcomprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra)as total'))
    		->where('i.numcomprobante', 'LIKE','%'.$query.'%')
    		->orderBy('i.idingreso','desc')
    		->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipocomprobante','i.seriecomprobante','i.numcomprobante','i.impuesto','i.estado')
    		->paginate(7);
    		return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
    		}
    }

  	public function create(){
    	$personas=DB::table('persona')->where('tipopersona','=','Proveedor')->get();
    	$articulos=DB::table('articulo as art')
	    	->select(DB::raw('CONCAT(art.codigo, " - ",art.nombre) AS articulo'),'art.idarticulo')
	    	->where('art.estado','=','Activo')
	    	->get();
	    	return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);
    }

    public function store(IngresoFormRequest $request){
    	try{
    		DB::beginTransaction();
    			$ingreso=new Ingreso;
    			$ingreso->idproveedor=$request->get('idproveedor');
    			$ingreso->tipocomprobante=$request->get('tipocomprobante');
    			$ingreso->seriecomprobante=$request->get('seriecomprobante');
    			$ingreso->numcomprobante=$request->get('numcomprobante');
    			$mytime = Carbon::now('America/Bogota');
    			$ingreso->fecha_hora=$mytime->toDateTimeString();
    			$ingreso->impuesto='19';
    			$ingreso->estado='A';
    			$ingreso->save();

    			$idarticulo =$request->get('idarticulo');
    			$cantidad =$request->get('cantidad');
    			$precio_compra = $request->get('precio_compra');
    			$precio_venta = $request->get('precio_venta');

    			$cont = 0;
    			while ($cont < count($idarticulo)) {
    				$detalle = new DetalleIngreso();
    				$detalle->idingreso=$ingreso->idingreso;
    				$detalle->idarticulo=$idarticulo[$cont];
    				$detalle->cantidad=$cantidad[$cont];
    				$detalle->precio_compra=$precio_compra[$cont];
    				$detalle->precio_venta=$precio_venta[$cont];
    				$detalle->save();
    				$cont=$cont+1;
    			}
    		DB::commit();
    	}catch(\Exception $e){
    		DB::rollback();
    	}
    	return Redirect::to('compras/ingreso');
    }

    public function show($id){
    	$ingreso=DB::table('ingreso as i')
    		->join('persona as p','i.idproveedor','=','p.idpersona')
    		->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
    		->select('i.idingreso','i.fecha_hora','p.nombre','i.tipocomprobante','i.seriecomprobante','i.numcomprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra)as total'))
    		->where('i.idingreso','=',$id)
    		->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipocomprobante','i.seriecomprobante','i.numcomprobante','i.impuesto','i.estado')
    		->first();

    	$detalles=DB::table('detalle_ingreso as d')
    		->join('articulo as a','d.idarticulo', '=', 'a.idarticulo')#es la union de las dos tablas
    		->select('a.nombre as articulo', 'd.cantidad','d.precio_compra','d.precio_venta')
    		->where('d.idingreso', '=', $id)
    		->get();
    		
    	return view("compras.ingreso.show",["ingreso"=>$ingreso, "detalles"=>$detalles]);
    }

    public function destroy($id){
    	$ingreso = Ingreso::findOrFail($id);
    	$ingreso->estado='C';
    	$ingreso->update();
    	return Redirect::to('compras/ingreso');
    }
}