@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 colsx-12">
			<div class="form-group">
          <label for="proveedor">Cliente</label>
          <p>{{$venta->nombre}}</p>
      </div>
		</div>

		
		<div class="col-lg-4 col-md-4 col-sm-4 colsx-12">
			<div class="form-group">
				<label for="tipocomprobante">Tipo Comprobante</label>
				<p>{{$venta->tipocomprobante}}</p>
			</div>	
		</div>

		<div class="col-lg-4 col-md-4 col-sm-4 colsx-12">
			<div class="form-group">
          <label for="seriecomprobante">Serie compro.</label>
          <p>{{$venta->seriecomprobante}}</p>
      </div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 colsx-12">
			<div class="form-group">
          <label for="numcomprobante">numero compro.</label>
          <p>{{$venta->numcomprobante}}</p>
      </div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color: #a9d0f5">
							<th>Articulo</th>
							<th>Cantidad</th>
							<th>P. venta</th>
							<th>Descuento</th>
							<th>subtotal</th>
						</thead>
						<tfoot>
							<th>TOTAL</th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">{{$venta->totalventa}}</h4></th>
						</tfoot>
						<tbody>
							@foreach($detalles as $det)
							<tr>
								<td>{{$det->articulo}}</td>
								<td>{{$det->cantidad}}</td>
								<td>{{$det->precioventa}}</td>
								<td>{{$det->descuento}}</td>
								<td>{{$det->cantidad*$det->precioventa-$det->descuento}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>		
	</div>
        

@endsection