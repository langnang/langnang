<?php
require_once __DIR__ . '/../helpers/ping.php';

$_title = "Php.Utils.Ping";
$_config = parse_ini_file(__DIR__ . '/../.env', true);
print_r($_config);

foreach ($_config as $_k => $_v) {
  if (empty($_v['addr'])) continue;
  var_dump($_k);
  var_dump($_v);
  if ($_v['ping'] == true) {
    socket_ping($_v['addr'], 9200);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__ . '/../components/head.php'  ?>
</head>

<body class="bg-light--5 font-roboto">
  <div id="app" class="container-fluid">
    <h1 class="text-center"><?php echo $_title; ?></h1>
    <form>
      <div class="form-group row">
        <label for="staticEmail" class="col-sm-1 col-form-label">M</label>
        <div class="col-sm-10">
          <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="inputPassword">
        </div>
      </div>
    </form>
    <table class="table table-sm table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Handle</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <th scope="row">2</th>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <th scope="row">3</th>
          <td>Larry</td>
          <td>the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </table>
    <?php require_once __DIR__ . '/../components/footer.php'  ?>

  </div>

  <?php require_once __DIR__ . '/../components/foot.php'  ?>

</body>

</html>