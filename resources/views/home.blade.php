@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{url("/bootstrap-editable/css/bootstrap-editable.css")}}">

    <div class="container">
    <div class="row">
        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-heading">Administración de: {{$info->nombre}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            <li class="nav-item active">
                                <a class="nav-link" id="reprobacion-tab" data-toggle="tab" href="#reprobacion" role="tab" aria-controls="reprobacion" aria-selected="true">Reprobación</a>
                            </li>



                        </ul>






                        <div class="tab-content" id="myTabContent">


                            <div class="tab-pane fade active in" id="reprobacion" role="tabpanel" aria-labelledby="reprobacion-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Materia</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Total Reprobados</th>
                                        <th scope="col">Total Materia</th>
                                        <th scope="col">Porcentaje</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=0;$i<count($reprobados);$i++)

                                        <th scope="col">
                                            {{$materias[$i]->nombre}}
                                        </th>

                                        @foreach($periodos as $periodo)
                                            @if($periodo->id == $reprobados[$i]->id_periodo)
                                            <th scope="col">

                                                {{$periodo->periodo}}

                                            </th>
                                            @endif
                                            @endforeach

                                        <th scope="col">
                                            {{$reprobados[$i]->totalRepro}}
                                        </th>
                                        <th scope="col">
                                            {{$reprobados[$i]->totalMat}}
                                        </th>



                                        <th scope="col">

                                            @if($reprobados[$i]->totalRepro != 0)
                                                {{($reprobados[$i]->totalRepro / $reprobados[$i]->totalMat) * 100}}
                                                @else
                                                Faltan datos
                                            @endif

                                        </th>

                                        <th scope="col">

                                            <a class="btn btn-primary" href="{{url("/reprobacion/periodo/$md5")}}">Generar link</a>
                                        <th scope="col"><a class="btn btn-primary" href="{{url("/reprobacion/evidencias/periodo/")}}{{$reprobados[$i]->id_periodo}}-{{$reprobados[$i]->id}}/{{$md5}}">Subir evidencias</a></th>
                                        </th>



                                    @endfor

                                    </tbody>
                                </table>


                            </div>






                        </div>


                </div>
            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">


                <div class="panel-heading">
                    Agregar datos
                </div>

                <div class="panel-body">


                    <form action="{{url("/jefe/agregar/materia")}}" method="POST" role="form">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="nombre">Nombre de la materia</label>
                            <input required id="nombre" name="nombre" class="form-control" type="text" placeholder="Nombre de la materia">


                        </div>

                        <div class="form-group">
                            <label for="periodo">Periodo</label>
                            <select name="periodo" id="periodo" class="form-control">
                                @foreach($periodos as $periodo)
                                    <option value="{{$periodo->id}}">{{$periodo->periodo}}</option>
                                    @endforeach
                            </select>

                        </div>


                        <button style="float: right" type="submit" class="btn btn-primary">Agregar</button>




                    </form>



                </div>

            </div>


        </div>
    </div>
</div>

<script src="{{url("/js/jquery.min.js")}}"></script>
    <script src="{{url("/bootstrap-editable/js/bootstrap-editable.min.js")}}"></script>


<script>
    $.fn.editable.defaults.mode = 'inline';

    $.fn.editable.defaults.ajaxOptions = {type: 'PUT'};
    $(".set-cantidad").editable();
    $(".set-desercion").editable();
    $(".set-matricula").editable();
    $(".set-reprobados").editable();
    $(".set-eficiencia").editable();
    $(".set-titulacion").editable();




</script>
@endsection
