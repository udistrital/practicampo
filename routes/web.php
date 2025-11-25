<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    // return view('welcome');
    return view('auth/login');
    // return view('mantenimiento');
});

// ------> Authentication Routes... <------
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('loginEst', 'EstudianteController@showLoginFormEst')->name('loginEst');
// Route::group(['middleware' => 'activo'], function () {

Route::post('login', 'Auth\LoginController@login'); 
Route::post('loginEst', 'EstudianteController@loginEst'); 

//Route::get('logout', 'Users\UsersController@logout_redirect')->name('logout_redirect');
Route::post('logout', 'Users\UsersController@logout')->name('logout');

// ------> Reset Password TODOS <------
    
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');

// ------> Reset Password TODOS <------


// ------> acciones estudiantes <------     
Route::group(['middleware' => 'estudiante'], function () {
    Route::get('editEst/{id}/{email}','EstudianteController@edit')->name('doc_est_edit');
    Route::get('loginEst/{email}','EstudianteController@index')->name('doc_est_ind');
    Route::post('imp-doc-estudiantes/{id}/{id_sol}','EstudianteController@importDoc')->name('import_doc_estudiante.img');
    Route::get('Estudiante/filtrar/{id}','EstudianteController@filterEstudiante')->name('estudiante_filter_solicitud');
});
// ------> acciones estudiantes <------

