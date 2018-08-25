@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Registrarte</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre</label>

                                <div class="col-md-6">
                                    <input placeholder="Escribe tu nombre" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="apellido_paterno" class="col-md-4 control-label">Apellido P</label>

                                <div class="col-md-6">
                                    <input placeholder="Escribe tu apellido paterno" id="apellido_paterno" type="text" class="form-control" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autofocus>

                                    @if ($errors->has('apellido_paterno'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="apellido_materno" class="col-md-4 control-label">Apellido M</label>

                                <div class="col-md-6">
                                    <input placeholder="Escribe tu apellido materno" id="apellido_materno" type="text" class="form-control" name="apellido_materno" value="{{ old('apellido_materno') }}" required autofocus>

                                    @if ($errors->has('apellido_materno'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('apellido_materno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Correo electronico</label>

                                <div class="col-md-6">
                                    <input placeholder="Escribe tu correo electronico" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="carrera" class="col-md-4 control-label">Departamento</label>

                                <div class="col-md-6">

                                    <select class="form-control" name="carrera" id="carrera">
                                        <option value="1">INGENIERIA EN AGRONOMIA</option>
                                        <option value="2">INGENIERIA  ELECTRONICA</option>
                                        <option value="3">INGENIERIA INDUSTRIAL</option>
                                        <option value="4">INGENIERIA EN SISTEMAS COMPUTACIONALES</option>
                                        <option value="5">INGENIERIA EN GESTION EMPRESARIAL</option>
                                        <option value="6">INGENIERIA PETROLERA</option>
                                        <option value="7">CONTADOR PUBLICO</option>
                                        <option value="8">MAESTRIA EN INGENIERÍA INDUSTRIAL</option>
                                        <option value="9">INGENIERIA AMBIENTAL</option>
                                        <option value="10">MAESTRIA EN AGROBIOTECNOLOGIA</option>
                                        <option value="11">INGENIERIA MECATRÓNICA</option>
                                        <option value="12">MAESTRIA EN PRODUCCION PECUARIA TROPICAL</option>
                                        <option value="13">SERVICIOS ESCOLARES</option>
                                        <option value="14">DESARROLLO ACADEMICO</option>
                                    </select>


                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Contraseña</label>

                                <div class="col-md-6">
                                    <input placeholder="Escribe tu contraseña" id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                                <div class="col-md-6">
                                    <input placeholder="Confirma tu contraseña" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Registrarte
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
