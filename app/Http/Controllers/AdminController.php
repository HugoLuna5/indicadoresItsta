<?php

namespace App\Http\Controllers;

use App\model\Carrera;
use App\model\Desercion;
use App\model\Eficiencia;
use App\model\EgresadosT;
use App\model\Matricula;
use App\model\Periodo;
use App\model\Titulacion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use League\Flysystem\Config;

class AdminController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if(Auth::user()->rol != "admin"){
            return redirect("/home");

        }
        $usuarios = User::all();
        $periodos = Periodo::all();
        $matricula = Matricula::all();
        $carreras = Carrera::paginate(12);


        return view('admin.index',compact('usuarios','periodos','matricula','carreras'));
    }

    public function updateRol(Request $request, $id){


        $usuario = User::find($id);

        $field = $request->rol;

        $usuario->rol = $request->value;

        $usuario->save();

        return $usuario->$field;

    }

    public function updateStatus(Request $request, $id){


        $periodo = Periodo::find($id);

        $field = $request->status;

        $periodo->status = $request->value;

        $periodo->save();

        return $periodo->$field;

    }

    public function updateMatricula(Request $request, $id){
        $matricula = Matricula::find($id);


        //$field = $request->matricula;

        $matricula->total = $request->value;
        $matricula->save();

        return $matricula->total;
    }



    public function addPeriodo(Request $request){
        $periodoAgoEne = "AGO".$request->varAgo."-ENE".$request->varEne;
        $periodoFebJul = "FEB".$request->varFebJul."-JUL".$request->varFebJul;
        $admin = Auth::user()->name." ".Auth::user()->apellido_paterno." ".Auth::user()->apellido_materno;

        /**
         * Crear periodo AGO - ENE
         */
        $periodo = new Periodo();
        $periodo->periodo = $periodoAgoEne;
        $periodo->admin = $admin;
        $periodo->status = "desactivado";
        $periodo->save();


        /**
         * Crear periodo FEB - JUL
         */

        $periodo2 = new Periodo();
        $periodo2->periodo = $periodoFebJul;
        $periodo2->admin = $admin;
        $periodo2->status = "desactivado";
        $periodo2->save();
        /**
         * Crear matricula, desercion, titulacion, reprobacion, titulacion, eficiencia
         * Sucede cuando se agrega un nuevo periodo
         */

        $per = explode('-',$periodoAgoEne);
        $per2 = explode('-',$periodoFebJul);
        $first_per = $per[0];
        $second_per = $per2[0];

        $this->addMatricula($periodoAgoEne,$periodoFebJul,$admin);
        $this->addFolderEvidencia($periodoAgoEne,$periodoFebJul);
        $this->addDesercion($periodo->id,$periodo2->id);
        $this->addEficiencia($first_per,$periodo->id,$periodo2->id,$second_per);
        $this->addTitulacion($periodoAgoEne,$periodo->id,$periodo2->id,$periodoFebJul);





            if ($request->json()){
                return response()->json(['success' => 'Periodos '.$periodoAgoEne.' '.$periodoFebJul.' registrados exitosamente.']);
            }


    }


    public function addFolderEvidencia($periodoAgoEne,$periodoFebJul){


        $carpeta = $periodoAgoEne."_".$periodoFebJul;

        for ($i = 1;$i<=12;$i++){
            Storage::disk('evidencias')->put("/$carpeta/$i/create.txt",  "Crear archivo");
            Storage::disk('evidencias')->put("/$carpeta/$i/titulacion/create.txt",  "titulacion");
            Storage::disk('evidencias')->put("/$carpeta/$i/desercion/create.txt",  "desercion");
            Storage::disk('evidencias')->put("/$carpeta/$i/reprobacion/create.txt",  "reprobacion");
            Storage::disk('evidencias')->put("/$carpeta/$i/eficiencia/create.txt",  "eficiencia");
        }

    }

    /**
     * Create enrollment
     * @param $periodoAgoEne
     * @param $periodoFebJul
     * @param $admin
     */
    public function addMatricula($periodoAgoEne,$periodoFebJul,$admin){



            /**
             * Matricula para el periodo Agosto - Enero
             */
            $matriculaAgoEne = new Matricula();
            $matriculaAgoEne->total = 0;
            $matriculaAgoEne->periodo = $periodoAgoEne."_".$periodoFebJul;
            $matriculaAgoEne->admin = $admin;
            $matriculaAgoEne->save();

            /**
             * Matricula para el periodo Febrero - Julio
             */



    }

    /**
     * Create the period of desertion
     * @param $id_periodoAgoEne
     * @param $id_periodoFebJul
     */
    public function addDesercion($id_periodoAgoEne, $id_periodoFebJul){
        for($i=0; $i <=11; $i++){

            /**
             * Desercion para periodo Agosto - Enero
             */
            $desercionAgoEne = new Desercion();
            $desercionAgoEne->id_carrera = ($i + 1);
            $desercionAgoEne->id_periodo = $id_periodoAgoEne;
            $desercionAgoEne->total = 0;
            $desercionAgoEne->save();



            /**
             * Desercion para periodo Febrero - Julio
             */
            $desercionFebJul = new Desercion();
            $desercionFebJul->id_carrera = ($i + 1);
            $desercionFebJul->id_periodo = $id_periodoFebJul;
            $desercionFebJul->total = 0;
            $desercionFebJul->save();
        }



    }


    /**
     * Create the eficence
     * @param $periodoAgo
     * @param $id_periodoAgoEne
     * @param $id_periodoFebJul
     * @param $second_per
     */
    public function addEficiencia($periodoAgo,$id_periodoAgoEne,$id_periodoFebJul,$second_per){
        for($i=0; $i <=11; $i++) {
            $eficiencia1 = new Eficiencia();
            $eficiencia1->id_carrera = ($i+1);
            $eficiencia1->id_periodo = $id_periodoAgoEne;
            $eficiencia1->total = 0;
            $eficiencia1->generacion = $periodoAgo;
            $eficiencia1->periodo = "1er. Periodo";
            $eficiencia1->save();


            $eficiencia2 = new Eficiencia();
            $eficiencia2->id_carrera = ($i+1);
            $eficiencia2->id_periodo = $id_periodoFebJul;
            $eficiencia2->total = 0;
            $eficiencia2->generacion = $second_per;
            $eficiencia2->periodo = "2do. Periodo";
            $eficiencia2->save();
        }


    }


    /**
     * Create titulation
     * @param $periodoAgo
     * @param $id_periodoAgoEne
     * @param $id_periodoFebJul
     * @param $second_per
     */
    public function addTitulacion($periodoAgo,$id_periodoAgoEne,$id_periodoFebJul,$second_per){
        for($i=0; $i <=11; $i++) {

            /**
             * Titulacion periodo Agosto - Enero
             */
            $titulacionPeriodo1 = new Titulacion();
            $titulacionPeriodo1->id_carrera = ($i+1);
            $titulacionPeriodo1->id_periodo = $id_periodoAgoEne;
            $titulacionPeriodo1->total = 0;
            $titulacionPeriodo1->periodo = $periodoAgo;
            $titulacionPeriodo1->save();

            /**
             * Titulacion Febrero - Julio
             */

            $titulacionPeriodo2 = new Titulacion();
            $titulacionPeriodo2->id_carrera = ($i+1);
            $titulacionPeriodo2->id_periodo = $id_periodoFebJul;
            $titulacionPeriodo2->total = 0;
            $titulacionPeriodo2->periodo = $second_per;
            $titulacionPeriodo2->save();





            /**
             * Agregar egresados
             */


            $egresadosPeriodo1 = new EgresadosT();
            $egresadosPeriodo1->id_carrera = ($i+1);
            $egresadosPeriodo1->id_periodo = $id_periodoAgoEne;
            $egresadosPeriodo1->total = 0;
            $egresadosPeriodo1->generacion = $second_per;
            $egresadosPeriodo1->save();


            $egresadosPeriodo2 = new EgresadosT();
            $egresadosPeriodo2->id_carrera = ($i+1);
            $egresadosPeriodo2->id_periodo = $id_periodoFebJul;
            $egresadosPeriodo2->total = 0;
            $egresadosPeriodo2->generacion = $second_per;
            $egresadosPeriodo2->save();


        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
