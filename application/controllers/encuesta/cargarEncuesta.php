<?php

// Este es el controlador general de encuestas
defined('BASEPATH') OR exit('No direct script access allowed');

class CargarEncuesta extends CI_Controller{

	function __construct(){
		parent::__construct();

            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->model('Bienvenida_model');
            $this->load->model('abms/abmEmpleados_model');
            $this->load->model('seguridad/AbmNiveles_model');
            $this->load->model('seguridad/AbmUsuarios_model');
            $this->load->model('abms/AbmVisitas_model');
            // modelo de 

            // modelo de relevamiento
            $this->load->model('relevamiento/Relevamiento_model');
            $this->load->library('form_validation'); 
            $this->load->library('Quiz_lib');

        }


        function index(){  

                $session_data = $this->session->userdata('logged_in');
                redirect('encuesta/cargarEncuesta/'.$session_data['idEmpleado'],'refresh');
        }


        function init(){  

                // bloque 0 carga inicial de datos de relevamiento
                if($this->session->userdata('logged_in')){
                        $session_data = $this->session->userdata('logged_in');
                        $data['username'] = $session_data['username'];
                        $data['nombreE'] = $session_data['nombreE'];
                        $data['apellidoE'] = $session_data['apellidoE'];
                        $data['nivel'] = $session_data['nivel'];
                        $data['tipoEmpleado']=$session_data['idTipoEmpleado'];

                        $this->session->set_flashdata('username', $data);
                        $this->session->set_flashdata('nombreE', $data);
                        $this->session->set_flashdata('nivel', $data);

                        //mantener sidebar dinamica
                        $session_data = $this->session->userdata('logged_in');
                        $data['nivel'] = $this->Bienvenida_model->obtenerNivel($session_data['nivel']);
                        //cargo el header y el sidebar con los datos para el nivel de usuarios
                        $this->load->view('backend/header');
                        $this->load->view('backend/sidebar',$data);
                        $js['javascript']= ["vendor/spin.js","app.js", "helpers.js"];



                        /*
                                1_comprobar que este recibiendo un numero
                                2_ verificar el nivel de usuario, si es 2 solo debe usar su $session_data['idEmpleado']

                                3_  si es un nivel superior puede usar el $session_data['idEmpleado'] que se envie por la url

                                =====================================

                                4_debo consultar la libreria quiz_lib  y en base al $session_data['idEmpleado'] o id usuario enviado, traer el ultimo relevamiento abierto

                                5_reconstruir con los datos el primer formulario y editarlo si es necesario

                                6_ agregar el campo estado la la tabla relevanimento

                        */

                        $usuario_id = $this->uri->segment(3);// id  que envia desde el form

                        
                        if($session_data['nivel'] == "1"){    // verifico el tipo de usuario
                                                              //Si el usuario es facilitador solo paso su nombre
                                $usuario_merge= $data['nombreE']. " " .$data['apellidoE']; // junto el nombre y apellido
                                $valor['listado'][]= [$session_data['idEmpleado'], $usuario_merge]; // paso el array con los datos
                                // ene ste caso por als que envie cualquier dato por la url el valor que paso es el mismo del usuario facilitador
                                $id_usuario= $session_data['idEmpleado'];
                                // consulto si hay algun relevameinto abierto para este usuario
                                // si es asi traigo toda la info primaria
                                $valor['relevamiento']= $this->quiz_lib->get_last_data_user($id_usuario);

                                        
                        }else{


                                // si es otro tipo de usuario trae la lista de todos los fac

                                //todo revisar
                                $listado = $this->abmEmpleados_model->obtenerEmpleadoByTipo("5");  // listado por facilitador   el 5  es facilitador

                                foreach($listado->result() as $lista){

                                        $valor['listado'][]= [$lista->idEmpleado, $lista->nombreE. " ". $lista->apellidoE];

                                }  
                                
                                // devuelvo la info del id que me pasan por la url, si no tiene relevamiento abierto solo devuelve el ultimo id+1
                                $valor['relevamiento']= $this->quiz_lib->get_last_data_user($usuario_id);
                                $valor['selectedItem']=$usuario_id;

                        }


                        $valor['departamento']= (array) $this->abmVisitas_model->getDepartamentos()->result(); // cargo los departamentos ....todos
                        $this->load->view("backend/encuesta/cargar_encuesta_inicio_view",$valor);
                        $this->load->view('backend/footer');
                        $this->load->view('backend/encuesta/script_js', $js);

                }else{
                        $this->load->helper(array('form'));
                        $this->load->view('login_view');
                }

        }


