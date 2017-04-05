
// inicializo bloques
var bloque_btn= $("#btn_encuesta");
//var bloque9= $("#bloque_9");



$(function() {
  // Handler for .ready() called.


  bloque1.bindComponent();


});




var bloque1= {    // Bloque General

    // 0 es si  1  es el no
        conf: {
            nombre: null,
            edad: null,
            genero: "m",
            osep: '0',
            embarazo: '1',
            discapacidad: '1',
            ocupacion:    '1',
            update: function(){

                bloque1.update_data();
            }

        },

        init: function(){

            bloque_btn.hide("slow");     // botonera abajo 
            bloque2.init();
            bloque3a.init();
            bloque3b.init();
            bloque4.init();
            bloque5.init();
            bloque6.init();
            bloque7.init();
            bloque9.init();
            bloque1.conf.update();
        },

        update_data: function(){

            // verifico si tiene osep

            if(bloque1.conf.osep == '0'){

                $( "#b1_div_afiliado" ).show("slow");
                bloque2.show_me();

            }else{

                $( "#b1_div_afiliado" ).hide("slow");
                bloque2.hide_me();
            }

            $( "#b1_osep" ).val(bloque1.conf.osep);
            $("#b1_osep[value=0]").attr("selected",true);

            // verifico genero
            if(bloque1.conf.genero == 'm'){

                $( "#b1_div_embarazo" ).hide("slow");
                bloque1.conf.embarazo= '1';
            }else{

                $( "#b1_div_embarazo" ).show("slow");
            }

            if(bloque1.conf.discapacidad == '0'){

                $("#b1_disc option[value=0]").attr("selected",true);

            }else{
                $("#b1_disc option[value=1]").attr("selected",true);

            }

            // independiente si es afiliado o no
            if(bloque1.conf.ocupacion == '1' || bloque1.conf.ocupacion == '2'  || bloque1.conf.ocupacion == '3' || bloque1.conf.ocupacion == '7' )
            {

                bloque9.show_me();

            }else{

                bloque9.hide_me();
            }


        },

        bindComponent: function(){
                bloque1.init();
                bloque1.update_data();

                    $( "#bloque_1 input[name$='b1_genero']" ).on(
                        'change, click', function(){

                            bloque1.conf.genero= $(this).val();
                            bloque1.conf.embarazo= '1';
                            bloque1.conf.update();

                        });

                    $( "#b1_nombre" ).on(
                        'focusout', function(){

                            bloque1.conf.nombre= $(this).val();
                            bloque1.conf.update();

                        });

                    $( "#b1_edad" ).on(
                        'focusout', function(){

                            bloque1.conf.edad= $(this).val();
                            bloque1.conf.update();

                        });

                    $( "#b1_estudio" ).on(
                        'change, click', function(){

                            bloque1.conf.estudio= $(this).val();
                            bloque1.conf.update();

                        });

                    $( "#b1_osep" ).on(
                        'change, click', function(){

                            bloque1.conf.osep= $(this).val();
                            bloque1.conf.update();

                        });

                    $( "#b1_embarazo" ).on(
                        'change, click', function(){

                            bloque1.conf.embarazo= $(this).val();
                            bloque1.conf.update();

                        });

                $( "#b1_disc" ).on(
                        'change, click', function(){

                            bloque1.conf.discapacidad= $(this).val();
                            bloque1.conf.update();

                    });

                    $( "#b1_ocupacion" ).on(
                        'change, click', function(){
                            bloque1.conf.ocupacion= $(this).val();
                            bloque1.conf.update();
                            

                    });                     

                    $( "#btn_bloques" ).on(
                        'click', function(){
                            bloque1.init();
                            bloque1.action_block();
                            
                    });   

                    $( "#btn_nuevo" ).on(
                        'click', function(){
                            bloque1.init();
                            bloque1.action_block();
                            
                    });    

           

        },

        action_block : function(){

            if(bloque1.validate()){

                if(bloque1.conf.osep == "0"){

                    bloque2.show_me();

                    var edad = parseInt(bloque1.conf.edad);

                            if (edad >= 65){  //si es mayor a 56  despliego ancianidad

                                    bloque5.show_me();     // adultos
                            }else{

                                if (edad < 14)  // si esta entre 2 y 14  niños

                                    if( edad < 2)
                                    {

                                        bloque3a.show_me();   // bebes
                                        bloque3b.hide_me();   // niños 
                                    }else{

                                        bloque3b.show_me();   // niños
                                        bloque3a.hide_me();   // bebes
                                    }

                                }

                            if (bloque1.conf.discapacidad == '0'){

                                bloque6.show_me();     // discapacidad

                            }else{

                                bloque6.hide_me();     // discapacidad
                            }

                            if ( bloque1.conf.embarazo == '0' ){

                                bloque7.show_me();     // embarazo

                            }else{
                                
                                bloque7.hide_me();     // apago embarazo
                            }                      


                            if(bloque1.conf.genero == 'f'  )
                            {
                                // si es mujer y esta embarazada  despliego  
                                
                                if(edad > 16 ){

                                    bloque4.show_me();     // mujeres

                                }else{

                                     bloque4.hide_me();     // mujeres
                                }

                            }

                }

                bloque_btn.show("slow");     // botonera abajo             
            
            }else{


            alert('Los datos son incorrectos o faltan');
            }
     
        },

        validate: function(){

            var validacion = false;

                if($('#b1_nombre').val() != ""){

                    validacion = true;

                }else{

                    validacion = false;
                }


                if($('#b1_edad').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }

                if($('#b1_dni').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }



                if($("#b1_afiliado").is(':visible')){

                    if($('#b1_afiliado').val() != ""){

                        validacion = true;

                    }else{
                        validacion = false;
                    }
                }                

            return  validacion;

        }

}


