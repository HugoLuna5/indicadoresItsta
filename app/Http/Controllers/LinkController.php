<?php

namespace App\Http\Controllers;

use App\model\Carrera;
use App\model\Desercion;
use App\model\Eficencia;
use App\model\Eficiencia;
use App\model\EgresadosT;
use App\model\Link;
use App\model\Matricula;
use App\model\Periodo;
use App\model\Reprobacion;
use App\model\Titulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class LinkController extends Controller
{
    //

    public function linkCompartidoDesercion($code){

        $this->deleteLink();

        $consultas  = DB::table('links')->where('url',$code)->first();

        if ($consultas != null){
            $md5 = md5(date("Y-m-d"));
            $info = DB::table('carreras')->where('id', Auth::user()->carrera)->first();
            $carreras = Carrera::all();
            $matricula = Matricula::paginate(1);
            $deserciones = Desercion::all();
            $cont = 22;


            $periodos = Periodo::all();
            $contador = 0;

            return view('servicios', compact('info', 'carreras', 'matricula', 'deserciones', 'periodos', 'md5', 'cont', 'contador'));


        }else{
            return  back();
        }


    }


    public function linkCompartidoReprobados($code){

        $this->deleteLink();
        $consultas  = DB::table('links')->where('url',$code)->first();

        if ($consultas != null){
            return "No disponible";
        }else{
            return  back();
        }


    }

    public function linkCompartidoEficiencia($code){

        $this->deleteLink();
        $consultas  = DB::table('links')->where('url',$code)->first();

        if ($consultas != null){
            $md5 = md5(date("Y-m-d"));
            $info = DB::table('carreras')->where('id', Auth::user()->carrera)->first();
            $carreras = Carrera::all();
            $matricula = Matricula::paginate(1);
            $eficiencia = Eficiencia::paginate(24);
            $cont = 24;
            $titulaciones = Titulacion::paginate(24);
            $egresadosT = EgresadosT::paginate(24);


            $periodos = Periodo::all();
            $contador = 0;
            return view('desarrollo', compact('info', 'carreras', 'matricula', 'eficiencia', 'periodos', 'md5', 'cont', 'contador', 'titulaciones', 'egresadosT'));
        }else{
            return  back();
        }


    }

    public function linkCompartidoTitulacion($code){

        $this->deleteLink();
        $consultas  = DB::table('links')->where('url',$code)->first();

        if ($consultas != null){
            $md5 = md5(date("Y-m-d"));
            $info = DB::table('carreras')->where('id', Auth::user()->carrera)->first();
            $carreras = Carrera::all();
            $matricula = Matricula::paginate(1);
            $eficiencia = Eficiencia::paginate(24);
            $cont = 24;
            $titulaciones = Titulacion::paginate(24);
            $egresadosT = EgresadosT::paginate(24);


            $periodos = Periodo::all();
            $contador = 0;
            return view('desarrollo', compact('info', 'carreras', 'matricula', 'eficiencia', 'periodos', 'md5', 'cont', 'contador', 'titulaciones', 'egresadosT'));
        }else{
            return  back();
        }


    }

    public function deleteLink(){

        $links = Link::all();

        foreach ($links as $link){

            if ($link->caducidad <= date("Y-m-d")){

                DB::table('links')->where('id',$link->id)->delete();
            }

        }

    }
}
