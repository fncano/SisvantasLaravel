@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Cliente: {{$persona->nombre}}</h3>
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

			{!! Form::model($persona,['method'=>'PATCH','route'=>['proveedor.update',$persona->idpersona]])!!}
			{{Form::token()}}

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="nombre">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="direccion">Direccion</label>
          <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="direccion">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
				<label for="tipodocumento">Documento</label>
				<select name="tipodocumento" class="form-control" id="" placeholder="seleccione uno">
					@if($persona->tipodocumento=='C.C')
						<option value="C.C" selected>Cedula Ciudadania</option>
						<option value="RUT">RUT</option>
						<option value="C.E">Cedula Extrangera</option>
						<option value="PAS">Pasaporte</option>
					@elseif($persona->tipodocumento=='RUT')
						<option value="C.C">Cedula Ciudadania</option>
						<option value="RUT" selected>RUT</option>
						<option value="C.E">Cedula Extrangera</option>
						<option value="PAS">Pasaporte</option>
					@elseif($persona->tipodocumento=='C.E')
						<option value="C.C">Cedula Ciudadania</option>
						<option value="RUT">RUT</option>
						<option value="C.E" selected>Cedula Extrangera</option>
						<option value="PAS">Pasaporte</option>
					@else
						<option value="C.C">Cedula Ciudadania</option>
						<option value="RUT">RUT</option>
						<option value="C.E">Cedula Extrangera</option>
						<option value="PAS" selected>Pasaporte</option>
					@endif
				</select>
			</div>	
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="numdocumento">Numero</label>
          <input type="text" name="numdocumento" value="{{$persona->numdocumento}}" class="form-control" placeholder="numdocumento">
      </div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="telefono">
      </div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 colsx-12">
			<div class="form-group">
          <label for="email">Correo electronico</label>
          <input type="email" name="email"  value="{{$persona->email}}" class="form-control" placeholder="email">
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