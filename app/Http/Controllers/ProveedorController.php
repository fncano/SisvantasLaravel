<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;

use sisventas\Persona;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
{
    public function __construct(){


    }
    public function index(Request $request){

    	if ($request){
    		$query=trim($request->get('searchText'));
    		$personas=DB::table('persona')
    		->where('nombre','like','%'.$query.'%')
    		->where('tipopersona', '=', 'proveedor')
    		->orwhere('numdocumento','like','%'.$query.'%')
    		->where('tipopersona', '=', 'proveedor')
    		->orderBy('idpersona','desc')
    		->paginate(7);
    		return view('compras.proveedor.index', ["personas"=>$personas,"searchText"=>$query]);
    	}
    }

    

    public function create(){
    	return view("compras.proveedor.create");
    	
    }

    public function store(PersonaFormRequest $request){
    	$persona=new Persona;
    	$persona->tipopersona='Proveedor';
    	$persona->nombre=$request->get('nombre');
    	$persona->tipodocumento=$request->get('tipodocumento');
    	$persona->numdocumento=$request->get('numdocumento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
    	$persona->save();
    	return Redirect::to('compras/proveedor');
    	
    }

    public function show($id){
    	return view("compras.proveedor.show", ["persona"=>Persona::findOrFail($id)]);
    	
    }

    public function edit($id){
    	return view("compras.proveedor.edit", ["persona"=>Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $request, $id){
    	$persona=Persona::findOrFail($id);
    	$persona->nombre=$request->get('nombre');
    	$persona->tipodocumento=$request->get('tipodocumento');
    	$persona->numdocumento=$request->get('numdocumento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
    	$persona->update();
    	return Redirect::to('compras/proveedor');
    	
    }

    public function destroy($id){
    	$persona=Persona::findOrFail($id);
    	$persona->tipopersona='Inactivo';
    	$persona->update();
    	return Redirect::to('compras/proveedor');
    	
    }
}