        function cargabloques()
        {

                if($this->session->userdata('logged_in')){
                        $session_data = $this->session->userdata('logged_in');
                        $data['username'] = $session_data['username'];
                        $data['nombreE'] = $session_data['nombreE'];
                        $data['nivel'] = $session_data['nivel'];
                        $this->session->set_flashdata('username', $data);
                        $this->session->set_flashdata('nombreE', $data);
                        $this->session->set_flashdata('nivel', $data);
                        //mantener sidebar dinamica
                        $session_data = $this->session->userdata('logged_in');
                        $data['nivel'] = $this->Bienvenida_model->obtenerNivel($session_data['nivel']);
                        $accion= $this->input->post('accion');


                                if($this->input->post('Continuar') && $this->input->post('Continuar') != '' && $this->input->post('nom_facilitador') != '')
                                {
                                        $_POST['Continuar']="";
                                        unset($_POST['Continuar']);      

                                        $this->load->view('backend/header');
                                        $this->load->view('backend/sidebar',$data);

                                        //paso los datos a variable

                                        $facilitador = $this->input->post('nom_facilitador');
                                        $nroRelevamiento = $this->input->post('nroRelev');
                                        $fechaRelevamiento = implode('-',array_reverse(explode('-',$this->input->post('fechaRelev'))));
                                        $dptoNumero = $this->input->post('idDep');
                                        $id_tlocalidad = $this->input->post('idLocalidad');
                                        $calle = $this->input->post('b0_calle');
                                        $numero = $this->input->post('numero');

                                        if(is_null($numero)){  // compruebo si viene sin numero tildado en el formulario                
                                                // si tiene -1 es calle sin numero
                                                $numero= "-1";
                                        }
                                        
                                        $barrio = $this->input->post('barrio');
                                        $manzana = $this->input->post('barrio_m');
                                        $casa = $this->input->post('barrio_c');
                                        $entre_calle = $this->input->post('entre_calle');
                                        $tel_titular = $this->input->post('tel_titular');
                                        $tel_supe = $this->input->post('tel_super');
                                        $observaciones = $this->input->post('observaciones');
                                        $idRelev = $this->input->post('hdnIdrelev');  // recibo el id de relevamiento si existe en caso de edicion
                                        $idDireccion = $this->input->post('hdnIdDirec'); // recibo el id de la direccion si existe


                                        $op_embarazo = $_POST['embarazo'];
                                        $options['cantidad']= $_POST['cantidad'];
                                        $options['embarazo']= $op_embarazo;

                                                if ($op_embarazo == 0){

                                                        $options['edades'] = $_POST['edades_emb'];
                                                }else{

                                                        $options['edades'] = 0;
                                                }

                                        // $datox= $_SESSION['qz_general'];

                                        //guardo la direccion 
                                        $direccion['calle']= $calle;
                                        $direccion['casa']= $casa;
                                        $direccion['numero']= $numero;
                                        $direccion['dptoNumero']= $dptoNumero;
                                        $direccion['entreCalles1']= $entre_calle;
                                        $direccion['barrio']= $barrio;
                                        $direccion['manzana']= $manzana;
                                        $direccion['id_tlocalidad']= $id_tlocalidad;

                                        if($accion == 'guardar'){

                                                $id_direccion= $this->Relevamiento_model->crearDireccion($direccion); // obtengo el id de la direccion

                                        }else{

                                                // edito los datos que estan
                                                $id_direccion= $this->Relevamiento_model->editDireccion($idDireccion, $direccion ); // obtengo el id de la direccion 

                                        }




                                        $relevamiento['nroRelevamiento']= $nroRelevamiento;
                                        $relevamiento['fechaRelevamiento']=$fechaRelevamiento;
                                        $relevamiento['idDireccion']= $id_direccion;
                                        $relevamiento['idEmpleado']=$facilitador;
                                        $relevamiento['cantEncuestados']= serialize($options);
                                        $relevamiento['telTitular']= $tel_titular;
                                        $relevamiento['telSup']=$tel_supe;
                                        $relevamiento['observacion']=$observaciones;
                                        $relevamiento['idEncuesta']=1; // esto hay que modificarlo, por ahora es la 1
                                        $relevamiento['estado']=1;  // estado inicial como que es

                                        if($accion == 'guardar'){
                                                
                                                //guarda los datos de relev
                                                $id_relevamiento= $this->Relevamiento_model->crearRelevamiento($relevamiento);

                                        }else{
                                                // edita datos de relev  $nroRelevamiento  seria el que ya esta
                                                $id_relevamiento= $this->Relevamiento_model->editRelevamiento($idRelev,$relevamiento);

                                        }

                                        $options['id_relevamiento']=$id_relevamiento;  // id unico de relevamiento e la tabla
                                        $options['id_numRel']=$nroRelevamiento; // numero asignado al fac..  se repite
                                        //borrar las variables post
                                        //var_dump($_POST=array());
                                        //aqui debo verificar con el id del relevamiento cuantos integrantes hay relevados   y cuantos integrantes hay en total

                                        $cantidad_encuestados= $this->Relevamiento_model->getCantidadEncuestados($id_relevamiento);
                                        $respondiente= $this->Relevamiento_model->getRespondiente($id_relevamiento);
                                        $options['cantidad_encuestados']= $cantidad_encuestados;
                                        $options['respondiente']= $respondiente;
                                       
                                        // si la cantidad de encuestados es igual a la cantidad de integrantes relevados 
                                        // pasa al bloque final
                                        if(intval($options['cantidad']) == $options['cantidad_encuestados'] ){

                                                // verifica si ya se completo la cantidad de encuestados

                                                $resp['id_numRel']= $nroRelevamiento;
                                                $resp['id_relevamiento']= $id_relevamiento;
                                                $resp['criticidad'] = $this->Relevamiento_model->getCriticidad();

                                           
                                                $this->load->view("backend/encuesta/cargar_encuesta_final_view",$resp);
                                                $this->load->view('backend/footer');
                                                //$js['javascript']= ["bloque_8.js","bloque3.js","bloqueaa.js"];
                                                $js['javascript']= ["vendor/spin.js", "helpers.js","vendor/jquery.gritter.js","bloque_8.js"];
                        
                                                $this->load->view('backend/encuesta/script_js', $js);


                                        }else{

                                                $this->load->view("backend/encuesta/cargar_encuesta_view", $options);
                                                $this->load->view('backend/footer');
                                                $js['javascript']= ["vendor/spin.js", "bloques.js", "helpers.js"];
                                                $this->load->view('backend/encuesta/script_js', $js);

                                        }


                                }
                                else
                                {

                                        redirect('encuesta/cargarEncuesta');

                                }


                }else{
                        $this->load->helper(array('form'));
                        $this->load->view('login_view');
                }



        }



