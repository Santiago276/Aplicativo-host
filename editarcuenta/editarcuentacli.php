<?php
session_start();

if (isset($_SESSION["correo_usu"]) or isset($_SESSION["idusuario"])) {
?>
  <?php
  //Llamar a la conexion base de datos
  include_once '../dao/conexion.php';
  //Mostrar los datos almacenados
  $sql_mostrar = "SELECT * FROM tbl_reserva";
  //Prepara sentencia
  $Consultar_mostrar = $pdo->prepare($sql_mostrar);
  //Ejecutar consulta
  $Consultar_mostrar->execute();
  $resultado_mostrar = $Consultar_mostrar->fetchAll();
  //Imprimir var dump -> Arreglos u objetos

  //Mostrar los datos almacenados
  $sql_mostrarm = "SELECT * FROM tbl_menu";
  //Prepara sentencia
  $Consultar_mostrarm = $pdo->prepare($sql_mostrarm);
  //Ejecutar consulta
  $Consultar_mostrarm->execute();
  $resultado_mostrarm = $Consultar_mostrarm->fetchAll();
  //Imprimir var dump -> Arreglos u objetos

  ?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="/img/favicon.png">
    <link rel="stylesheet" href="/css/registro.css">
    <script src="/js/all.js"></script>
    <link rel="stylesheet" href="/css/letra1.css">
    <link rel="stylesheet" href="/css/letra2.css">
    <link rel="stylesheet" href="/css/estiloss.css">
    <link rel="stylesheet" href="/css/registro.css">
    <link rel="stylesheet" href="/css/inicio.css">
    <link rel="stylesheet" href="/dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/imagen.css">
    <link rel="stylesheet" href="/css/letra.css">
    <link rel="stylesheet" href="/css/fuentesplaz.css">
    <script src="js/jquery-3.5.1.js"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
    <title>Cliente | Plazoleta</title>
  </head>

  <body id="page-top">
    <?php require_once '../Navbar/navbar_cli.php'; ?>
    <br>
    <br>
    <br>
    <!-- End of Topbar -->
    <!-- /.container-fluid -->
    <div class="card-header py-3">
      <h4 align="center" class="tblplazz">Editar cuenta</h4>
    </div>
    <?php
    $id1 = $_SESSION["correo_usu"];
    include_once '../dao/conexion.php';
    $sql_inicio1 = "SELECT*FROM tbl_usuario WHERE correo_usu ='$id1' ";
    $consulta_resta1 = $pdo->prepare($sql_inicio1);
    $consulta_resta1->execute();
    $resultado1 = $consulta_resta1->rowCount(array($id1));
    $prueba1 = $consulta_resta1->fetch(PDO::FETCH_OBJ);
    //Validacion de roles
    if ($resultado1) {
    ?>
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
                <form class="form-signin" method=GET action="actualizar_cli.php">
                  <div class="form-label-group">
                    <input type="text" id="inputNombre" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo $prueba1->nombre_usu; ?>" required autofocus>
                    <label for="inputNombre">Nombre</label>
                  </div>
                  <div class="form-label-group">
                    <input type="text" id="inputApellido" name="apellido" class="form-control" placeholder="Apellido" value="<?php echo $prueba1->apellido_usu; ?>" required>
                    <label for="inputApellido">Apellido</label>
                  </div>
                  <div class="form-label-group">
                    <input type="number" id="inputTelefono" name="telefono" class="form-control" placeholder="Telefono" value="<?php echo $prueba1->telefono_usu; ?>" required>
                    <label for="inputTelefono">Teléfono</label>
                  </div>
                  <div class="form-label-group">
                    <input class="form-control" placeholder="id" type="hidden" name="id_editar" value="<?php echo $prueba1->idusuario; ?>" required>
                  </div>
                  <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Editar</button>
                  <br>
                </form>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Copyright Section-->
      <div class="copyright py-4 text-center text-white" id="letra">
        <div class="container"><small>Plazoleta © Tu sitio web 2020</small></div>
      </div>
      <!-- Bootstrap core JavaScript-->
      <script src="../dashboard/vendor/jquery/jquery.min.js"></script>
      <script src="../dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="../dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="../dashboard/js/sb-admin-2.min.js"></script>
      <!-- Page level plugins -->
      <script src="../dashboard/vendor/chart.js/Chart.min.js"></script>
      <!-- Page level custom scripts -->
      <script src="../dashboard/js/demo/chart-area-demo.js"></script>
      <script src="../dashboard/js/demo/chart-pie-demo.js"></script>
      <script src="../dashboard/js/demo/chart-bar-demo.js"></script>
  </body>
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="fplaz">Cerrar sesión</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="pplaz">¿Seguro que quieres cerrar sesión?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <!-- Button trigger modal -->
          <a href="../Controladores/Cerrar_Sesion.php"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
              Cerrar sesión
            </button></a>
        </div>
      </div>
    </div>
  </div>
  <!--/Modal -->

  </html>
<?php
} else {
  echo "<script> document.location.href='/dashboard/404.php';</script>";
}
?>