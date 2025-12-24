<?php
require_once __DIR__ . '/../helpers/request.php';

$config = parse_ini_file(__DIR__ . '/../.env', true);
print_r($config);
$url = 'http://' . $config['Cpolar::Desktop']['ADDR'] . ':9200/api/v1/tunnels';
var_dump($url);
socketPing($config['Cpolar::Desktop']['ADDR'], 9200);
// exit;


// $res = request(['url' => 'http://101.126.135.139:7500/api/proxy/tcp']);
$res = request_get($url, ['headers' => [
  "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjY2Mjc3ODAsImlhdCI6MTc2NjQ1NDk4MCwiVXNlcklEIjowLCJVc2VybmFtZSI6IiIsIkVtYWlsIjoibGFuZ25hbmcuY2hlbkBvdXRsb2suY29tIiwiQXBpU2VydmljZVRva2VuIjoiZXlKaGJHY2lPaUpJVXpJMU5pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmxlSEFpT2pFM05qWTJNamMzT0RBc0ltbGhkQ0k2TVRjMk5qUTFORGs0TUN3aVZYTmxja2xFSWpvME1ERTBOamdzSWxWelpYSnVZVzFsSWpvaWJHRnVaMjVoYm1jaUxDSkZiV0ZwYkNJNklteGhibWR1WVc1bkxtTm9aVzVBYjNWMGJHOXJMbU52YlNKOS4xUHVGTFltQnZsYmluR3hXVkV0Ykw4ZDYySEdPc0RCVFdZLV9fVHJNX1ZJIn0.KLWSHgigXtVtx1eIoWQZw-k-YwrbRgxUA8gr0XkDF5s",
  "Cookie: reader.session=3758bb61302a5ee2cc1b4b5770dc7dc1; vue_admin_template_token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjY2Mjc3ODAsImlhdCI6MTc2NjQ1NDk4MCwiVXNlcklEIjowLCJVc2VybmFtZSI6IiIsIkVtYWlsIjoibGFuZ25hbmcuY2hlbkBvdXRsb2suY29tIiwiQXBpU2VydmljZVRva2VuIjoiZXlKaGJHY2lPaUpJVXpJMU5pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmxlSEFpT2pFM05qWTJNamMzT0RBc0ltbGhkQ0k2TVRjMk5qUTFORGs0TUN3aVZYTmxja2xFSWpvME1ERTBOamdzSWxWelpYSnVZVzFsSWpvaWJHRnVaMjVoYm1jaUxDSkZiV0ZwYkNJNklteGhibWR1WVc1bkxtTm9aVzVBYjNWMGJHOXJMbU52YlNKOS4xUHVGTFltQnZsYmluR3hXVkV0Ykw4ZDYySEdPc0RCVFdZLV9fVHJNX1ZJIn0.KLWSHgigXtVtx1eIoWQZw-k-YwrbRgxUA8gr0XkDF5s",
  // "Authorization: Bearer " . $config['Cpolar::Desktop']['TOKEN'], // 替换为实际的 Bearer Token
  // "Content-Type: application/json"
]]);
var_dump($res);
$res = json_decode($res, JSON_UNESCAPED_UNICODE);
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
        <?php foreach ($res['data']['items'] as $tunnel): ?>
          <tr>
            <th scope="row">1</th>
            <td><?php echo $tunnel['id'] ?></td>
            <td><?php echo $tunnel['name'] ?></td>
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
          Created with <span class="text-danger">❤️</span> with <a href="https://bootcss.com/">bootstrap v4</a>, <a href="https://fontawesome.com/">font awesome</a> &amp; php v<?php echo phpversion() ?>
          // Fork me on <a href="https://github.com/langnang/langnang"><i class="bi bi-github"></i></a>
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