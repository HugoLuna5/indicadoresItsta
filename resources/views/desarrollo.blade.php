@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{url("/bootstrap-editable/css/bootstrap-editable.css")}}">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Administración de: {{$info->nombre}}
                        <br>
                        <hr>
                        <p align="justify">Calcula: Considerar el total de alumnos egresados de la generación y dividirlos entre el total de alumnos que se inscribieron en la generacion y multiplicarlo por cien.</p>
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            <li class="nav-item active">
                                <a class="nav-link " id="eficencia-tab" data-toggle="tab" href="#eficencia" role="tab" aria-controls="eficencia" aria-selected="true">Eficencia terminal periodos deparados</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " id="eficencia-periodos-tab" data-toggle="tab" href="#eficencia-periodos" role="tab" aria-controls="eficencia-periodos" aria-selected="false">Eficencia terminal ambos periodos</a>
                            </li>

                            <li class="nav-item ">
                                <a class="nav-link " id="titulacion-tab" data-toggle="tab" href="#titulacion" role="tab" aria-controls="titulacion" aria-selected="false">Titulacion por periodo</a>
                            </li>

                            <li class="nav-item ">
                                <a class="nav-link " id="titulacion-ciclo-tab" data-toggle="tab" href="#titulacion-ciclo" role="tab" aria-controls="titulacion-ciclo" aria-selected="false">Titulacion por ciclo</a>
                            </li>



                        </ul>






                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade  in" id="eficencia" role="tabpanel" aria-labelledby="eficencia-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Generacion</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Porcentaje</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @for($i=0;$i < $cont; $i++)

                                        <tr>


                                            <!--
                                            Nombre de la carrera
                                            -->

                                            <th scope="col">
                                                @for($j = 0; $j <= 11; $j++)


                                                        @if($eficiencia[$i]->id_carrera == $carreras[$j]->id)

                                                                {{$carreras[$j]->nombre}}





                                                    @endif


                                                @endfor
                                            </th>


                                            <th scope="col">{{$eficiencia[$i]->generacion}}</th>
                                            <th scope="col">{{$eficiencia[$i]->periodo}}</th>
                                            <th scope="col">

                                                <a href="#"
                                                   data-type="text"
                                                   data-pk="{{$eficiencia[$i]->id}}"
                                                   data-url="{{url("/alumnos/eficiencia/update/")}}/{{$eficiencia[$i]->id}}"
                                                   data-title="Eficiencia"
                                                   data-value="{{$eficiencia[$i]->total}}"
                                                   class="set-eficiencia"
                                                   data-name="total"></a>

                                            </th>


                                            <th scope="col">
                                                @if($i !=($cont-1) && $matricula[0]->total != 0)
                                                    {{round(($eficiencia[$i]->total / $matricula[0]->total) * 100,2)}}

                                                    @elseif($i !=($cont-1) && $matricula[0]->total != 0)
                                                    {{round(($eficiencia[$i+1]->total / $matricula[0]->total) * 100,2)}}
                                                    @else
                                                        faltan datos :(



                                                @endif
                                            </th>

                                            <th scope="col"><a class="btn btn-primary" href="{{url("/eficiencia/periodo/$md5")}}">Generar link</a></th>
                                        </tr>
















                                    @endfor


                                    </tbody>
                                </table>

                            </div>


                            <!--ambos periodos-->

                            <div class="tab-pane fade "   id="eficencia-periodos" role="tabpanel" aria-labelledby="eficencia-periodos-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Generacion</th>
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



                                        @for($j = 0; $j < 12; $j++)

                                            <?php
                                            $auxGen = $var;

                                            $aux = $var;
                                            ?>

                                            @if($i != ($cont / 2))

                                                @if($eficiencia[$var]->id_carrera == $carreras[$j]->id)
                                                    <th scope="col">
                                                        {{$carreras[$j]->nombre}}
                                                    </th>

                                                    <th>{{$eficiencia[$var]->generacion}} - {{$eficiencia[$var+1]->generacion}}</th>


                                                        <th scope="col">
                                                            Ambos periodos


                                                        </th>

                                                    <th scope="col">
                                                        <?php
                                                        $sumaDeserciones = $eficiencia[$var+1]->total + $eficiencia[$var]->total;
                                                        ?>
                                                        {{$sumaDeserciones}}

                                                    </th>

                                                    <th scope="col">

                                                        @if($matricula[0]->total != 0)


                                                            <?php
                                                            $sumaMatricula =  $matricula[0]->total;
                                                            $sumaDeserciones = $eficiencia[$var+1]->total + $eficiencia[$var]->total;
                                                            ?>
                                                            {{round(($sumaDeserciones / $sumaMatricula) * 100,2)}}

                                                        @else
                                                            faltan datos :(
                                                        @endif

                                                    </th>
                                                        <th scope="col"><a class="btn btn-primary" href="{{url("/eficiencia/ciclo/$md5")}}">Generar link</a></th>
                                                        <th scope="col"><a class="btn btn-primary" href="{{url("/eficiencia/evidencias/periodo/")}}/{{$eficiencia[$var]->id_periodo}}-{{$eficiencia[$var+1]->id_periodo}}/{{$carreras[$j]->id}}/{{$md5}}">Subir evidencias</a></th>




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



                            <!--titulacion-->

                            <div class="tab-pane fade active in" id="titulacion" role="tabpanel" aria-labelledby="titulacion-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Total titulados</th>
                                        <th scope="col">Total egresados</th>
                                        <th scope="col">Porcentaje</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @for($i=0;$i < $cont; $i++)

                                        <tr>


                                            <!--
                                            Nombre de la carrera
                                            -->

                                            <th scope="col">
                                                @for($j = 0; $j < 12; $j++)


                                                    @if($titulaciones[$i]->id_carrera == $carreras[$j]->id)

                                                        {{$carreras[$j]->nombre}}





                                                    @endif


                                                @endfor
                                            </th>


                                            <th scope="col">{{$titulaciones[$i]->generacion}}</th>
                                            <th scope="col">

                                                <a href="#"
                                                   data-type="text"
                                                   data-pk="{{$titulaciones[$i]->id}}"
                                                   data-url="{{url("/alumnos/titulacion/update/")}}/{{$eficiencia[$i]->id}}"
                                                   data-title="Titulados"
                                                   data-value="{{$titulaciones[$i]->total}}"
                                                   class="set-titulados"
                                                   data-name="total"></a>

                                            </th>


                                            <th scope="col">

                                                <a href="#"
                                                   data-type="text"
                                                   data-pk="{{$egresadosT[$i]->id}}"
                                                   data-url="{{url("/alumnos/titulacion-egresados/update/")}}/{{$egresadosT[$i]->id}}"
                                                   data-title="Titulados"
                                                   data-value="{{$egresadosT[$i]->total}}"
                                                   class="set-titulados-egresados"
                                                   data-name="total"></a>

                                            </th>




                                            <th scope="col">
                                               @if($egresadosT[$i]->total != 0 && $titulaciones[$i]->total != 0)
                                                    {{round(($titulaciones[$i]->total / $egresadosT[$i]->total) * 100,2)}}


                                                   @else
                                                   Faltan datos
                                                   @endif

                                            </th>

                                            <th scope="col"><a class="btn btn-primary" href="{{url("/eficiencia/periodo/$md5")}}">Generar link</a></th>
                                        </tr>
















                                    @endfor


                                    </tbody>
                                </table>

                            </div>


                            <!--ambos periodos-->



                            <div class="tab-pane fade "   id="titulacion-ciclo" role="tabpanel" aria-labelledby="titulacion-ciclo-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Generacion</th>
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

                                                    @if($titulaciones[$var]->id_carrera == $carreras[$j]->id)
                                                        <th scope="col">
                                                            {{$carreras[$j]->nombre}}
                                                        </th>

                                                        <th scope="col">{{$titulaciones[$var]->generacion}} - {{$titulaciones[$var+1]->generacion}}</th>


                                                        <th scope="col">
                                                            Ambos periodos


                                                        </th>

                                                        <th scope="col">
                                                            <?php
                                                            $sumaTitulaciones = $titulaciones[$var+1]->total + $titulaciones[$var]->total;
                                                            ?>
                                                            {{$sumaTitulaciones}}

                                                        </th>

                                                        <th scope="col">

                                                            @if($matricula[0]->total)


                                                                <?php
                                                                $sumaMatricula =  $matricula[0]->total;
                                                                $sumaDeserciones = $titulaciones[$var+1]->total + $titulaciones[$var]->total;
                                                                ?>
                                                                {{round(($sumaTitulaciones / $sumaMatricula) * 100,2)}}

                                                            @else
                                                                faltan datos :(
                                                            @endif

                                                        </th>
                                                        <th scope="col"><a class="btn btn-primary" href="{{url("/titulacion/ciclo/$md5")}}">Generar link</a></th>
                                                        <th scope="col"><a class="btn btn-primary" href="{{url("/titulacion/evidencias/periodo/")}}/{{$titulaciones[$var]->id_periodo}}-{{$titulaciones[$var+1]->id_periodo}}/{{$carreras[$j]->id}}/{{$md5}}">Subir evidencias</a></th>

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


                            <center>{{$eficiencia->links()}}</center>

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
        $(".set-eficiencia").editable();
        $(".set-titulados").editable();
        $(".set-titulados-egresados").editable();




    </script>
@endsection
