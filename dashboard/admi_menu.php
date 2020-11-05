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
?><?php require_once 'navbar_dashboard.php'; ?>
<?php
    //Llamar a la conexion base de datos
    include_once '../dao/conexion.php';
    //Mostrar los datos almacenados
    $sql_mostrar = "SELECT * FROM tbl_menu";
    //Prepara sentencia
    $Consultar_mostrar = $pdo->prepare($sql_mostrar);
    //Ejecutar consulta
    $Consultar_mostrar->execute();
    $resultado_mostrar = $Consultar_mostrar->fetchAll();
    //Imprimir var dump -> Arreglos u objetos

    //Mostrar o traer los campos del editar
    if ($_GET) {
      //Captura el id del usuario a editar
      $id = $_GET['id'];
      //Sentencia sql para mostrar
      $sql_editar = "SELECT * FROM tbl_menu WHERE idplato=?";
      //Preparar consulta
      $consulta_editar = $pdo->prepare($sql_editar);
      //Ejecutar consulta
      $consulta_editar->execute(array($id));
      $resultado_editar = $consulta_editar->fetch();
      //Mostrar prueba
      //var_dump($resultado_editar);
    }
?>
<!---FORMULARIO DE REGISTRO-->
<?php if (!$_GET) { ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 align="center" class="m-0 font-weight-bold text-primary">Menú</h4>
    </div><br><br>
    <a align="center" href="../menu.php?id=<?php echo $_SESSION["correo_usu"]; ?>">Ir al menú</a>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <form class="form-signin" action="../upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-label-group">
                  <input type="text" id="inputNombre" name="plato" class="form-control" placeholder="Plato" required autofocus>
                  <label for="inputNombre">Plato</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputDescripcion" name="descripcion" class="form-control" placeholder="Descripción" required>
                  <label for="inputDescripcion">Descripción</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputPrecio" name="precio" class="form-control" placeholder="Precio" required>
                  <label for="inputPrecio">Precio</label>
                </div>
                <div class="form-label-group">
                  <input type="file" id="inputFoto" name="file" class="form-control-file" placeholder="Foto" required>
                </div>
                <div class="form-label-group">
                  <select name="tiplato" class="form-control" required>
                    <option value="" disabled selected>Seleccione un tipo de plato</option>
                    <option value="1">Especial de dia</option>
                    <option value="2">Entradas</option>
                    <option value="3">Platos fuertes</option>
                    <option value="4">Bebidas</option>
                    <option value="5">Menú infantil</option>
                  </select>
                  <br>
                  <button class="btn btn-primary btn-xs" type="submit">Registrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<?php if ($_GET) { ?>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 align="center" class="m-0 font-weight-bold text-primary">Menú</h4>
    </div><br><br>
    <a align="center" href="../menu.php?id=<?php echo $_SESSION["correo_usu"]; ?>">Ir al menú</a>
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <form class="form-signin" action="actualizar_menu.php" method="GET">
                <div class="form-label-group">
                  <input type="text" id="inputPlato" name="plato" class="form-control" placeholder="Plato" value="<?php echo $resultado_editar['plato']; ?>" required autofocus>
                  <label for="inputPlato">Plato</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputDescripcion" name="descripcion" class="form-control" placeholder="Descripción" value="<?php echo $resultado_editar['descripcion_plato']; ?>" required>
                  <label for="inputDescripcion">Descripción</label>
                </div>
                <div class="form-label-group">
                  <input type="text" id="inputPrecio" name="precio" class="form-control" placeholder="Precio" value="<?php echo $resultado_editar['precio_plato']; ?>" required>
                  <label for="inputPrecio">Precio</label>
                </div>
                <div class="form-label-group">
                  <input type="hidden" id="inputId" name="id_editar" value="<?php echo $resultado_editar['idplato']; ?>" required>
                </div>
                <div class="form-label-group">
                  <br>
                  <button class="btn btn-primary btn-xs" type="submit">Editar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<br>
<br>
<!---**************************** -->
<!---Tabla de menu -->
<h4 align="center" class="m-0 font-weight-bold text-primary">Especial del día</h4>
<br>
<table class="table table-bordered">
  <thead>
    <tr align="center">
      <th Style="border: 2px solid black">Plato</th>
      <th Style="border: 2px solid black">Descripción</th>
      <th Style="border: 2px solid black">Precio</th>
      <th Style="border: 2px solid black">Foto</th>
      <th Style="border: 2px solid black">Tipo de plato</th>
      <th Style="border: 2px solid black">Eliminar</th>
      <th Style="border: 2px solid black">Editar</th>
    <tr>
  </thead>

  <tbody>
    <?php foreach ($resultado_mostrar as $datos) {
      if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 1) { ?>
        <tr align="center">
          <td Style="border: 2px solid black"><?php echo $datos['plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['descripcion_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['precio_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['url_foto']; ?></td>
          <?php if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 1) {
          ?>
            <td Style="border: 2px solid black">Especial del dia</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 2) {
          ?>
            <td Style="border: 2px solid black">Entradas</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 3) {
          ?>
            <td Style="border: 2px solid black">Platos fuertes</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 4) {
          ?>
            <td Style="border: 2px solid black">Bebidas</a></td>
          <?php } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 5) {
          ?>
            <td Style="border: 2px solid black">Menú infantil</a></td>
          <?php } ?>
          <td Style="border: 2px solid black"><a data-toggle="modal" data-target="#confirmarborrarplato">
              <button class="btn btn-primary btn-xs" type="submit">Eliminar</button></a></td>
          <td Style="border: 2px solid black"><a href="admi_menu.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Editar</button></a></td>
        </tr>
    <?php }
    } ?>

  </tbody>
  <br>
</table>
<h4 align="center" class="m-0 font-weight-bold text-primary">Entradas</h4>
<br>
<table class="table table-bordered">
  <thead>
    <tr align="center">
      <th Style="border: 2px solid black">Plato</th>
      <th Style="border: 2px solid black">Descripción</th>
      <th Style="border: 2px solid black">Precio</th>
      <th Style="border: 2px solid black">Foto</th>
      <th Style="border: 2px solid black">Tipo de plato</th>
      <th Style="border: 2px solid black">Eliminar</th>
      <th Style="border: 2px solid black">Editar</th>
    <tr>
  </thead>
  <tbody>
    <?php foreach ($resultado_mostrar as $datos) {
      if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 2) { ?>
        <tr align="center">
          <td Style="border: 2px solid black"><?php echo $datos['plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['descripcion_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['precio_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['url_foto']; ?></td>
          <?php if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 1) {
          ?>
            <td Style="border: 2px solid black">Especial del dia</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 2) {
          ?>
            <td Style="border: 2px solid black">Entradas</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 3) {
          ?>
            <td Style="border: 2px solid black">Platos fuertes</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 4) {
          ?>
            <td Style="border: 2px solid black">Bebidas</a></td>
          <?php } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 5) {
          ?>
            <td Style="border: 2px solid black">Menú infantil</a></td>
          <?php } ?>
          <td Style="border: 2px solid black"><a href="eliminar_plato.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Eliminar</button></a></td>
          <td Style="border: 2px solid black"><a href="admi_menu.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Editar</button></a></td>
        </tr>
    <?php }
    } ?>

  </tbody>