var bloque2 ={   // bloque uso de Obra social
    estado: true,
    uso:     '0',
    template: {
                // asigno el nombre del selector de bloque
                html: '#bloque_2'
    },


    update: function(){
            // actualizo ante los cambios

            if(bloque2.uso == '0'){
                $( "#b2_si" ).show("slow");
                $( "#b2_area" ).show("slow");
                $( "#b2_no" ).hide("slow");


            }else{

                $( "#b2_si" ).hide("slow");
                $( "#b2_area" ).hide("slow");
                $( "#b2_no" ).show("slow");
            }


    },

    init:  function(){
        // funcion de inicializacion
        //bloque2.hide_me();
        bloque2.bindComponent();
        bloque2.update();

    },


    bindComponent: function(){

                $( "#b2_uso" ).on(
                    'change, click', function(){

                        bloque2.uso= $(this).val();
                        bloque2.update();

                 });

    },

    show_me: function(){

        // Mostrar el bloque
        $( bloque2.template.html ).show("slow");
        bloque2.estado= true;
    },

    hide_me: function(){
        // ocultar el bloque
        $( bloque2.template.html ).hide("slow");
        bloque2.estado= false;

    },  

    validate:function(){

        var validacion = false;

            if($("#b2_uso").is(':visible')){

                if($('#b2_uso').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }
            }   

        return  validacion;

    }
}



var bloque3a ={   // bloque 3  bebes
        estado: false,
        leche:     '1',
        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_3_a'
        },
        update: function(){
                // actualizo ante los cambios

                if(bloque3a.leche == '1'){
                    // si tien control hecho muestra complejidad
                    $( "#b3a_div_porque_no" ).hide("slow");

                }else{
                    // si no se lo hizo muestra por que no..
                    $( "#b3a_div_porque_no" ).show("slow");
                }

        },

        init:  function(){
            // funcion de inicializacion
            bloque3a.hide_me();
            bloque3a.bindComponent();
            bloque3a.update();

        },

        bindComponent: function(){

                    $( "#b3_a_leche" ).on(
                        'change, click', function(){

                            bloque3a.leche= $(this).val();
                            bloque3a.update();
                    });
        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque3a.template.html ).show("slow");
            bloque3a.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque3a.template.html ).hide("slow");
            bloque3a.estado= false;
        },  

        validate:function(){

         var validacion = false;

            if($("#b2_uso").is(':visible')){

                if($('#b2_uso').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }
            }   


            if($('#b2_otro').val() != ""){

                validacion = true;

            }else{
                validacion = false;
            }

            return  validacion;
            
        }    
}



