<?php
    session_start();
    if( !empty( $_POST ) )
    {
      if ( isset($_POST['email']) && isset($_POST['name']) && isset($_POST['tel']) && isset($_POST['message']) && isset($_POST['terms']))
        {
        require 'PHPMailer/PHPMailerAutoload.php';
        require_once "recaptchalib.php";

        $secret = "6LfbxDogAAAAAKbfJ76-9OLyNI6uI58Wh863JAa-";

        // empty response
        $response = null;

        // check secret key
        $reCaptcha = new ReCaptcha($secret);

        // if submitted check response
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }
        if ($response != null && $response->success) {
          //Create a new PHPMailer instance
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->CharSet = 'UTF-8';
          $mail->Encoding = 'base64';
          //Configuracion servidor mail
          $mail->From = "no-reply@autenticae.net"; //remitente
          $mail->SMTPAuth = true;                // SMTP username
          $mail->SMTPSecure = 'tls'; //seguridad
          $mail->Host = "smtp.gmail.com"; // servidor smtp
          $mail->FromName = "Servicio autenticae";
          $mail->Port = 587; //puerto
          $mail->Username ='no-reply@autenticae.net'; //nombre usuario
          $mail->Password = 'PK26DC*js'; //contraseña
          //Agregar destinatario
        //  $mail->AddAddress($_POST['email']);
          $mail->AddAddress($_POST['email']);
          $mail->Subject = 'Petición correctamente enviada';
        //  $mail->Body = $_POST['message'];
          $mail->Body = "Su consulta ha sido enviada correctamente al soporte, en breves recibirá una respuesta. \n\nMensaje enviado desde https://edu.autenticae.net/ \n\n".$_POST['message'];
          if ($mail->Send()) {
            /*session is started if you don't write this line can't use $_Session  global variable*/
            $_SESSION["alert"] = " <div class= id='submitSuccessMessage'>
                              <div class='text-center text-white mb-3'>
                              <div class='text-center text-success mb-3'>Gracias por contactar con nosotros, en breve nos pondremos en contacto con usted.</div>
                            </div>
                          </div>";
          } else {
              $_SESSION["alert"] = " <div  id='submitErrorMessage'><div class='text-center text-danger mb-3'>El mensaje no se ha enviado correctamente, por favor inténtelo de nuevo.</div></div>";
          }
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->CharSet = 'UTF-8';
          $mail->Encoding = 'base64';
          //Configuracion servidor mail
          $mail->From = "no-reply@autenticae.net"; //remitente
          $mail->SMTPAuth = true;                // SMTP username
          $mail->SMTPSecure = 'tls'; //seguridad
          $mail->Host = "smtp.gmail.com"; // servidor smtp
          $mail->FromName = "Servicio autenticae";
          $mail->Port = 587; //puerto
          $mail->Username ='no-reply@autenticae.net'; //nombre usuario
          $mail->Password = 'PK26DC*js'; //contraseña
          //Agregar destinatario
        //  $mail->AddAddress($_POST['email']);
    //    $mail->AddAddress('fjsanchez@neotica.net');
          $mail->AddAddress('fjsanchez@neotica.net');
          $mail->Subject = $_POST['contact_type'];
        //  $mail->Body = $_POST['message'];
          $mail->Body = "Se ha enviado la siguiente consulta desde https://edu.autenticae.net/: \n\nNombre del cliente: ".$_POST['name']."\n\nTeléfono de contacto: ".$_POST['tel']."\n\nCorreo electrónico de contacto: ".$_POST['email']."\n\nPetición: ".$_POST['message'];
          $mail->Send();
          $reloadpage = $_SERVER['PHP_SELF']."#contact";
          header("Location:$reloadpage");
          exit();
        } else {
            $_SESSION["alert"] = " <div  id='submitErrorMessage'><div class='text-center text-danger mb-3'>Por favor, rellene el captcha correctamente para poder realizar la petición.</div></div>";
            $reloadpage = $_SERVER['PHP_SELF']."#contact";
            header("Location:$reloadpage");
            exit();
        }

      }
      else {
        $_SESSION["alert"] = " <div  id='submitErrorMessage'><div class='text-center text-danger mb-3'>Por favor, rellene todos los campos correctamente para poder realizar la petición.</div></div>";
        $reloadpage = $_SERVER['PHP_SELF']."#contact";
        header("Location:$reloadpage");
        exit();
      }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Bienvenido a autenticae</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.png" />

        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link href="css/nuevo.css" rel="stylesheet" />
    </head>
    <body id="page-top" >
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-shrink" id="mainNav">
            <div class="container">
                  <a class="navbar-brand" href="#page-top" style="margin-right:30% !important"><img src="assets/img/logo.png" alt="..." /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <svg class="svg-inline--fa fa-bars fa-w-14 ms-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg><!-- <i class="fas fa-bars ms-1"></i> Font Awesome fontawesome.com -->
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="https://192.168.0.240/login/">Plataforma</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://autenticae.blogspot.com/">Blog</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://192.168.0.240/pricing/1&1&N">Precios</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Masthead-->
        <header class="masthead">
            <div class="container" style="text-align:left !important;">
              <div class="masthead-subheading"><h1 style="color:white !important;">Conozca las vulnerabilidades de sus proyectos web</h1></div>
              <div class="text"><p style="font-size: 150%;color:#454138;margin-right:30%;">Mejore la seguridad de sus páginas web.</p></div>
              <div class="row align-items-stretch mb-4 md-20">
                <div class="col-md-2">
                <button class="btn btn-primary btn-xl" style="font-size:10px; text-align:left !important;border-radius:5px !important;padding:5px 30px 5px 10px !important;" >
                  <h3 style="color:#454138 !important;text-align:center;" onclick="location.href='https://app.boolibu.com/i2mstatic/32/fe32b_ep/46.html';">Prueba invulnera gratis
                     <img class="rounded-circle img-fluid" src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:8%;" alt="...">
                  </h3>
                </button>
              </div>
              </div>
            </div>
        </header>
        <!-- Services-->
      <section class="page-section" id="wis">
                    <div class="container">
                        <ul class="timeline" >
                            <li class="mb-10">
                                <div class="timeline-image mb-0"><img class="rounded-circle img-fluid" src="assets/img/autenticae/Autenticae-Que_es_autenticae.svg" alt="...">
                              </div>
                                <div class="timeline-panel" style="text-align:right !important;">
                                    <div class="timeline-heading">
                                        <h4>¿Tu empresa tiene una red wifi inestable?</h4>
                                    </div>
                                    <div class="timeline-body" style="text-align:right;">Las empresas con una wifi de contraseña compartida se saturan por el exceso de dispositivos.
                                      <div class="col-md-2 mt-4" style="float:right">
                                        <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:40px;"></img>
                                      </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted mb-10">
                                <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/autenticae/Autenticae-Como_te_ayuda_autenticae.svg" alt="..."></div>
                                <div class="timeline-panel" style="text-align:left !important;">
                                    <div class="timeline-heading">
                                        <h4>¿Por qué autenticae te ayuda?</h4>
                                    </div>
                                    <div class="timeline-body">autenticae es una plataforma que te permite controlar que, por ejemplo, solo haya un dispositivo conectado por trabajador, mientras el personal de administración se puede conectar con más de un equipo. Esto evita que tu red vaya lenta o no sea accesible.
                                      <div class="col-md-2 mt-4" style="float:right">
                                        <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:40px;"></img>
                                      </div>
                                    </div>
                                </div>
                            </li>
                            <li  class="mb-0" style="margin-bottom:0px !important;">
                                <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="assets/img/autenticae/Autenticae-Problematica_Habitual.svg" alt="...">
                              </div>
                                <div class="timeline-panel" style="text-align:right !important;">
                                    <div class="timeline-heading">
                                        <h4>¿Y no es mejor comprar más antenas para potenciar la red wifi?</h4>
                                    </div>
                                    <div class="timeline-body" style="text-align:right !important;">Evita el sobredimensionamiento y la inversión extra en puntos de acceso adicionales. Con autenticae puedes ahorrarte hasta un 70% de esta inversión en 1 año.<br>
                                      <div class="col-md-2 mt-4" style="float:right">
                                        <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:40px;"></img>
                                      </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted mb-0" style="margin-top:0px !important;" >
                            </li>
                            </li>
                            <li class="mb-0" style="margin-bottom:0px !important;">
                                <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/autenticae/Autenticae-Solucion_autenticae.svg" alt="...">
                              </div>
                                <div class="timeline-panel" style="text-align:right !important;">
                                    <div class="timeline-heading">
                                        <h4>Solución autenticae</h4>
                                    </div>
                                    <div class="timeline-body">Autenticación personal e intransferible y limite conexiones por usuario.
                                      <br>
                                      <div class="col-md-2 mt-4" style="float:right">
                                        <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:40px"></img>
                                      </div>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-inverted mb-0" style="margin-top:0px !important;">
                              <div class="timeline-panel" style="text-align:left !important;">
                                <div class="timeline-heading">
                                    <h4>¿Qué otras ventajas tiene autenticae?</h4>
                                </div>
                                <div class="timeline-body">
                                <ul class="description">
                                    <li>Gestiona todos los usuarios, dispositivos y contraseñas en un solo lugar.</li>
                                    <li>Ahorra tiempo: ya no es necesario configurar la wifi en los cientos de dispositivos de tu empresa. </li>
                                    <li>Aumenta la seguridad de tu red y tu empresa con contraseñas individuales.</li>
                                </ul>
                                <div class="col-md-2 mt-4" style="float:right">
                                  <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:40px;"></img>
                                </div>
                              </div>
                            </div>
                            </li>
                          <li >
                              <div class="timeline-image"><img src="assets/img/autenticae/Autenticae-Burbuja.svg" alt="..." style="width:80%;margin:10%;"></img></div>
                            <div class="timeline-panel" style="text-align:left !important;">
                              <div class="timeline-heading">
                                  <h4 style="text-align:right !important;"><b>¿Quieres explorar esta solución para tu empresa?</b></h4>
                                  <div class="col-md-20 mt-4 text-right"><button class="btn btn-primary btn-xl ml-2 blue" id="submitButton" style="padding:2% 8% 2% 2%;text-align:center; color:white;" type="submit" onclick="contact();">Contacta con autenticae <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:20px;" alt="..."></button></div>
                              </div>
                              <div class="timeline-body">
                            </div>
                          </div>
                            </li>
                        </ul>
                </section>
        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <form id="contactForm" action="" method="post">
                    <div class="row align-items-stretch mb-4 md-20">
                      <div class="col-md-5 text-left">
                          <h2 class="section-heading" style="color:white !important;text-align:left;">Consigue una wifi más estable y óptima <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:5%;" alt="..."></h2>
                          <h4 class="section-heading" style="color:white !important;text-align:left;">Consigue que empleados y colaboradores tengan un acceso a Internet más rápido, fiable y seguro.</h4>
                          <input type="text" name="contact_type" id="contact_type" style="display:none;" value=""></input>
                          <?php
                            if(isset($_SESSION['alert']))
                              {
                                echo $_SESSION["alert"];
                                session_destroy();
                              }
                           ?>
                      </div>
                      <div class="col-md-7">
                          <div class="col-md-20">
                              <div class="form-group">
                                  <input class="form-control" id="name" type="text" placeholder="Nombre" name="name" data-sb-validations="required" style="font-size:140%;"/>
                                  <div class="invalid-feedback" data-sb-feedback="name:required"></div>
                              </div>
                          </div>
                        <div class="col-md-20">
                              <div class="form-group">
                                  <input class="form-control" id="email" type="email" name="email" placeholder="Correo electrónico" data-sb-validations="required,email" style="font-size:140%;" />
                                  <div class="invalid-feedback" data-sb-feedback="email:required"></div>
                                  <div class="invalid-feedback" data-sb-feedback="email:email"></div>
                              </div>
                          </div>
                          <div class="col-md-20">
                            <div class="form-group mb">
                                <input class="form-control" id="phone" type="tel" name="tel" placeholder="Teléfono" data-sb-validations="required" style="font-size:140%;" />
                                <div class="invalid-feedback" data-sb-feedback="phone:required"></div>
                            </div>
                          </div>
                          <div class="col-md-20">
                              <div class="form-group form-group-textarea mb-md-0">
                                  <textarea class="form-control" id="message" placeholder="Mensaje" name="message" data-sb-validations="required"  style="font-size:140%;" oninput="other_message()"></textarea>
                                  <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                              </div>
                          </div>
						 <div class="g-recaptcha" data-sitekey="6LfbxDogAAAAALgUFDqvZRG_MKE22iasoG1yfCXB"></div>
