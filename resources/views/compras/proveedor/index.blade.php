@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Proveedores<a href="proveedor/create"> <button class="btn btn-success">nuevo</button></a></h3>
			@include('compras.proveedor.search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Id</th>
						<th>Nombre</th>
						<th>T. Doc.</th>
						<th>Numro Doc.</th>
						<th>Telefono</th>
						<th>Email</th>
						<th>Opciones</th>
					</thead>
					@foreach ($personas as $per)
					<tbody>
						<td>{{$per->idpersona}}</td>
						<td>{{$per->nombre}}</td>
						<td>{{$per->tipodocumento}}</td>
						<td>{{$per->numdocumento}}</td>
						<td>{{$per->telefono}}</td>
						<td>{{$per->email}}</td>
						<td>
							<a href="{{URL::action('ProveedorController@edit',$per->idpersona)}}"><button class="btn btn-info">editar</button></a>
							<a href="" data-target="#modal-delete-{{$per->idpersona}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
						</td>
					</tbody>
					@include('compras.proveedor.modal')
					@endforeach
				</table>
			</div>
			{{$personas->render()}}
		</div>
	</div>
@endsection