var bloque3b ={     //Bloque Niños
        estado: false,
        escuela:     '2',
        extra:       '1',
        activity:    '1', 

        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_3_b'
        },
        update: function(){
                // actualizo ante los cambios

                if(bloque3b.escuela == '1'){
                    // si tien control hecho muestra complejidad
                    $( "#b3b_div_problem" ).show("slow");

                }else{
                    // si no se lo hizo muestra por que no..
                    $( "#b3b_div_problem" ).hide("slow");
                }

                if(bloque3b.extra == '1'){
                    // si tien control hecho muestra complejidad
                    $( "#b3b_div_activity" ).show("slow");
                    $( "#b3b_div_donde" ).hide();

                }else{
                   
                    $( "#b3b_div_activity" ).hide("slow");
                    $( "#b3b_div_donde" ).hide();
                    bloque3b.activity='1';
                    $( "#b3b_activity" ).val(bloque3b.activity);
                    $("#b3b_activity[value=1]").attr("selected",true);
                    
                }


                if(bloque3b.activity == '3' ||  bloque3b.activity == '2' ||  bloque3b.activity == '5'){
                    // si tien control hecho muestra complejidad
                    $( "#b3b_div_donde" ).show("slow");

                }else{
                    // si no se lo hizo muestra por que no..
                    $( "#b3b_div_donde" ).hide();
                }



        },

        init:  function(){
            // funcion de inicializacion
            bloque3b.hide_me();
            bloque3b.bindComponent();
            bloque3b.update();

        },

        bindComponent: function(){

                    $( "#b3b_escuela" ).on(
                        'change, click', function(){

                            bloque3b.escuela= $(this).val();
                            bloque3b.update();
                    });

                    $( "#b3b_extra" ).on(
                        'change, click', function(){

                            bloque3b.extra= $(this).val();
                            bloque3b.update();
                    });


                    $( "#b3b_activity" ).on(
                        'change', function(){

                            bloque3b.activity= $(this).val();
                            bloque3b.update();
                    });

        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque3b.template.html ).show("slow");
            bloque3b.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque3b.template.html ).hide("slow");
            bloque3b.estado= false;
        }, 

        validate:function(){





        } 



}



var bloque4 ={       // mUjer
        estado: false,
        pap: {
            uso:     '0'
        },

        mamo: {

            uso:     '0'
        },

        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_4'
        },

        update: function(){
                // actualizo ante los cambios

                if(bloque4.pap.uso == '0'){

                    $( "#b4_div_pap_si" ).show("slow");
                    $( "#b4_div_pap_no" ).hide("slow");

                }else{

                    $( "#b4_div_pap_si" ).hide("slow");
                    $( "#b4_div_pap_no" ).show("slow");

                }

                if(bloque4.mamo.uso == '0'){
                    $( "#b4_div_mamo_si" ).show("slow");
                    $( "#b4_div_mamo_no" ).hide("slow");


                }else{

                    $( "#b4_div_mamo_si" ).hide("slow");
                    $( "#b4_div_mamo_no" ).show("slow");
                }
        },

        init:  function(){
            // funcion de inicializacion
            bloque4.hide_me();
            bloque4.bindComponent();
            bloque4.update();

        },
        bindComponent: function(){

                    $( "#b4_pap" ).on(
                        'change, click', function(){

                            bloque4.pap.uso= $(this).val();
                            bloque4.update();

                    });

                    $( "#b4_mamo" ).on(
                        'change, click', function(){

                            bloque4.mamo.uso= $(this).val();
                            bloque4.update();

                    });
        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque4.template.html ).show("slow");
            bloque4.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque4.template.html ).hide("slow");
            bloque4.estado= false;
        },  

        validate:function(){
            
        }       

}



var bloque5 ={       // Adultos mayores
        estado: false,
        activity: '2',
        medico: '1',
        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_5'
        },

        update: function(){
                // actualizo ante los cambios

                if(bloque5.activity == '1'){

                    $( "#b5_div_cual" ).show("slow");
                 
                }else{

                    $( "#b5_div_cual" ).hide("slow");
                }

                if(bloque5.medico == '1'){
                    $( "#b5_div_esde_osep" ).show("slow");

                }else{

                    $( "#b5_div_esde_osep" ).hide("slow");
                }

        },

        init:  function(){
            // funcion de inicializacion
            bloque5.hide_me();
            bloque5.bindComponent();
            bloque5.update();

        },
        bindComponent: function(){

                    $( "#b5_activity" ).on(
                        'change, click', function(){

                            bloque5.activity= $(this).val();
                            bloque5.update();

                    });

                    $( "#b5_medico" ).on(
                        'change, click', function(){

                            bloque5.medico= $(this).val();
                            bloque5.update();

                    });
        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque5.template.html ).show("slow");
            bloque5.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque5.template.html ).hide("slow");
            bloque5.estado= false;
        },  


        validate:function(){




            
        }        
}



