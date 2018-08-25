<?php

namespace App\Http\Controllers;

use App\model\Carrera;
use App\model\Desercion;
use App\model\Eficiencia;
use App\model\EgresadosT;
use App\model\Evidencias;
use App\model\Link;
use App\model\Materia;
use App\model\Matricula;
use App\model\Periodo;
use App\model\Reprobacion;
use App\model\Titulacion;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use Dropbox\Client;
use Dropbox\WriteMode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $md5 = md5(date("Y-m-d"));
        if (Auth::user()->rol == "admin") {//administrador

            return redirect("/administrador");

        } elseif (Auth::user()->rol == "jefe") {//jefe de carrera


            $info = DB::table('carreras')->where('id', Auth::user()->carrera)->first();

            $carreras = Carrera::where('id', Auth::user()->carrera)->first();
            $reprobados = Reprobacion::where('id_carrera', Auth::user()->carrera)->get();
            $materias = Materia::where('id_carrera', Auth::user()->carrera)->get();
            $periodos = Periodo::all();


            return view('home', compact('info', 'carreras', 'reprobados', 'periodos', 'md5', 'materias'));

        } elseif (Auth::user()->rol == "servEsc") {//servicios escolares
            $info = DB::table('carreras')->where('id', Auth::user()->carrera)->first();
            $carreras = Carrera::all();
            $matricula = Matricula::paginate(1);
            $deserciones = Desercion::all();
            $cont = 22;


            $periodos = Periodo::all();
            $contador = 0;

            return view('servicios', compact('info', 'carreras', 'matricula', 'deserciones', 'periodos', 'md5', 'cont', 'contador'));


        } else {//desarrollo academico
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


        }


    }


    public function updateDesercion(Request $request, $id)
    {
        $desercion = Desercion::find($id);

        $field = $request->name;

        $desercion->total = $request->value;

        $desercion->save();


        return $desercion->total;
    }

    public function updateEficiencia(Request $request, $id)
    {
        $eficiencia = Eficiencia::find($id);

        $field = $request->name;

        $eficiencia->$field = $request->value;

        $eficiencia->save();


        return $eficiencia->$field;
    }


    public function updateTitulacion(Request $request, $id)
    {


        $titulacion = Titulacion::find($id);

        $field = $request->name;

        $titulacion->$field = $request->value;

        $titulacion->save();

        return $titulacion->$field;

    }

    public function updateTitulacionEgre(Request $request, $id)
    {


        

        $titulacion = EgresadosT::find($id);

        $field = $request->name;

        $titulacion->$field = $request->value;

        $titulacion->save();

        return $titulacion->$field;

    }


    public function addMateria(Request $request)
    {
        $admin = Auth::user()->name . " " . Auth::user()->apellido_paterno . " " . Auth::user()->apellido_materno;


        $materia = new Materia();
        $materia->id_periodo = $request->periodo;
        $materia->id_carrera = Auth::user()->carrera;
        $materia->nombre = $request->nombre;
        $materia->admin = $admin;
        $materia->save();


        $reprobacion = new Reprobacion();

        $reprobacion->id_carrera = Auth::user()->carrera;
        $reprobacion->id_periodo = $request->periodo;
        //$reprobacion->id_materia = $materia->id;
        $reprobacion->totalRepro = 0;
        $reprobacion->totalMat = 0;
        $reprobacion->save();

        return back();


    }


    /**
     * view evidencias
     */

    public function uploadView($tipo, $periodo, $carrera, $md5)
    {

        $evidencias = Evidencias::where('id_carrera',$carrera)->get();

        return view('upload.index', compact('periodo', 'carrera', 'md5', 'tipo','evidencias'));
    }


    /**
     * upload files
     */


    public function uploadFile(Request $request)
    {
        $files = $request->file('file');
        $tipo = $request->tipo;


        //printf($files);
        $periodos = explode("-", $request->periodo);


        $consulta1 = Periodo::find($periodos[0]);
        $consulta2 = Periodo::find($periodos[1]);

        $per = $consulta1->periodo . "_" . $consulta2->periodo;

        for ($i = 0; $i < count($files); $i++) {

            $file = $files[$i];
            $cod = md5(time() . date("Y-m-d") . $file->getClientOriginalName());

            $extension = $file->getClientOriginalExtension();


            $archivo = $cod . "." . $extension;
            $ruta = $per."/".$request->carrera."/".$request->tipo."/" . $archivo;

            \Storage::disk('evidencias')->put($ruta, \File::get($file));


            $evidencias = new Evidencias();
            $evidencias->id_carrera = $request->carrera;
            $evidencias->ciclo = $request->periodo;


            $extension = $file->getClientOriginalExtension();

            $evidencias->archivo = $archivo;
            $evidencias->nombre_original = $file->getClientOriginalName();
            $evidencias->admin = Auth::user()->name;
            $evidencias->save();


        }


        /*
                return \Response::json([
                    'message' => 'Image saved Successfully'
                ], 200);

        */
        return response()->json(['success' => "success"]);

    }





    public function dropboxFileUpload()
    {



        error_reporting(E_ALL);
        ini_set('display_errors', 1);


        require_once("/mediafire/mflib.php");


        $appId = "";
        $apiKey = "";
        $email = "hugo_1199@hotmail.com";
        $password = "";



        $mflib = new mflib($appId, $apiKey);
        $mflib->email    = $email;
        $mflib->password = $password;
        $token = $mflib->userGetSessionToken(null);


        $uploadkey = $mflib->fileUpload($token, $_FILES["file"]["tmp_name"],"myfiles",$_FILES["file"]["name"]);
        $fileDetails = $mflib->filePollUpload($token, $uploadkey);
        $link = $mflib->fileGetLinks($fileDetails['quickkey'], "direct_download", $token);


        print_r($link);

    }


    public function linkDesercion(){

        $link = new Link();
        $link->url = md5(time().date("Y-m-d")."matricula");
        $link->caducidad = Carbon::today()->addWeek(2);
        $link->creado = Auth::user()->name;
        $link->save();

        $ur = "/desercion/link-compartido/".$link->url;
        return redirect($ur);
    }

    public function linkReprobados(){


        $link = new Link();
        $link->url = md5(time().date("Y-m-d")."matricula");
        $link->caducidad = Carbon::today()->addWeek(2);
        $link->creado = Auth::user()->name;
        $link->save();

        $ur = "/reprobados/link-compartido/".$link->url;
        return redirect($ur);
    }
    public function linkEficiencia(){



        $link = new Link();
        $link->url = md5(time().date("Y-m-d")."matricula");
        $link->caducidad = Carbon::today()->addWeek(2);
        $link->creado = Auth::user()->name;
        $link->save();

        $ur = "/eficiencia/link-compartido/".$link->url;
        return redirect($ur);
    }
    public function linkTitulacion(){


        $link = new Link();
        $link->url = md5(time().date("Y-m-d")."matricula");
        $link->caducidad = Carbon::today()->addWeek(2);
        $link->creado = Auth::user()->name;
        $link->save();

        $ur = "/titulacion/link-compartido/".$link->url;
        return redirect($ur);
    }

    public function linkMatricula(){


        $link = new Link();
        $link->url = md5(time().date("Y-m-d")."matricula");
        $link->caducidad = Carbon::today()->addWeek(2);
        $link->creado = Auth::user()->name;
        $link->save();

        $ur = "/matricula/link-compartido/".$link->url;
        return redirect($ur);
    }

}
