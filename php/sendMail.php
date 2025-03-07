<?php

$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$_emailCC = $_POST['emailCC'];
$_asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

if ($nombre && $telefono && $_emailCC && $_asunto && $mensaje) {
    echo sendMailNormal($nombre,$telefono,$_emailCC,$_asunto, $mensaje);
}else {
    echo "Error";
}

function check_email_address($mail){ 
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){ 
        return FALSE; 
    } else { 
         return TRUE; 
    }
} 

function sendMailNormal($nombre,$telefono,$_emailCC,$_asunto, $mensaje)
{
    $_email = 'info@adviesec.com';
    if (check_email_address($_email)==true)
    {
        
        try 
        {
            
            include_once ('../libs/phpmailer2/src/PHPMailer.php');
            include_once ('../libs/phpmailer2/src/SMTP.php');
            include_once ('../libs/phpmailer2/src/POP3.php');
            include_once ('../libs/phpmailer2/src/Exception.php');
            
            $Puerto=587;
            $Servidor="mail.adviesec.com";
            $User="info@adviesec.com";      
            $Clave="Advies2021";
                    
            //$mail   = new PHPMailer(TRUE);
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            /*$mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = "tls"; 
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );*/


            $_body="<body>   
                           Contacto pendiente.<br/><br/>
                           Queremos notificarle que se ha  realizado un contacto desde la pag web con los siguientes datos:<br/><br/>
                           <b>Nombre:</b> ".$nombre."<br/>
                           <b>Telefono:</b> ".$telefono."<br/>
                           <b>Correo:</b> ".$_emailCC."<br/>
                           <b>Asunto:</b> ".$_asunto."<br/>
                           <b>Mensaje:</b>".$mensaje. " <br/><br/><br/>
                           Nota: Esta es una notificación automática generada por el sistema. Para cualquier duda, contactar al
                                 administrador del sitio web.
                           </body>";



            $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                                       // 1 = errors and messages
                                                       // 2 = messages only
            
            $mail->Host       = $Servidor; // sets the SMTP server
            $mail->Port       = $Puerto;  // set the SMTP port for the GMAIL server
            $mail->Username   = $User; // SMTP account username
            $mail->Password   = $Clave;  // SMTP account password
            $mail->SetFrom($User, "Advies");
            $mail->AddAddress($_email);
            
            if (check_email_address($_emailCC)==true)
                $mail->AddAddress($_emailCC);
                
            $mail->Subject = "Contacto Advies";
            $mail->CharSet ='utf-8';
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; 
            $mail->MsgHTML($_body);
            
            if(!$mail->Send()) 
                return "Error el correo no pudo ser enviado...";
            else
                return "Correo enviado correctamente.";
        } 
        catch (Exception $e) {
             //echo $e->getMessage();
             //exit;
            return "Error el correo no pudo ser enviado."; 
        }
    }
    else
        return "Error el correo $_emailCC no tiene el formato correcto.";
}