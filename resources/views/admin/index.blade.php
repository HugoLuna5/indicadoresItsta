@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{url("/bootstrap-editable/css/bootstrap-editable.css")}}">

    <div class="container">

        <center><h3>Bienvenidos <br>Indicadores Institucionales Básicos <br>ITSTA</h3></center>



        <div class="row">

            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">Administrar periodos</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif


                            <div class="form-inline">
                                <label for="ago">Agosto</label>
                                <input required class="form-control" type="text" id="ago" placeholder="Escribe tu año del periodo">
                                <label for="ene" style="margin-left: 10px;">Enero</label>
                                <input required class="form-control" type="text" id="ene" placeholder="Escribe tu año del periodo">




                            </div>

                        <div id="more" class="form-inline" style="margin-top: 20px;display: none;" >
                            <label for='feb-jul'>Feb-Jul</label>
                            <input required class='form-control' type='text' id='feb-jul' placeholder='Escribe tu año del periodo' disabled  style="margin-left: 5px">


                            <div id="btn" class="form-inline">
                                <center>

                                    <h4>Realmente desea agregar este periodo</h4>
                                    <button id="agregar" class="btn btn-success">Agregar</button>
                                    <button id="eliminar" class="btn btn-danger">Eliminar</button>

                                </center>
                            </div>

                        </div>

                        <div  class="form-inline" style="margin-top: 40px">
                            <br>
                            <br>
                            <br>
                                <button id="add-periodo" class="btn btn-success">Agregar periodo</button>
                        </div>




                    </div>
                </div>



                <div class="panel panel-default">
                    <div class="panel-heading">Administrar usuarios</div>

                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Carrera</th>
                                <th scope="col">Acciones</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($usuarios as $usuario)
                                <tr>
                                <th scope="col">{{$usuario->name." ".$usuario->apellido_paterno." ".$usuario->apellido_materno}}</th>
                                <th scope="col">{{$usuario->carrera}}</th>
                                <th scope="col">





                                    @if(Auth::user()->rol == "admin")


                                        <a href="#"
                                           data-type="select"
                                           data-pk="admin"
                                           data-url="{{url("/administrador/update-rol/$usuario->id")}}"
                                           data-title="Rol de usuario"
                                           data-value="{{$usuario->rol}}"
                                           class="rol"
                                           data-name="rol"></a>




                                    @elseif(Auth::user()->rol == "jefe")
                                        <a href="#"
                                           data-type="select"
                                           data-pk="jefe"
                                           data-url="{{url("/administrador/update-rol/$usuario->id")}}"
                                           data-title="Rol de usuario"
                                           data-value="{{$usuario->rol}}"
                                           class="rol"
                                           data-name="rol"></a>

                                    @elseif(Auth::user()->rol == "servEsc")
                                        <a href="#"
                                           data-type="select"
                                           data-pk="servEsc"
                                           data-url="{{url("/administrador/update-rol/$usuario->id")}}"
                                           data-title="Rol de usuario"
                                           data-value="{{$usuario->rol}}"
                                           class="rol"
                                           data-name="rol"></a>



                                    @elseif(Auth::user()->rol == "desAcade")
                                        <a href="#"
                                           data-type="select"
                                           data-pk="desAcade"
                                           data-url="{{url("/administrador/update-rol/$usuario->id")}}"
                                           data-title="Rol de usuario"
                                           data-value="{{$usuario->rol}}"
                                           class="rol"
                                           data-name="rol"></a>
                                    @endif



                                </th>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-5">

                <div class="panel panel-default">
                    <div class="panel-heading">Administrar periodos</div>

                    <div class="panel-body">

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Periodo</th>
                                <th scope="col">Estado</th>

                            </tr>
                            </thead>
                            <tbody id="bodyTablePeriodo">
                            @foreach($periodos as $periodo)
                                <tr>
                                    <th scope="col">{{$periodo->id}}</th>
                                    <th scope="col">{{$periodo->periodo}}</th>
                                    <th scope="col">

                                        @if($periodo->status == "activado")

                                            <a href="#"
                                               data-type="select"
                                               data-pk="activado"
                                               data-url="{{url("/administrador/update-status/$periodo->id")}}"
                                               data-title="Estado"
                                               data-value="{{$periodo->status}}"
                                               class="status"
                                               data-name="status"></a>


                                        @elseif($periodo->status == "desactivado")

                                            <a href="#"
                                               data-type="select"
                                               data-pk="desactivado"
                                               data-url="{{url("/administrador/update-status/$periodo->id")}}"
                                               data-title="Estado"
                                               data-value="{{$periodo->status}}"
                                               class="status"
                                               data-name="status"></a>

                                            @endif

                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>




                    <div class="panel panel-default">

                        <div class="panel-heading">
                            Administrar matricula
                        </div>

                        <div class="panel-body">

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Ciclo</th>
                                    <th scope="col">Total</th>

                                </tr>
                                </thead>
                                <tbody id="bodyTablePeriodo">




                                @foreach($matricula as $m)
                                    <tr>
                                        <th scope="col">{{$m->id}}</th>
                                        <th scope="col">{{$m->periodo}}</th>
                                        <th scope="col">



                                                <a href="#"
                                                   data-type="text"
                                                   data-pk="{{$m->total}}"
                                                   data-url="{{url("/administrador/update-status-matricula/$m->id")}}"
                                                   data-title="matricula"
                                                   data-value="{{$m->total}}"
                                                   class="matricula"
                                                   data-name="matricula"></a>




                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>




            </div>




            </div>
        </div>
    </div>


    <script src="{{url("/js/sweetalert.min.js")}}"></script>

    <script src="{{url("/js/jquery.min.js")}}"></script>
    <script src="{{url("/js/post-ajax.js")}}"></script>
    <script src="{{url("/bootstrap-editable/js/bootstrap-editable.min.js")}}"></script>


    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.ajaxOptions = {type: 'PUT'};

        $(document).ready(function() {


            $(".rol").editable({
                source: [
                    {
                        value: "jefe", text: "Jefe de carrera"
                    },
                    {
                        value: "admin", text: "Administrador"
                    },
                    {
                        value: "servEsc", text: "Servicios escolares"
                    },
                    {
                        value: "desAcade", text: "Desarrollo academico"
                    }

                ]


            });

            $(".matricula").editable();
            $(".status").editable({
                source: [
                    {
                        value: "activado", text: "Activado"
                    },
                    {
                        value: "desactivado", text: "Desactivado"
                    }

                ]


            });


        });

    </script>



@endsection
