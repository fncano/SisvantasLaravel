<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;

use sisventas\Persona;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
{
    public function __construct(){


    }
    public function index(Request $request){

    	if ($request){
    		$query=trim($request->get('searchText'));
    		$personas=DB::table('persona')
    		->where('nombre','like','%'.$query.'%')
    		->where('tipopersona', '=', 'cliente')
    		->orwhere('numdocumento','like','%'.$query.'%')
    		->where('tipopersona', '=', 'cliente')
    		->orderBy('idpersona','desc')
    		->paginate(7);
    		return view('ventas.cliente.index', ["personas"=>$personas,"searchText"=>$query]);
    	}
    }

    

    public function create(){
    	return view("ventas.cliente.create");
    	
    }

    public function store(PersonaFormRequest $request){
    	$persona=new Persona;
    	$persona->tipopersona='Cliente';
    	$persona->nombre=$request->get('nombre');
    	$persona->tipodocumento=$request->get('tipodocumento');
    	$persona->numdocumento=$request->get('numdocumento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
    	$persona->save();
    	return Redirect::to('ventas/cliente');
    	
    }

    public function show($id){
    	return view("ventas.cliente.show", ["persona"=>Persona::findOrFail($id)]);
    	
    }

    public function edit($id){
    	return view("ventas.cliente.edit", ["persona"=>Persona::findOrFail($id)]);
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
    	return Redirect::to('ventas/cliente');
    	
    }

    public function destroy($id){
    	$persona=Persona::findOrFail($id);
    	$persona->tipopersona='Inactivo';
    	$persona->update();
    	return Redirect::to('ventas/cliente');
    	
    }
}
