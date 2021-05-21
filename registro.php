<?php 
    # 1.Registrar en la bd
    # 2.Enviar correo
    # 3.Indicar situacion o enviar logueo
        #$clave = rand()%1000;
        include "tools.php";
        $clave = "";
        $letras="ABCDEFGHIJQLMNPQRSTUWXYZ23456785732765";
        for ($i=0; $i < 10; $i++) { 
            $clave.= $letras[rand()%strlen($letras)];
        }
        #echo $clave;
                
        $query = "INSERT into usuario set vencimiento = '".date("Y-m-d",strtotime(date("Y-m-d")."+ 1 month"))."' ,email = '".$_POST['email']."', nombre = '".$_POST['nombre']."', apellidos = '".$_POST['apellidos']."',  clave=password('".$clave."')";
        $BD->consulta($query);
        include("class.phpmailer.php");
        include("class.smtp.php");

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host="smtp.gmail.com"; //mail.google
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Port = 465;     // set the SMTP port for the GMAIL server
        $mail->SMTPDebug  = 1;  // enables SMTP debug information (for testing)
                                 // 1 = errors and messages
                                 // 2 = messages only
        $mail->SMTPAuth = true;   //enable SMTP authentication
      
        $mail->Username =   ""; // SMTP account username
        $mail->Password = "";  // SMTP account password
         
        $mail->From="";
        $mail->FromName="";
        $mail->Subject = "Registro completo";
        $mail->MsgHTML("<h1>BIENVENIDO ".$_POST['nombre']." ".$_POST['apellidos']."</h1><h2> tu clave de acceso es : ".$clave."</h2>");
        $mail->AddAddress($_POST['email']);
        //$mail->AddAddress("admin@admin.com"); # Si se quiere más
        if (!$mail->Send()) {
            #echo  "Error: " . $mail->ErrorInfo;            
            header("location: index.php?E=10");
        }
        else { $result=mysqli_query($cone,$query);
            if(mysqli_error($cone)>""){
                #echo "ERROR: ".mysqli_error($cone);
                header("location: index.php?E=10");
            }
            else
                header("location: index.php?E=7"); }
      
?>