</table>
<h4 align="center" class="m-0 font-weight-bold text-primary">Platos fuertes</h4>
<br>
<table class="table table-bordered">
  <thead>
    <tr align="center">
      <th Style="border: 2px solid black">Plato</th>
      <th Style="border: 2px solid black">Descripción</th>
      <th Style="border: 2px solid black">Precio</th>
      <th Style="border: 2px solid black">Foto</th>
      <th Style="border: 2px solid black">Tipo de plato</th>
      <th Style="border: 2px solid black">Eliminar</th>
      <th Style="border: 2px solid black">Editar</th>
    <tr>
  </thead>

  <tbody>
    <?php foreach ($resultado_mostrar as $datos) {
      if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 3) { ?>
        <tr align="center">
          <td Style="border: 2px solid black"><?php echo $datos['plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['descripcion_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['precio_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['url_foto']; ?></td>
          <?php if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 1) {
          ?>
            <td Style="border: 2px solid black">Especial del dia</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 2) {
          ?>
            <td Style="border: 2px solid black">Entradas</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 3) {
          ?>
            <td Style="border: 2px solid black">Platos fuertes</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 4) {
          ?>
            <td Style="border: 2px solid black">Bebidas</a></td>
          <?php } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 5) {
          ?>
            <td Style="border: 2px solid black">Menú infantil</a></td>
          <?php } ?>
          <td Style="border: 2px solid black"><a href="eliminar_plato.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Eliminar</button></a></td>
          <td Style="border: 2px solid black"><a href="admi_menu.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Editar</button></a></td>
        </tr>
    <?php }
    } ?>

  </tbody>
