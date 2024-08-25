<?php

namespace PractiCampoUD\Http\Controllers\Documentacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PractiCampoUD\Http\Controllers\Controller;
use PractiCampoUD\resolucion;
use PractiCampoUD\oficio; 
use Carbon\Carbon;
use DB;

/**
 * Módulo documentos
 * 
 * PHP version 7.2
 * 
 * @category PHP
 * @author LauraGiraldo
 * @copyright 2021 Sitio creado y administrado por la 
 * Facultad de Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas
 * @version 1.0
 * @link http://practicampo.udistrital.edu.co
 */
class DocumentosController extends Controller
{
    /**
     * Lista documentos en el menú sidebar
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $idUser = Auth::user()->id;
            $usuario=DB::table('users')
            ->where('id',$idUser)->first();
            $documentos_sistema = DB::table('tipo_documentacion')->orderBy('id','asc')->get();
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }
        return view('documentacion/index',['documentos_sistema'=>$documentos_sistema, 
                                            'usuario'=>$usuario,
                                            'control_sistema'=>$control_sistema]);
        
    }

    /**
     * Muestra formulario para deitar Resolución - Oficio
     * desde el sistema
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $id=Crypt::decrypt($id);
            $fecha_solicitud = Carbon::now('America/Bogota')->format('Y');
            $idUser = Auth::user()->id;
            $usuario=DB::table('users')
            ->where('id',$idUser)->first();
            
            if($id == 3)
            {
                try
                {
                    $parrafos_modificables =DB::table('resolucion')->first();
                }
                catch(\Exception $ex)
                {
                    return back()->withError('Falla en la consulta a documento Resolución.');
                }

                return view('documentacion/estructuraSideBarResolucion',[
                    'parrafos_modificables'=>$parrafos_modificables, 
                    'id_documento'=>$id,
                    'usuario'=>$usuario,
                    'control_sistema'=>$control_sistema]);
            }
                
            else if($id == 2)
            {
                try
                {
                    $parrafos_modificables =DB::table('oficio')->first();
                }
                catch(\Exception $ex)
                {
                    return back()->withError('Falla en la consulta a documento Oficio.');
                }
                return view('documentacion/estructuraSideBarOficio',['parrafos_modificables'=>$parrafos_modificables,
                'usuario'=>$usuario,
                'id_documento'=>$id,
                'control_sistema'=>$control_sistema]);
            }
            
        }       
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }
    }

    /**
     * Actualiza parrafos de resolución - oficio
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $id=Crypt::decrypt($id);
            $documentos_sistema = DB::table('tipo_documentacion')->orderBy('id','asc')->get();
            $idUser = Auth::user()->id;
            $usuario=DB::table('users')
            ->where('id',$idUser)->first();

            if($id == 3)
            {
                try{
                    $parrafos_modificables =resolucion::first();
                    $parrafos_modificables->parr_1 = $request->input('parr_1');
                    $parrafos_modificables->parr_2 = $request->input('parr_2');
                    $parrafos_modificables->parr_3 = $request->input('parr_3');
                    $parrafos_modificables->parr_4 = $request->input('parr_4');
                    $parrafos_modificables->parr_5 = $request->input('parr_5');
                    $parrafos_modificables->parr_6 = $request->input('parr_6');
                    $parrafos_modificables->parr_6_1 = $request->input('parr_6_1');
                    $parrafos_modificables->parr_7 = $request->input('parr_7');
                    $parrafos_modificables->parr_8 = $request->input('parr_8');
                    $parrafos_modificables->parr_9 = $request->input('parr_9');
                    $parrafos_modificables->parr_11 = $request->input('parr_11');
                    $parrafos_modificables->parr_12 = $request->input('parr_12');
                    $parrafos_modificables->parr_13 = $request->input('parr_13');
                    $parrafos_modificables->parr_14 = $request->input('parr_14');
                    $parrafos_modificables->parr_15 = $request->input('parr_15');
                    $parrafos_modificables->parr_16 = $request->input('parr_16');
                    $parrafos_modificables->parr_17 = $request->input('parr_17');
                    $parrafos_modificables->update();
                }
                catch(\Exception $ex)
                {
                    return back()->withError('Falla en la consulta a documento Resolución.');
                }
            }
            else if($id == 2)
            {
                try
                {
                    $parrafos_modificables =oficio::first();
                    $parrafos_modificables->parr_1 = $request->input('parr_1');
                    $parrafos_modificables->parr_2 = $request->input('parr_2');
                    $parrafos_modificables->parr_3 = $request->input('parr_3');
                    $parrafos_modificables->parr_4 = $request->input('parr_4');
                    $parrafos_modificables->parr_5 = $request->input('parr_5');
                    $parrafos_modificables->update();
                }
                catch(\Exception $ex)
                {
                    return back()->withError('Falla en la consulta a documento Oficio.');
                }
            }

            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return back()->withError('Falla al actualizar el documento.');
        }
        
        return view('documentacion/index',['documentos_sistema'=>$documentos_sistema,
                                           'usuario'=>$usuario,
                                           'control_sistema'=>$control_sistema]);
    }

    /**
     * Descarga manual usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function dwnManualUser()
    {
        try
        {
            // if(!$this->downloadFile(app_path()."/files/Manual_Usuario_PractiCampo.pdf"))
            if(!$this->downloadFile(app_path()."/files/Manual_docente.pdf"))
            {
                return redirect()->back();
            }
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar Manual de Usuario.');
        }
    }

    /**
     * Descarga resolución 090
     *
     * @return \Illuminate\Http\Response
     */
    public function dwnResolPractPre()
    {
        try
        {
            if(!$this->downloadFile(app_path()."/files/res_2018-090.pdf"))
            {
                return redirect()->back();
            }
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar Resolución 090.');
        }
    }

    /**
     * Descarga formato informe final docente
     *
     * @return \Illuminate\Http\Response
     */
    public function dwnInformeFinal()
    {
        try
        {
            if(!$this->downloadFile(app_path()."/files/informe_final.docx"))
            {
                return redirect()->back();
            }
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla al descargar el formato de informe final.');
        }
    }

    /**
     * Genera formato/estructura para descargas
     *
     * @return bool
     */
    protected  function downloadFile($src)
    {
        try
        {
            if(is_file($src))
            {
                $finfo=finfo_open(FILEINFO_MIME_TYPE);
                $contet_type=finfo_file($finfo,$src);
                finfo_close($finfo);
                $file_name=basename($src).PHP_EOL;
                $size=filesize($src);
                header("Content-Type:$contet_type");
                header("Content-Disposition: attachment; filename=$file_name");
                header("Content-Transfer-Encoding: binary");
                header("Content-Length:$size");
                readfile($src);
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(\Exception $ex)
        {
            return false;
        }
    }
}
