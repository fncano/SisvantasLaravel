@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>nuevo Proveedor</h3>
			@if(count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach	
				</ul>
			</div>
			@endif
		</div>	
	</div>
			{!! Form::open(array('url'=>'compras/proveedor','method'=>'POST','autocomplete'=>'off')) !!}
			{{Form::token()}}


	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="nombre">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="direccion">Direccion</label>
          <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="direccion">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
				<label for="tipodocumento">Documento</label>
				<select name="tipodocumento" class="form-control" id="" placeholder="seleccione uno">
						<option></option>
						<option value="C.C">Cedula Ciudadania</option>
						<option value="RUT">RUT</option>
						<option value="C.E">Cedula Extrangera</option>
						<option value="PAS">Pasaporte</option>
				</select>
			</div>	
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="numdocumento">Numero</label>
          <input type="text" name="numdocumento" value="{{old('numdocumento')}}" class="form-control" placeholder="numdocumento">
      </div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="telefono">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="email">Correo electronico</label>
          <input type="email" name="email"  value="{{old('email')}}" class="form-control" placeholder="email">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-warning" type="reset">Cancelar</button>
      </div>
		</div>
	</div>
        
			{{Form::close()}}
@endsection