var bloque6 ={       // Discapacidad

        estado: false,

        medico: [],

        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_6'
        },

        update: function(){
                // actualizo ante los cambios

                var items= ['1','2','3','4','5']
                var vista = false;
                $.each( items, function( index, el){

                        if($.inArray( el , bloque6.medico) != -1){

                            // Mostrar el bloque
                            vista = true;
                            return false;

                        }else{
                            vista = false;
                            
                        }
                });

            if( vista){

                $('#b6_div_profesional').show("slow");
            }else{

                $('#b6_div_profesional').hide("slow");
            }


        },

        init:  function(){
            // funcion de inicializacion
            bloque6.hide_me();
            bloque6.bindComponent();
            bloque6.update();

        },
        bindComponent: function(){

            $( "#b6_div_medicos input[type='checkbox']" ).on(
                'click', function(){
                    bloque6.medico= [];
                $("#b6_div_medicos  input[type='checkbox']").each(function(){

                    if ($(this).prop('checked')){
                        
                         bloque6.medico.push($(this).val());

                    }
                })

               bloque6.update();
            });
            $('#b6_div_profesional').hide("slow")

        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque6.template.html ).show("slow");
            bloque6.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque6.template.html ).hide("slow");
            bloque6.estado= false;
        }, 


        validate:function(){

            if(bloque6.estado){

                var validacion = false;
                var cantidad   = 0;
                var contar = function(numero){
                                    if (numero >0){
                                            return true;
                                    }else{
                                            return false;
                                    }
                                };
               
                if($("#b7_cual").is(':visible')){

                    if($('#b7_cual').val() != ""){

                        validacion = true;

                    }else{
                        validacion = false;
                    }
                }

               $("#b6_div_tipo  input[type='checkbox']").each(function(){

                    if ($(this).prop('checked')){
                        
                         cantidad++;

                    }

                })  

                validacion = contar(cantidad)

                cantidad= 0;
               $("#b6_div_medicos  input[type='checkbox']").each(function(){

                    if ($(this).prop('checked')){
                        
                         cantidad++;

                    }

                })  

                validacion = contar(cantidad);

                return  validacion;

            }
            
        }

}



var bloque7 ={       // embarazo
        estado: false,
        uso:     '1',
        problem: '2',

        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_7'
        },

        update: function(){
                // actualizo ante los cambios

                if(bloque7.uso == '1'){
                    // si tien control hecho muestra complejidad
                    $( "#b7_div_complejo" ).show("slow");
                    $( "#b7_div_porque_no" ).hide("slow");

                }else{
                    // si no se lo hizo muestra por que no..
                    $( "#b7_div_porque_no" ).show("slow");
                    $( "#b7_div_complejo" ).hide("slow");

                }
                if(bloque7.problem == '1'){
                    
                    $( "#b7_cual" ).show("slow");


                }else{

                    $( "#b7_cual" ).hide("slow");
                }
        },

        init:  function(){
            // funcion de inicializacion
            bloque7.hide_me();
            bloque7.bindComponent();
            bloque7.update();

        },

        bindComponent: function(){

                    $( "#b7_uso" ).on(
                        'change, click', function(){

                            bloque7.uso= $(this).val();
                            bloque7.update();
                    });
                    $( "#b7_problem" ).on(
                        'change, click', function(){

                            bloque7.problem= $(this).val();
                            bloque7.update();

                    });
        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque7.template.html ).show("slow");
            bloque7.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque7.template.html ).hide("slow");
            bloque7.estado= false;
        }, 

        validate:function(){    // valido los campos requeridos del bloque de a cuerdo si esta activo o no

            if(bloque7.estado){

                var validacion = false;

               
                if($("#b7_cual").is(':visible')){

                    if($('#b7_cual').val() != ""){

                        validacion = true;

                    }else{
                        validacion = false;
                    }
                }   

                return  validacion;
            }

            
        },




}




var bloque9 ={       // laboral

        estado: false,
        template: {
                    // asigno el nombre del selector de bloque
                    html: '#bloque_9'
        },


        init:  function(){
            // funcion de inicializacion
            bloque9.show_me();

        },

        show_me: function(){

            // Mostrar el bloque
            $( bloque9.template.html ).show("slow");
            bloque9.estado= true;
        },

        hide_me: function(){
            // ocultar el bloque
            $( bloque9.template.html ).hide("slow");
            bloque9.estado= false;
        }, 


        validate:function(){

            if(bloque9.estado){
                var validacion = false;

                if($('#b9_horas').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }


                if($('#b9_lugar').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }

                if($('#b9_ocupacion').val() != ""){

                    validacion = true;

                }else{
                    validacion = false;
                }                


            }
            
        },


        reset: function(){


        } 
}

