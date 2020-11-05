<?php
session_start();

if (isset($_SESSION["correo_usu"]) or isset($_SESSION["idusuario"])) {
  $id = $_SESSION["correo_usu"];
  include_once '../dao/conexion.php';
  $sql_inicio = "SELECT*FROM tbl_usuario WHERE correo_usu ='$id' AND estado_usu = '1' AND verificacion_usu = '1' ";
  $consulta_resta = $pdo->prepare($sql_inicio);
  $consulta_resta->execute();
  $resultado = $consulta_resta->rowCount();
  $prueba = $consulta_resta->fetch(PDO::FETCH_OBJ);
  //Validacion de roles
  if ($resultado) {
?>
    <?php require_once 'navbar_dashboard.php'; ?>
        <div class="card-header py-3">
          <h4 align="center" class="m-0 font-weight-bold text-primary">Configuración de cuenta</h4>
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
                <form class="form-signin" method=GET action="actualizar_cuenta.php">
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
<?php require_once 'footer_dashboard.php'; ?>
        <?php
      } else {
        echo "<script> document.location.href='404.php';</script>";
      }
    } else {
      echo "<script> document.location.href='404.php';</script>";
    }

        ?>