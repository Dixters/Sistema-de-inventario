<?php
	if($peticionAjax){
		require_once "../modelos/loginModelo.php";/* Cuando es una petición ajax el archivo se va a ejecutar en el archivo usuarioAjax.php*/
    }else{
		require_once "./modelos/loginModelo.php"; /*Pero si no es una petición Ajax se estaria ejecutando el archivo en el index.php */
    }

    class loginControlador extends loginModelo{

        /* controlador para iniciar sesión*/
        public function iniciar_sesion_controlador(){
            $usuario=mainModel::limpiar_cadena($_POST['usuario_log']);
            $clave=mainModel::limpiar_cadena($_POST['clave_log']);
    
        /* == comporbar campos vacios==*/     
         if($usuario==""|| $clave ==""){
            echo '
            <script>
            Swal.fire({
                title: "Ocurrio un error inesperado" ,
                text: "No has llenado todos los campos requeridos",
                type: "error",
                confirmButtonText: "Aceptar"
            });
            </script>
            ';
            exit();
         }


          /* == verificando la integridad de los datos==*/   
          if(mainModel::verificar_datos("[a-zA-Z0-9]{1,35}",$usuario)){
            echo '
            <script>
            Swal.fire({
                title: "Ocurrio un error inesperado" ,
                text: "EL NOMBRE DE USUARIO no coincide con el formato solicitado",
                type: "error",
                confirmButtonText: "Aceptar"
            });
            </script>
            ';
            exit();
        }

        if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
            echo '
            <script>
            Swal.fire({
                title: "Ocurrio un error inesperado" ,
                text: "LA CONTRASEÑA no coincide con el formato solicitado",
                type: "error",
                confirmButtonText: "Aceptar"
            });
            </script>
            ';
            exit();
        }

        $clave=mainModel:: encryption($clave);

        $datos_login=[  
           "Usuario" => $usuario,
           "Clave" => $clave
        ];

        $datos_cuenta=loginModelo::iniciar_sesion_modelo($datos_login);

        if($datos_cuenta->rowCount()==1){
            $row=$datos_cuenta->fetch();

            session_start(['name'=>'SPM']);

            $_SESSION['id_spm']= $row['usuario_id'];    
            $_SESSION['nombre_spm']= $row['usuario_nombre']; 
            $_SESSION['apellido_spm']= $row['usuario_apellido']; 
            $_SESSION['usuario_spm']= $row['usuario_usuario'];     
            $_SESSION['privilegio_spm']= $row['usuario_privilegio'];  
            $_SESSION['token_spm']=md5(uniqid(mt_rand(),true));    /*Serie de caracteres al azar para cerrar la sesión de una forma segura */     
            
            return header("Location: ".SERVERURL."home/");
        }else{
            echo '
            <script>
            Swal.fire({
                title: "Ocurrio un error inesperado" ,
                text: "EL USUARIO O CONTRASEÑA son incorrectos",
                type: "error",
                confirmButtonText: "Aceptar"
            });
            </script>
            ';
         }
     }/* Fin controlador */ 



     /* -----controlador forzar cierre sesión / va de la mano con codigo en plantilla.php----- */ 
     public function forzar_cierre_sesion_controlador(){
        session_unset();
        session_destroy();
        if(false){ /*Se verifica que si se esten enviando encabezados mediante php */
            return "<script> window.location.href='".SERVERURL."login/'; </script>";
        }else{
            return header("Location: ".SERVERURL."login/");
        }
      }/* Fin controlador */ 

        
      /* controlador cierre sesión*/
      public function cerrar_sesion_controlador(){
        session_start(['name'=>'SPM']);
        $token=mainModel::decryption($_POST['token']);
        $usuario=mainModel::decryption($_POST['usuario']);

        if($token== $_SESSION['token_spm'] && $usuario==$_SESSION['usuario_spm']){ /* Condicional para hacer una comprobación antes de cerrar la sesión */
            session_unset(); /* Función para vacear lo que es la sesión */
            session_destroy(); /* Función para eliminar lo que es la sesión */
            $alerta=[
                "Alerta"=>"redireccionar",
                "URL"=>SERVERURL."login/"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"No se pudo cerrar la sesión en el sistema",
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);

      }/* Fin controlador */ 
    }
    