<br/>
                          <div class="col-md-20 mt-4">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="terms" name="terms">
                              <label class="form-check-label" for="terms" style="color:white;font-size:140%;">
                                He leído y acepto los  <a href="https://www.neotica.net/avisos-legales/" title=" avisos legales de Neotica Solutions."> avisos legales</a> y la  <a href="https://neotica.net/politica-de-privacidad" title=" política de privacidad de Neotica Solutions."> política de privacidad</a> .
                              </label>
                            </div>
                          </div>
                          <div class="col-md-20 mt-4"><button class="btn btn-primary btn-xl ml-0 blue" id="submitButton" style="padding:2% 8% 2% 2%;text-align:center;" type="submit">Enviar <img src="assets/img/autenticae/autenticae_arrow.svg" style="transform:rotate(90deg);width:20px;" alt="..."></button></div>
                      </div>

                  </div>

                </form>
            </div>
        </section>
        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center" style="font-size:15px;">
                    <div class="col-lg-4 text-lg-start"><p>© autenticae 2022.</p></div>
                    <div class="col-lg-4 text-lg-center">
                        <a class="link-dark text-decoration-none me-3" href="https://twitter.com/autenticae_" title="Twitter autenticae"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/></svg></a>
                        <a class="link-dark text-decoration-none" href="https://www.linkedin.com/company/autenticae" title="Linkedin autenticae">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/></svg>
                        </a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="https://neotica.net/politica-de-privacidad/" title="Política de privacidad Neotica">Política de privacidad</a>
                        <a class="link-dark text-decoration-none" href="https://neotica.net/politica-de-cookies/" title="Política de Cookies Neotica">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS
                   * *-->
        <script src="js/scripts.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="//code-eu1.jivosite.com/widget/eMZF4KtITA" async></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        <script>
        function contact(){
          var text = "Me gustaría obtener una demo gratuita de vuestro servicio autenticae.";
          document.getElementById("message").setAttribute('value',text);
          document.getElementById("message").value=text;
          document.getElementById("contact_type").value="Demo de la plataforma";
          location.href='#contact'
        }
        function prices(){
          var text = "Me gustaría recibir información sobre los precios del servicio.";
          document.getElementById("message").setAttribute('value',text);
          document.getElementById("message").value=text;
          document.getElementById("contact_type").value="Precios de la plataforma";
          location.href='#contact'
        }
        function other_message(){
          document.getElementById("contact_type").value="Contacto";
        }
        </script>

    </body>
</html>