        function cargabloques_final()
    {

            if($this->session->userdata('logged_in')){
                    $session_data = $this->session->userdata('logged_in');
                    $data['username'] = $session_data['username'];
                    $data['nombreE'] = $session_data['nombreE'];
                    $data['nivel'] = $session_data['nivel'];
                    $this->session->set_flashdata('username', $data);
                    $this->session->set_flashdata('nombreE', $data);
                    $this->session->set_flashdata('nivel', $data);
                    //mantener sidebar dinamica
                    $session_data = $this->session->userdata('logged_in');
                    $data['nivel'] = $this->Bienvenida_model->obtenerNivel($session_data['nivel']);

                   
           
             
                    $continuar = $this->input->post('continuar');
                    $resp['id_numRel']= $this->input->post('hdnid_numRel');
                    $resp['id_relevamiento']= $this->input->post('hdnid_relevamiento');
                    $resp['criticidad'] = $this->Relevamiento_model->getCriticidad();

                    if( $resp['id_numRel'] != null  && $resp['id_relevamiento'] != null )
                    {

                        $this->load->view('backend/header');
                        $this->load->view('backend/sidebar',$data);
                        $this->load->view("backend/encuesta/cargar_encuesta_final_view",$resp);
                        $this->load->view('backend/footer');
                        //$js['javascript']= ["bloque_8.js","bloque3.js","bloqueaa.js"];
                        $js['javascript']= ["vendor/spin.js", "helpers.js","vendor/jquery.gritter.js","bloque_8.js"];

                        $this->load->view('backend/encuesta/script_js', $js);
                        
                    }
                    else
                    {

                         redirect('encuesta/cargarEncuesta');

                    }


            }else{
                    $this->load->helper(array('form'));
                    $this->load->view('login_view');
            }



    }




