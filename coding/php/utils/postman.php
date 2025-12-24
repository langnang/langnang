<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Php.Utils.Postman</title>

  <link href="https://fonts.font.im/css?family=Roboto" rel="stylesheet">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/normalize.css@8.0.1/normalize.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/animate.css@4.1.1/animate.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link crossorigin="anonymous" rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    .font-roboto {
      font-family: 'Roboto', sans-serif;
    }

    .bg-light--5 {
      background-color: rgba(245, 245, 245, 1);
    }
  </style>
  <link crossorigin="anonymous" rel="stylesheet" href="style.css">
</head>

<body class="bg-light--5 font-roboto">
  <div id="app" class="container-fluid">
    <h1 class="text-center">Php.Utils.Postman</h1>
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
    <footer class="fixed-bottom">
      <div class="container-fluid shadow-lg">
        <div class="alert alert-light text-center mb-0 py-2 small">
          Created with <span class="text-danger">❤️</span> with <a href="https://bootcss.com/">bootstrap</a>, <a href="https://vuejs.org/">vuejs</a> &amp; <a href="https://fontawesome.com/">font awesome</a> // Fork me on <a href="https://github.com/langnang/langnang"><i class="bi bi-github"></i></a>
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