// ------> Usuarios Activos <------
Route::group(['middleware' => 'auth'], function () {

    // Route::group(['middleware' => 'activo'], function () {
    
    // Auth::routes(['verified'=>true])->middleware('verified');
    Route::group(['middleware' => 'otros'], function () {
        Route::get('/home', 'HomeController@index')->name('home')->middleware('role:1,2,3,4,5,6,7,8');
    }); 

    // ------> Firma Litográfica TODOS <------
    Route::get('firma_lito', 'Users\UsersController@firma_lito')->name('firma_lito')->middleware('role:1,2,4,5');
    Route::put('firma_lito/add', 'Users\UsersController@add_firma_lito')->name('firma_lito_add')->middleware('role:1,2,4,5');
    Route::put('firma_lito/del/{f}', 'Users\UsersController@destroy_firma_lito')->name('firma_lito_del')->middleware('role:1,2,4,5');
    // ------> Firma Litográfica TODOS <------
    
    // ------> Admin Routes <------
    Route::group(['middleware' => 'admin','decano','asistD'], function () {

        // ------> Registro usuarios <------
        if ($options['register'] ?? true) { 
            Route::get('register', 'Users\UsersController@showRegistrationFormUsers')->name('register')->middleware('role:1,2,3');
            Route::post('register', 'Users\UsersController@register')->middleware('role:1,2,3');
            Route::post('register/addEspacio', 'Auth\RegisterController@addEspacio')->name('addEspacio')->middleware('role:1,2,3');
        }
        // ------> Registro usuarios <------

        // ------> usuarios <------
        Route::get('users/{id}','Users\UsersController@edit')->name('users_edit')->middleware('role:1,2,3');
        Route::put('users/{id}','Users\UsersController@update')->name('users_update')->middleware('role:1,2,3');
        Route::get('users/filtrar/{id}','Users\UsersController@filterUser')->name('users_filter')->middleware('role:1,2,3');
        Route::get('perfil/{id}','Users\UsersController@ver_perfil')->name('users_perfil');
        Route::get('users/buscar/user','Users\UsersController@buscador')->name('user_buscar')->middleware('role:1,2,3');
        // ------> usuarios <------

        // ------> Documentos Generados <------
        Route::get('edicion/documento/{id}','Documentacion\DocumentosController@edit')->name('doc_edit')->middleware('role:1,2,3');
        Route::get('ver/documento','Documentacion\DocumentosController@index')->name('doc_show')->middleware('role:1,2,3');
        Route::put('documento/{id}','Documentacion\DocumentosController@update')->name('doc_update')->middleware('role:1,2,3');
        // ------> Documentos Generados <------

        // ------> Apertura - Cierre Sistema <------
        Route::get('sistema','Sistema\SistemaController@index')->name('sistema_edit')->middleware('role:1,2,3');
        Route::put('sistema','Sistema\SistemaController@update')->name('sistema_update')->middleware('role:1,2,3');
        // ------> Apertura - Cierre Sistema <------

        // ------> Presupuesto programas academicos <------
        Route::get('presupuesto','Presupuesto\PresupuestoController@index')->name('presupuesto_edit')->middleware('role:1,2,3');
        Route::put('presupuesto/update/{id}','Presupuesto\PresupuestoController@update')->name('presupuesto_update')->middleware('role:1,2,3');
        Route::put('presupuesto/sum/{id}','Presupuesto\PresupuestoController@sum')->name('presupuesto_sum')->middleware('role:1,2,3');
        Route::put('presupuesto_tm/update','Presupuesto\PresupuestoController@update_presupuesto_tm')->name('presupuesto_update_tm')->middleware('role:1,2,3');
        Route::put('presupuesto_tm/sum/{id}','Presupuesto\PresupuestoController@sum_presupuesto_tm')->name('presupuesto_sum_tm')->middleware('role:1,2,3');
        // ------> Presupuesto programas academicos <------
        
    });

    Route::group(['middleware'=>'otros'], function (){

        // ------> perfil usuarios <------
        Route::get('perfil/{id}','Users\UsersController@ver_perfil')->name('users_perfil');
        // ------> perfil usuarios <------
        
        // ------> Excel Routes <------
        Route::get('exp-users-list-excel','Excel\ExcelController@exportExcel')->name('export_list_users.excel');
        Route::post('imp-users-list-excel','Excel\ExcelController@importExcel')->name('import_list_users.excel');

        Route::get('exp-proyecc-list-excel','Excel\ExcelController@exportprogramacionesExcel')->name('export_list_proyecc.excel');
        Route::post('imp-proyecc-list-excel','Excel\ExcelController@importprogramacionesExcel')->name('import_list_proyecc.excel');

        Route::post('imp-estud-list-excel/{id}','Excel\ExcelController@importEstudiantesExcel')->name('import_list_estud.excel');

        Route::get('exp_solicit_list_excel','Excel\ExcelController@exportSolicitudesExcel')->name('export_list_solicit.excel');
        Route::post('imp-info-solic-excel','Excel\ExcelController@importSolicitudesExcel')->name('import_info_solic.excel');
        Route::get('exp_formato_proy', 'Excel\ExcelController@exportFormatoProy')->name('exp_formato_proy');
        Route::get('exp_formato_solic', 'Excel\ExcelController@exportFormatoSolic')->name('exp_formato_solic');
        Route::get('exp_formato_estud','Excel\ExcelController@exportFormatoEstud')->name('exp_formato_estud');
        Route::get('exp_formato_users','Excel\ExcelController@exportFormatoUsers')->name('exp_formato_users');

        // ------> Descargar Excel de solicitudes <------
        Route::get('excel_solicitudes','Excel\ExcelController@excel_solicitudes_edit')->name('excel_solicitudes_edit')->middleware('role:1,2,3');
        Route::get('excel_solicitudes_aprobadas_transporte','Excel\ExcelController@excel_solicitudes_aprobadas_transporte')->name('excel_solicitudes_aprobadas_transporte')->middleware('role:1,2,3');
        Route::get('excel_solicitudes_realizadas','Excel\ExcelController@excel_solicitudes_realizadas')->name('excel_solicitudes_realizadas')->middleware('role:1,2,3');
        // ------> Descargar Excel de solicitudes <------

        // ------> PDF Routes <------
        Route::get('solicitudes_pdf','Pdf\PdfController@exportSolicitudPdf')->name('solicitud.pdf');
        Route::get('solicitudes','Solicitud\SolicitudController@index')->name('solicitud_index');
        Route::get('resolucionpdf/{id}','Pdf\PdfController@exportResolucionPdf')->name('resolucion.pdf');
        Route::get('formatoPracticapdf/{id}','Pdf\PdfController@exportFormatoPracticaPdf')->name('formatoPractica.pdf');
        Route::get('transportepdf/{id}','Pdf\PdfController@exportTransportePdf')->name('transporte.pdf');
        Route::get('avancepdf/{id}','Pdf\PdfController@exportAvancePdf')->name('avance.pdf');
        Route::get('oficiopdf/{id}','Pdf\PdfController@exportOficioPdf')->name('oficio.pdf');
        Route::get('giropdf/{id}','Pdf\PdfController@exportGiroPdf')->name('giro.pdf');
        Route::get('dwn_estud_doc/{id}/{email}','Pdf\PdfController@dwn_doc_estud')->name('dwn_doc_estud');

        Route::get('accionespdf/{id}','Pdf\PdfController@accionesPdf')->name('acciones.pdf');
        Route::put('consec_solic/{id}','Solicitud\SolicitudController@consec_solic')->name('consec_solic');
        Route::put('soportes_formatos/{id}','Solicitud\SolicitudController@soportes_formatos')->name('soportes_formatos');

        // ------> image Routes <------
        Route::get('exp-proyecc-plan-conting','programacion\programacionController@exportPlanConting')->name('export_plan_conting.img');

        // ------> programaciones Routes <------
        Route::get('programaciones/filtrar/{id}','programacion\programacionController@filterprogramacion')->name('programacion_filter');
        Route::get('programaciones/create','programacion\programacionController@create')->name('programacion_create')->middleware('verificar.fechas:programacion');
        Route::post('programaciones','programacion\programacionController@store')->name('programacion_store');
        Route::get('programaciones/{id}','programacion\programacionController@edit')->name('programacion_edit')->middleware('verificar.fechas:programacion');
        Route::put('programaciones/{id}','programacion\programacionController@update')->name('programacion_update')->middleware('verificar.fechas:programacion');
        Route::delete('programaciones','programacion\programacionController@destroy')->name('programacion_destroy');
        Route::put('proyeccsend','programacion\programacionController@sendProy')->name('programacion_send');
        Route::put('proyecc_vb','programacion\programacionController@vbProy')->name('programacion_vb');
        Route::post('proyecc_electiva','programacion\programacionController@validar_electivas')->name('programacion_electiva');
        // Route::get('programaciones/buscar/proy/{id_sel}','programacion\programacionController@buscador')->name('programacion_buscar');
        Route::get('programaciones/buscar/proy','programacion\programacionController@buscador')->name('programacion_buscar');
        Route::get('proyeccver/{id}','programacion\programacionController@ver_programacion')->name('proy_legalizadas');
        Route::post('proyeccduplicar/{id}','programacion\programacionController@duplicar_proy')->name('proy_duplicar');
        Route::put('cambios_proy/{id}','programacion\programacionController@cambios_proy')->name('proy_cambios')->middleware('role:1,2,3');
        Route::get('hab_cambios_proy/{id}','programacion\programacionController@hab_cambios_proy')->name('proy_hab_cambios')->middleware('role:1,2,3');

        // ------> solicitudes Routes <------
        Route::get('solicitudes/filtrar/{id}','Solicitud\SolicitudController@filterSolicitud')->name('solicitud_filter');
        Route::get('solicitudes/rutas/{id}','Solicitud\SolicitudController@showRuta')->name('solicitud_rutas')->middleware('verificar.fechas:solicitud');
        Route::post('solicitudes','Solicitud\SolicitudController@store')->name('solicitud_store');
        Route::get('solicitudes/{id}','Solicitud\SolicitudController@listado_sol_docen')->name('sol_docente');
        Route::get('list_solic/aprob/{id}','Solicitud\SolicitudController@listado_sol_aprob')->name('list_sol_aprob');
        Route::get('solicitudes/{id}/{tipoRuta}','Solicitud\SolicitudController@edit')->name('solicitud_edit')->middleware('verificar.fechas:solicitud');
        Route::get('ver_solicitud/{id}','Solicitud\SolicitudController@ver_solicitud')->name('solicitud_ver');
        Route::get('dwn_form_solicitud/{id}','Solicitud\SolicitudController@dwn_form_solicitud')->name('dwn_form_solicitud');
        Route::put('solicitudes/{id}/{tipoRuta}','Solicitud\SolicitudController@update')->name('solicitud_update')->middleware('verificar.fechas:solicitud');
        Route::delete('solicitudes','Solicitud\SolicitudController@destroy')->name('solicitud_destroy');
        Route::get('solic/buscar','Solicitud\SolicitudController@buscador')->name('solicitud_buscar');
        Route::get('solic_pend','Solicitud\SolicitudController@edit_solic_pend')->name('solic_pend_edit');
        Route::get('solic_aprob','Solicitud\SolicitudController@edit_solic_aprob')->name('solic_aprob_edit');
        Route::put('up_solic_asistD/{proy}','Solicitud\SolicitudController@update_solic_asistD')->name('up_solic_asistD');
        Route::get('solic/{id}','Solicitud\SolicitudController@listado_estud')->name('solic_lista_estud')->middleware('verificar.fechas:solicitud');
        Route::get('transp/{id}/{tipoRuta}','Solicitud\SolicitudController@showTransport')->name('show_transp');
        Route::get('info_trans/{id}','Solicitud\SolicitudController@info_trans')->name('info_trans');
        Route::put('encue_trans/{id}','Solicitud\SolicitudController@encuesta_transp')->name('encue_trans');
        Route::get('estud_doc/{id}','Solicitud\SolicitudController@ver_doc_estud')->name('estud_doc');

        Route::get('practica_realizada/{id}','Solicitud\SolicitudController@practica_realizada_edit')->name('practica_realizada_edit')->middleware('role:1,2,3');
        Route::put('practica_realizada/{id}','Solicitud\SolicitudController@practica_realizada_update')->name('practica_realizada_update')->middleware('role:1,2,3');

        Route::get('solic_legal/{id}','Solicitud\SolicitudController@solic_legal')->name('solic_legal');
        Route::put('solic_cierre/{id}','Solicitud\SolicitudController@solic_cierre')->name('solic_cierre');
        Route::get('encues_trans','Excel\ExcelController@exportEncuestaTrans')->name('encues_trans');

        Route::put('cambios_sol/{id}','Solicitud\SolicitudController@cambios_sol')->name('sol_cambios')->middleware('role:1,2,3');
        Route::get('hab_cambios_sol/{id}','Solicitud\SolicitudController@hab_cambios_sol')->name('sol_hab_cambios')->middleware('role:1,2,3');

        // ------> Programas Académicos Routes <------
        Route::get('programas_academicos','ProgramaAcademico\ProgramaAcademicoController@index')->name('edit_programa_academico')->middleware('role:1,2,3');
        Route::post('programas_academicos/create','ProgramaAcademico\ProgramaAcademicoController@create')->name('create_programa_academico')->middleware('role:1,2,3');
        Route::put('programas_academicos/update/{id}','ProgramaAcademico\ProgramaAcademicoController@update')->name('update_programa_academico')->middleware('role:1,2,3');        

        // ------> Espacios Académicos Routes <------
        Route::get('espacios_academicos','EspacioAcademico\EspacioAcademicoController@index')->name('edit_espacio_academico')->middleware('role:1,2,3');
        Route::post('espacios_academicos/create','EspacioAcademico\EspacioAcademicoController@create')->name('create_espacio_academico')->middleware('role:1,2,3');
        Route::put('espacios_academicos/update/{id}','EspacioAcademico\EspacioAcademicoController@update')->name('update_espacio_academico')->middleware('role:1,2,3'); 
        
        // ------> Traspasar Programación/Solicitud <------
        Route::post('/programaciones/cargar_docentes_traspaso/{id}', 'Programacion\ProgramacionController@cargar_docentes_traspaso')->middleware('role:5');
        Route::put('programaciones/traspasar/update/{id}','Programacion\ProgramacionController@traspasar_update')->name('programacion_traspasar_update')->middleware('role:5');
        Route::post('/solicitudes/cargar_docentes_traspaso/{id}', 'Solicitud\SolicitudController@cargar_docentes_traspaso')->middleware('role:5');
        Route::put('solicitudes/traspasar/update/{id}','Solicitud\SolicitudController@traspasar_update')->name('solicitud_traspasar_update')->middleware('role:5');
        // ------> Traspasar Programación/Solicitud <------

        // Search Routes...
        Route::post('buscar/espa_aca','Otros\EspacioAcademicoController@searchEspaAca')->name('espa_aca');
        Route::post('recargar/espa_aca','Otros\EspacioAcademicoController@recargarEspaAca')->name('rec_espa_aca');
        Route::post('recargar/espa_edit','Otros\EspacioAcademicoController@recargarEspaAcaEdit')->name('rec_espa_edit');
        Route::post('recargar/docen_espa','Otros\EspacioAcademicoController@recargarDocenEspaAca')->name('rec_docen_espa');
        Route::post('buscar/viaticos','Otros\OtrosController@searchViaticos')->name('viaticos');
        Route::post('sel_proy/buscador','Otros\OtrosController@sel_proy_buscador')->name('sel_proy_buscador');

        // ------> SEND EMAIL <------
        Route::post('mail/send', 'Notificacion\NotificacionController@send')->name('sendNot');

        Route::post('mail/apertura_proy', 'Notificacion\NotificacionController@apertura_proy')->name('apertura_proy');
        Route::post('mail/cierre_proy', 'Notificacion\NotificacionController@cierre_proy')->name('cierre_proy');
        Route::post('mail/apertura_solic', 'Notificacion\NotificacionController@apertura_solic')->name('apertura_solic');
        Route::post('mail/cierre_solic', 'Notificacion\NotificacionController@cierre_solic')->name('cierre_solic');
        Route::post('mail/creacion_proy/{id}', 'Notificacion\NotificacionController@creacion_proy')->name('creacion_proy');
        // Route::post('mail/creacion_solic/{id}', 'Notificacion\NotificacionController@creacion_solic')->name('creacion_solic');
        Route::post('mail/creacion_solic/{id}', 'Solicitud\SolicitudController@creacion_solic')->name('creacion_solic');
        // Route::post('mail/aprob_coord_proy/{id}', 'Notificacion\NotificacionController@aprob_coord_proy')->name('aprob_coord_proy');
        Route::post('mail/aprob_coord_proy/{id}', 'programacion\programacionController@aprob_coord_proy')->name('aprob_coord_proy');
        Route::post('mail/aprob_decano_proy/{id}', 'programacion\programacionController@aprob_decano_proy')->name('aprob_decano_proy');

        // Route::post('mail/rechazo_coord_proy/{id}', 'Notificacion\NotificacionController@rechazo_coord_proy')->name('rechazo_coord_proy');
        Route::post('mail/rechazo_coord_proy/{id}', 'programacion\programacionController@rechazo_coord_proy')->name('rechazo_coord_proy');
        Route::post('mail/rechazo_decano_proy/{id}', 'programacion\programacionController@rechazo_decano_proy')->name('rechazo_decano_proy');

        Route::post('mail/aprob_coord_solic/{id}', 'Solicitud\SolicitudController@aprob_coord_solic')->name('aprob_coord_solic');
        // Route::post('mail/aprob_coord_solic/{id}', 'Notificacion\NotificacionController@aprob_coord_solic')->name('aprob_coord_solic');
        Route::post('mail/rechazo_coord_solic/{id}', 'Solicitud\SolicitudController@rechazo_coord_solic')->name('rechazo_coord_solic');
        Route::post('mail/aprob_ejec_solic/{id}', 'Solicitud\SolicitudController@aprob_ejec_solic')->name('aprob_ejec_solic');
        // Route::post('mail/aprob_ejec_solic/{id}', 'Notificacion\NotificacionController@aprob_ejec_solic')->name('aprob_ejec_solic');
        Route::post('mail/radic_avance_tesor_solic/{id}', 'Solicitud\SolicitudController@radic_avance_tesor_solic')->name('radic_avance_tesor_solic');
        // Route::post('mail/radic_avance_tesor_solic/{id}', 'Notificacion\NotificacionController@radic_avance_tesor_solic')->name('radic_avance_tesor_solic');
        Route::post('mail/info_solic_estudiantes/{id}', 'Solicitud\SolicitudController@info_solic_estudiantes')->name('info_solic_estudiantes');
        // Route::post('mail/info_solic_estudiantes/{id}', 'Notificacion\NotificacionController@info_solic_estudiantes')->name('info_solic_estudiantes');
        Route::post('mail/info_transp_vice/{id}', 'Notificacion\NotificacionController@info_transp_vice')->name('info_transp_vice');
        Route::post('mail/estud_15_dias/{id}', 'programacion\programacionController@estud_15_dias')->name('estud_15_dias');
        Route::post('mail/estud_8_dias/{id}', 'programacion\programacionController@estud_8_dias')->name('estud_8_dias');
        Route::post('mail/noti_transp_solic/{id}', 'Solicitud\SolicitudController@noti_transp_solic')->name('noti_transp_solic');
        // Route::post('mail/noti_transp_solic/{id}', 'Notificacion\NotificacionController@noti_transp_solic')->name('noti_transp_solic');
        Route::post('mail/pre_salida', 'Notificacion\NotificacionController@pre_salida')->name('pre_salida');
        Route::post('mail/pos_salida', 'Notificacion\NotificacionController@pos_salida')->name('pos_salida');


        // ------> DOCUMENTOS <------
        Route::get('documentos/manual_usuario','Documentacion\DocumentosController@dwnManualUser')->name('dwn_man_user');
        Route::get('documentos/informe_final','Documentacion\DocumentosController@dwnInformeFinal')->name('dwn_infor_final');
        Route::get('documentos/resol_pract_pre','Documentacion\DocumentosController@dwnResolPractPre')->name('dwn_resol_pract_pre');
        Route::get('documentos/resol_avance','Documentacion\DocumentosController@dwnResolAvance')->name('dwn_resol_avance');
        Route::get('documentos/solic_avance','Documentacion\DocumentosController@dwnSolicAvance')->name('dwn_solic_avance');
        Route::get('documentos/legal_avance','Documentacion\DocumentosController@dwnLegalAvance')->name('dwn_legal_avance');
        Route::get('documentos/pract_acade','Documentacion\DocumentosController@dwnPractAcade')->name('dwn_pract_acade');
        Route::get('documentos/solic_transp','Documentacion\DocumentosController@dwnSolicTransp')->name('dwn_solic_transp');
        Route::get('documentos/soporte_personal','Documentacion\DocumentosController@dwnSoportePersonal')->name('dwn_soporte_personal');
        Route::put('sop_personal','Documentacion\DocumentosController@importSop')->name('sop_personal');
     
        // ------> AYUDA <------
        Route::get('ayuda/preg_frec','HomeController@ayuda')->name('ayuda');
    });

// });

});

