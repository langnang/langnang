<?php

require_once __DIR__ . '/../helpers/request.php';

$config = parse_ini_file(__DIR__ . '/../.env', true);
// print_r($config);
$url = 'http://101.126.135.139:7500/api/proxy/tcp';
// $res = request(['url' => 'http://101.126.135.139:7500/api/proxy/tcp']);
$res = request_get($url, ['headers' => [
  "Authorization: Basic " . $config['FrpS']['TOKEN'], // 替换为实际的 Bearer Token
  "Content-Type: application/json"
]]);
$res = json_decode($res, JSON_UNESCAPED_UNICODE);

// var_dump($res);

foreach ($res['proxies'] as $proxy) {

  echo $proxy['name'] . PHP_EOL;
  echo $proxy['conf']['remotePort'] . PHP_EOL;
  // curlPing('http://101.126.135.139:' . $proxy['conf']['remotePort']);
  socketPing('101.126.135.139', $proxy['conf']['remotePort']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Php.Utils.FrpS</title>

  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/normalize.css@8.0.1/normalize.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/animate.css@4.1.1/animate.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link crossorigin="anonymous" rel="stylesheet" href="style.css">
</head>

<body>
  <div id="app" class="container-fluid">
    <h1 class="text-center">Php.Utils.FrpS</h1>
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
        <?php foreach ($res['proxies'] as $proxy): ?>
          <tr>
            <th scope="row">1</th>
            <td><?php echo $proxy['name'] ?></td>
            <td><?php echo $proxy['conf']['remotePort'] ?></td>
            <td>@mdo</td>
          </tr>
        <?php endforeach ?>
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
    <footer class="fixed-bottom">
      <div class="container-fluid shadow-lg">
        <div class="alert alert-light text-center mb-0 py-2 small">
          Created with <span class="text-danger">❤️</span> with <a href="https://bootcss.com/">bootstrap</a> &amp; <a href="https://fontawesome.com/">font awesome</a> // Fork me on <a href="https://github.com/langnang/langnang"><i class="bi bi-github"></i></a>
        </div>
      </div>
    </footer>
  </div>

  <script crossorigin="anonymous" src="https://unpkg.com/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/mockjs@1.1.0/dist/mock-min.js"></script>
  <script crossorigin="anonymous" src="https://unpkg.com/holderjs@2.9.9/holder.min.js"></script>

  <script crossorigin="anonymous" src="script.js"></script>
</body>

</html>