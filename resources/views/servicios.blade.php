@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{url("/bootstrap-editable/css/bootstrap-editable.css")}}">

    <div class="container">

        <center><h3>Bienvenidos <br>Indicadores Institucionales Básicos <br>ITSTA</h3></center>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Administración de: {{$info->nombre}}<br>
                        <hr>
                    <p>Calculo: Total de alumnos dados de baja definitiva y dividirlos entre el total de alumnos matriculados y multiplicarlos por cien</p>
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item active ">
                                <a class="nav-link " id="desercion-tab" data-toggle="tab" href="#desercion" role="tab" aria-controls="desercion" aria-selected="true">Deserción por periodo</a>
                            </li>

                            <li class="nav-item  ">
                                <a class="nav-link " id="desercion-ciclo-tab" data-toggle="tab" href="#desercion-ciclo" role="tab" aria-controls="desercion-ciclo" >Deserción por ciclo</a>
                            </li>




                        </ul>






                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade active in"   id="desercion" role="tabpanel" aria-labelledby="desercion-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Porcentaje</th>
                                        <th scope="col">Acciones</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @for($i=0;$i < count($deserciones); $i++)
                                        <tr>

                                            <!--Mostrar nombre de la carrera-->

                                            @foreach($carreras as $carrera)
                                                @if($carrera->id == $deserciones[$i]->id_carrera)


                                                    <th scope="col">{{$carrera->nombre}}</th>

                                                @endif
                                            @endforeach

                                            @foreach($periodos as $periodo)
                                                @if($periodo->id == $deserciones[$i]->id_periodo)
                                                <th scope="col">{{$periodo->periodo}}</th>
                                                @endif
                                            @endforeach


                                            <th scope="col">
                                                <a href="#"
                                                   data-type="text"
                                                   data-pk="{{$deserciones[$i]->id}}"
                                                   data-url="{{url("/alumnos/desercion/update/")}}/{{$deserciones[$i]->id}}"
                                                   data-title="Alumnos"
                                                   data-value="{{$deserciones[$i]->total}}"
                                                   class="set-desercion"
                                                   data-name="total"></a>
                                            </th>






                                            @if($matricula[0]->total != 0)
                                                <th scope="col">
                                        {{round(($deserciones[$i]->total / $matricula[0]->total) * 100,2)}}
                                                </th>
                                        @else
                                            <th scope="col">0</th>
                                        @endif
                                            <td scope="col"><a class="btn btn-primary" href="{{url("/desercion/periodo/$md5")}}">Generar link</a>



                                    @endfor




                                    </tbody>
                                </table>







                            </div>

                            <!--desercion por ciclo-->






                            <div class="tab-pane fade "   id="desercion-ciclo" role="tabpanel" aria-labelledby="desercion-ciclo-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Porcentaje</th>
                                        <th scope="col">Acciones</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @for($var = 0; $var<$cont;$var++)

                                        <?php
                                        $res1 = $var;
                                        ?>
                                        <tr>



                                            @for($j = 0; $j <= 11; $j++)

                                                <?php
                                                $auxGen = $var;

                                                $aux = $var;
                                                ?>

                                                @if($i != ($cont / 2))

                                                    @if($deserciones[$var]->id_carrera == $carreras[$j]->id)
                                                        <th scope="col">
                                                            {{$carreras[$j]->nombre}}
                                                        </th>



                                                        <th scope="col">
                                                            Ambos periodos


                                                        </th>

                                                        <th scope="col">
                                                            <?php
                                                            $sumaTitulaciones = $deserciones[$var+1]->total + $deserciones[$var]->total;
                                                            ?>
                                                            {{$sumaTitulaciones}}

                                                        </th>

                                                        <th scope="col">

                                                            @if($matricula[0]->total)


                                                                <?php
                                                                $sumaMatricula = $matricula[0]->total;
                                                                $sumaDeserciones = $deserciones[$var+1]->total + $deserciones[$var]->total;
                                                                ?>
                                                                {{round(($sumaTitulaciones / $sumaMatricula) * 100,2)}}

                                                            @else
                                                                faltan datos :(
                                                            @endif

                                                        </th>
                                                        <th scope="col"><a class="btn btn-primary" href="{{url("/desercion/ciclo/$md5")}}">Generar link</a></th>
                                                        <th scope="col"><a class="btn btn-primary" href="{{url("/desercion/evidencias/periodo/")}}/{{$deserciones[$var]->id_periodo}}-{{$deserciones[$var+1]->id_periodo}}/{{$carreras[$j]->id}}/{{$md5}}">Subir evidencias</a></th>

                                                    <?php

                                                    $var = $var +1;
                                                    ?>

                                                @endif


                                            @endif


                                        @endfor



                                        <!--
                                                    Periodo de la carrera
                                                -->





                                            <!--
                                                total
                                                -->



                                        </tr>



                                    @endfor





                                    </tbody>
                                </table>








                            </div>

                        </div>




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
        $(".set-desercion").editable();





    </script>
@endsection