        function guardarEncuesta()
        {

        
                if($this->session->userdata('logged_in')){
                        $session_data = $this->session->userdata('logged_in');
                        $data['username'] = $session_data['username'];
                        $data['nombreE'] = $session_data['nombreE'];
                        $data['apellidoE'] = $session_data['apellidoE'];
                        $data['nivel'] = $session_data['nivel'];
                        $data['tipoEmpleado']=$session_data['idTipoEmpleado'];

                        $this->session->set_flashdata('username', $data);
                        $this->session->set_flashdata('nombreE', $data);
                        $this->session->set_flashdata('nivel', $data);

                        //mantener sidebar dinamica
                        $session_data = $this->session->userdata('logged_in');
                        $data['nivel'] = $this->Bienvenida_model->obtenerNivel($session_data['nivel']);
                        //cargo el header y el sidebar con los datos para el nivel de usuarios

                        $datosForm = $this->input->post('datos'); // traigo los datos por post

                        $retorno=['accion'=>'fail'];
                        //array test==================
                         //$datosForm = '[{"id_relev":"3","numrelevamiento":"3"},["84","1"],["85","1"],["86","1"],["87","1"],["88","1"],["89","1"],["90","1"],["91","2"],["92","2"],["93","2"],["94","2"],["95","2"],["96","2"],["97","2"],["98","2"],["99","1"],["100","1"],["101","118"],["102","124"],["103","128"],["105","130"],["105","111"],["106",""],["idCriticidad","2"]]';
                        //=====================

                        $datosEncuesta= json_decode($datosForm); // convierto el String nuevamente en array


                        // tomo el contenido del indice 0 que estan los datos del envcuestado

                        $id_relevamiento = $datosEncuesta[0]->id_relev;                                 //numero de id del relevamiento
                        $numrelevamiento = $datosEncuesta[0]->numrelevamiento;
                        $idCriticidad    = $datosEncuesta[0]->idCriticidad;

                        $limit = count($datosEncuesta);                                                 // limite del arreglo

                                $valor= array();
                                $respuestaBreve= $this->Relevamiento_model->getRespuestaBreve(); // creo un arreglo con todas los id de respuesta breve
                                foreach($respuestaBreve->result() as $dat){

                                        array_push($valor, $dat->idPregunta);

                                }  

                                // for que recorre el areglo guardando cada dato  comienza desde el 1, por que el 0 tiene los datos del encuestado
                                for($i =1 ;$i < $limit ; $i++ ){

                                        /*
                                                lo que viene en el indice uno 1 es la respuesta elegida
                                                generalmente es unnumero asociado 
                                                creo un array con los id de pregunta que reciben texto o sea respuesta prebe
                                                - Me fijo si el id de pregunta esta en el arreglo
                                                -  en caso que este es una respuesta breve  y se envia el arreglo datos con ese formato
                                                - en caso de que no es una respuesta normal y se envia con el formato base
                
                                        */

                                                //var_dump($datosEncuesta[$i][0] );
                                        
                                                if(in_array($datosEncuesta[$i][0] ,$valor)){
                                                        //es respuesta breve
                                                        $datos=[
                                                                'respB'=>$datosEncuesta[$i][1],
                                                                'relevamiento'=>$id_relevamiento,
                                                                'idEnc'=>null,
                                                                'idPreg'=>$datosEncuesta[$i][0],
                                                                'idResp'=>'0'

                                                        ];
                                                        
                                                }else{
                                                        // es respuesta comun
                                                        $datos=[
                                                                'respB'=>null,
                                                                'relevamiento'=>$id_relevamiento,
                                                                'idEnc'=>null,
                                                                'idPreg'=>$datosEncuesta[$i][0],
                                                                'idResp'=>$datosEncuesta[$i][1]

                                                        ];
                                                }

                                        $result= $this->Relevamiento_model->crearRespuestaElegida($datos); // creo un arreglo con todas los id de respuesta breve

                                }

                                // cierro la encuesta
                                
                                $this->Relevamiento_model->finalizaEncuesta($id_relevamiento, $idCriticidad );
                                $retorno= ['mensaje'=> 'ok'];
                                echo json_encode($retorno);

                }else{
                        $retorno= ['mensaje'=> 'la sesion esta expirada, ingrese nuevamente'];
                        echo json_encode($retorno);
                }

        }


