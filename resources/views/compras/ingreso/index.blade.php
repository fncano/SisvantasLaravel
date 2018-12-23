@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Ingresos<a href="ingreso/create"> <button class="btn btn-success">nuevo</button></a></h3>
			@include('compras.ingreso.search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 colxs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Fecha</th>
						<th>Proveedor</th>
						<th>Comprobante</th>
						<th>Impuesto</th>
						<th>Total</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($ingresos as $ing)
					<tbody>
						<td>{{$ing->fecha_hora}}</td>
						<td>{{$ing->nombre}}</td>
						<td>{{$ing->tipocomprobante.': '.$ing->seriecomprobante.'-'.$ing->numcomprobante}}</td>
						<td>{{$ing->impuesto}}</td>
						<td>{{$ing->total}}</td>
						<td>{{$ing->estado}}</td>
						<td>
							<a href="{{URL::action('IngresoController@show',$ing->idingreso)}}"><button class="btn btn-primary">Detalle</button></a>
							<a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
						</td>
					</tbody>
					@include('compras.ingreso.modal')
					@endforeach
				</table>
			</div>
			{{$ingresos->render()}}
		</div>
	</div>
@endsection