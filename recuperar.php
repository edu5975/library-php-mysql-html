<?php 
    include "tools.php";
        $query = "select * from usuario where email ='".$_POST['email']."'";
        $BD->consulta($query);
        if(mysqli_error($cone)>""){
            #echo "ERROR: ".mysqli_error($cone);                             
            header("location: index.php?E=25");   
        }
        else{
            $BD->num_tuplas = mysqli_num_rows($BD->bloque);     
            if ($BD->num_tuplas) {
                #$clave = rand()%1000;
                $clave = "";
                $letras="ABCDEFGHIJQLMNPQRSTUWXYZ23456785732765";
                for ($i=0; $i < 10; $i++) { 
                    $clave.= $letras[rand()%strlen($letras)];
                }
                #echo $clave;
            

                
                $query = "UPDATE usuario set clave=password('".$clave."') where email = '".$_POST['email']."'";
                $BD->consulta($query);        
                include("class.phpmailer.php");
                include("class.smtp.php");

                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host="smtp.gmail.com"; //mail.google
                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $mail->Port = 465;     // set the SMTP port for the GMAIL server
                $mail->SMTPDebug  = 0;  // enables SMTP debug information (for testing)
                                        // 1 = errors and messages
                                        // 2 = messages only
                $mail->SMTPAuth = true;   //enable SMTP authentication
            
                $mail->Username =   "17030434@itcelaya.edu.mx"; // SMTP account username
                $mail->Password = "masteredu5975";  // SMTP account password
                
                $mail->From="";
                $mail->FromName="";
                $mail->Subject = "Nueva contraseña";
                $mail->MsgHTML("</h1><h2> tu clave de acceso es : ".$clave."</h2>");
                $mail->AddAddress($_POST['email']);
                //$mail->AddAddress("admin@admin.com"); # Si se quiere más
                if (!$mail->Send()) {
                    #echo  "Error: " . $mail->ErrorInfo;                      
                    header("location: index.php?E=25");    
                }
                else { 
                    $result=mysqli_query($cone,$query);
                    if(mysqli_error($cone)>""){
                        #echo "ERROR: ".mysqli_error($cone);
                        header("location: index.php?E=25");
                    }
                    else
                        header("location: index.php?E=15"); 
                }       
            }
            else{
                #echo "ERROR: ".mysqli_error($cone);                 
                header("location: index.php?E=25");   
            }
        }
?>