        function encuestaAjax()
        {

                // bloque 0 carga inicial de datos de relevamiento
                if($this->session->userdata('logged_in')){
                        $session_data = $this->session->userdata('logged_in');
                        $data['username'] = $session_data['username'];
                        $data['nombreE'] = $session_data['nombreE'];
                        $data['apellidoE'] = $session_data['apellidoE'];
                        $data['nivel'] = $session_data['nivel'];
                        $data['tipoEmpleado']=$session_data['idTipoEmpleado'];

                        $this->session->set_flashdata('username', $data);
                        $this->session->set_flashdata('nombreE', $data);
                        $this->session->set_flashdata('nivel', $data);

                        //mantener sidebar dinamica
                        $session_data = $this->session->userdata('logged_in');
                        $data['nivel'] = $this->Bienvenida_model->obtenerNivel($session_data['nivel']);
                        //cargo el header y el sidebar con los datos para el nivel de usuarios

                        $datosForm = $this->input->post('datos'); // traigo los datos por post

                        //array test==================
                               // $datosForm = '[{"nombre":"","apellido":"prueba","dni":"2332323","edad":"23","sexo":"M","id_relev":"10","n_afiliado":"2332323/00","respondeR":"1"},["22","1"],["24","0"],["33","1"],["34","1"],["35","1"]]';
                        //=====================

                        $datosEncuesta= json_decode($datosForm); // convierto el String nuevamente en array

                        // tomo el contenido del indice 0 que estan los datos del envcuestado
                        $id_encuestado= $this->Relevamiento_model->crearEncuestado($datosEncuesta[0]);  // guardo al encuestado y traigo el id correspondiente

                        $id_relevamiento = $datosEncuesta[0]->id_relev;                                 //numero de id del relevamiento

                        $limit = count($datosEncuesta);                                                 // limite del arreglo

                                $valor= array();
                                $respuestaBreve= $this->Relevamiento_model->getRespuestaBreve(); // creo un arreglo con todas los id de respuesta breve
                                foreach($respuestaBreve->result() as $dat){

                                        array_push($valor, $dat->idPregunta);

                                }  

                                // for que recorre el areglo guardando cada dato  comienza desde el 1, por que el 0 tiene los datos del encuestado
                                for($i =1 ;$i < $limit ; $i++ ){

                                        /*
                                                lo que viene en el indice uno 1 es la respuesta elegida
                                                generalmente es unnumero asociado 
                                                creo un array con los id de pregunta que reciben texto o sea respuesta prebe
                                                - Me fijo si el id de pregunta esta en el arreglo
                                                -  en caso que este es una respuesta breve  y se envia el arreglo datos con ese formato
                                                - en caso de que no es una respuesta normal y se envia con el formato base
                
                                        */

                                                //var_dump($datosEncuesta[$i][0] );
                                        
                                                if(in_array($datosEncuesta[$i][0] ,$valor)){
                                                        //es respuesta breve
                                                        $datos=[
                                                                'respB'=>$datosEncuesta[$i][1],
                                                                'relevamiento'=>$id_relevamiento,
                                                                'idEnc'=>$id_encuestado,
                                                                'idPreg'=>$datosEncuesta[$i][0],
                                                                'idResp'=>'0'

                                                        ];
                                                        
                                                }else{
                                                        // es respuesta comun
                                                        $datos=[
                                                                'respB'=>null,
                                                                'relevamiento'=>$id_relevamiento,
                                                                'idEnc'=>$id_encuestado,
                                                                'idPreg'=>$datosEncuesta[$i][0],
                                                                'idResp'=>$datosEncuesta[$i][1]

                                                        ];
                                                }


                                $result= $this->Relevamiento_model->crearRespuestaElegida($datos); // creo un arreglo con todas los id de respuesta breve


                                }


                                $retorno= ['mensaje'=> 'ok'];
                                echo json_encode($retorno);




                }else{
                        $retorno= ['mensaje'=> 'la sesion esta expirada, ingrese nuevamente'];
                        echo json_encode($retorno);
                }


        }



        function prueba(){

                
                $id_encuestado= $this->Relevamiento_model->updateAfiliado(1);
var_dump($id_encuestado);
        }


}