</table>
<h4 align="center" class="m-0 font-weight-bold text-primary">Bebidas</h4>
<br>
<table class="table table-bordered">
  <thead>
    <tr align="center">
      <th Style="border: 2px solid black">Plato</th>
      <th Style="border: 2px solid black">Descripción</th>
      <th Style="border: 2px solid black">Precio</th>
      <th Style="border: 2px solid black">Foto</th>
      <th Style="border: 2px solid black">Tipo de plato</th>
      <th Style="border: 2px solid black">Eliminar</th>
      <th Style="border: 2px solid black">Editar</th>
    <tr>
  </thead>

  <tbody>
    <?php foreach ($resultado_mostrar as $datos) {
      if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 4) { ?>
        <tr align="center">
          <td Style="border: 2px solid black"><?php echo $datos['plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['descripcion_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['precio_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['url_foto']; ?></td>
          <?php if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 1) {
          ?>
            <td Style="border: 2px solid black">Especial del dia</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 2) {
          ?>
            <td Style="border: 2px solid black">Entradas</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 3) {
          ?>
            <td Style="border: 2px solid black">Platos fuertes</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 4) {
          ?>
            <td Style="border: 2px solid black">Bebidas</a></td>
          <?php } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 5) {
          ?>
            <td Style="border: 2px solid black">Menú infantil</a></td>
          <?php } ?>
          <td Style="border: 2px solid black"><a href="eliminar_plato.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Eliminar</button></a></td>
          <td Style="border: 2px solid black"><a href="admi_menu.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Editar</button></a></td>
        </tr>
    <?php }
    } ?>

  </tbody>
</table>
<h4 align="center" class="m-0 font-weight-bold text-primary">Menú infantil</h4>
</h4>
<br>
<table class="table table-bordered">
  <thead>
    <tr align="center">
      <th Style="border: 2px solid black">Plato</th>
      <th Style="border: 2px solid black">Descripción</th>
      <th Style="border: 2px solid black">Precio</th>
      <th Style="border: 2px solid black">Foto</th>
      <th Style="border: 2px solid black">Tipo de plato</th>
      <th Style="border: 2px solid black">Eliminar</th>
      <th Style="border: 2px solid black">Editar</th>
    <tr>
  </thead>

  <tbody>
    <?php foreach ($resultado_mostrar as $datos) {
      if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 5) { ?>
        <tr align="center">
          <td Style="border: 2px solid black"><?php echo $datos['plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['descripcion_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['precio_plato']; ?></td>
          <td Style="border: 2px solid black"><?php echo $datos['url_foto']; ?></td>
          <?php if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 1) {
          ?>
            <td Style="border: 2px solid black">Especial del dia</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 2) {
          ?>
            <td Style="border: 2px solid black">Entradas</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 3) {
          ?>
            <td Style="border: 2px solid black">Platos fuertes</a></td>
          <?php
          } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 4) {
          ?>
            <td Style="border: 2px solid black">Bebidas</a></td>
          <?php } else if ($datos['tbl_tipo_plato_idtbl_tipo_plato'] == 5) {
          ?>
            <td Style="border: 2px solid black">Menú infantil</a></td>
          <?php } ?>
          <td Style="border: 2px solid black"><a href="confirmarborrarplato">
              <button class="btn btn-primary btn-xs" type="submit">Eliminar</button></a></td>
          <td Style="border: 2px solid black"><a href="admi_menu.php?id=<?php echo $datos['idplato']; ?>">
              <button class="btn btn-primary btn-xs" type="submit">Editar</button></a></td>
        </tr>
    <?php }
    } ?>

  </tbody>
</table>
</footer>
<!-- End of Footer -->

<!-- Modal -->
<div class="modal" id="modalmenu" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h5 class="fplaz">Se recomienda subir todas las fotos del menú con las mismas dimensiones para que todas queden parejas</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Cerrar</button>
      </div>
      <br>
    </div>
  </div>
</div>
<!--/Modal -->
<script>
  $(document).ready(function() {
    $("#modalmenu").modal("show");
  });
</script>

<!-- Modal -->
<div class="modal" id="fotoperfil" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img class=" card-img-top" src="../perfil/<?php echo $prueba->url_foto; ?>">
      </div>
      <center>
        <a href="perfil.php"><button type="button" class="btn btn-primary">
            <svg width="1.5em" height="1.5em" viewBox="0 0 17 16" class="bi bi-image" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M14.002 2h-12a1 1 0 0 0-1 1v9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V3a1 1 0 0 0-1-1zm-12-1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm4 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg></button>
        </a>
      </center>
      <br>
    </div>
  </div>
</div>
<!--/Modal -->
<!-- Modal para eliminar platos-->
<div class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <b>
          <p class="fplaz">¿Seguro quieres eliminar el plato?</p>
        </b>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="pplaz">Seleccione "Eliminar" a continuación si desea eliminar el plato seleccionado.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a href="eliminar_plato.php?id=<?php echo $datos['idplato']; ?>"><button type="button" class="btn btn-primary">Eliminar</button></a>
      </div>
    </div>
  </div>
</div>
<!--/Modal -->
<!-- Footer -->
<?php require_once 'footer_dashboard.php'; ?>
<?php
  } else {
    echo "<script> document.location.href='404.php';</script>";
  }
} else {
  echo "<script> document.location.href='404.php';</script>";
}

?>