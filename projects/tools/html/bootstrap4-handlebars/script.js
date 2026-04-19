$(document).ready(function () {

})


Handlebars.registerPartial('layoutHeader', `
<header id="layout-header">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#">{{title}}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto d-none">
              <li class="nav-item active">
                  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link disabled">Disabled</a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">Dropdown</a>
                  <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                  </div>
              </li>
          </ul>
          <form class="form-inline my-2 my-lg-0 d-none">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
      </div>
  </nav>
  <div class="jumbotron" style="padding:2rem;">
      <div class="container">
          <h1 class="display-4">{{titleCn}}（{{title}}）</h1>
          <p class="lead">{{titleCn}}（{{title}}）</p>
      </div>
  </div>
</header>

`);
Handlebars.registerPartial('layoutFooter', `
<footer id="layout-footer" class="container-fluid text-light bg-dark">
  <div class="container">
    <div class="row row-cols-3 py-1">
      <div class="col text-center"></div>
      <div class="col text-center">
        <h5 class="my-1">项目依赖</h5>
        <ul class="list-unstyled my-1">
          {{#each dependencies}}
          <li><a class="text-decoration-none" href="{{this.url}}">{{this.title}}</a></li>
          {{/each}}
        </ul>
      </div>
      <div class="col text-center">
        <h5 class="my-1">参考文献</h5>
        <ul class="list-unstyled my-1">
          {{#each references}}
          <li><a class="text-decoration-none" href="{{this.url}}">{{this.title}}</a></li>
          {{/each}}
        </ul>
      </div>
    </div>
  </div>
</footer>
`);


const getHbs = () => { }

function renderHeader(data) {
  new Promise(resolve => resolve($.get("./assets/header.hbs")))
    .then(res => {
      var template = Handlebars.compile(res);
      $('#header').html(template(data));
    })
  // $.get("./assets/header.hbs")
  // var template = Handlebars.compile("Handlebars <b>{{doesWhat}}</b>");

  // $('#header').html();
}
// const renderHeader = () => { }
function renderFooter() { }

function render(data) {
  const { title, description, references, dependencies } = data;
  let html = $("#app").html();
  html = html.replace(/\&gt;/g, ">")
  // console.log(html);
  var template = Handlebars.compile(html);
  // execute the compiled template and print the output to the console
  // console.log(template({ doesWhat: "rocks!" }));

  return new Promise(resolve => resolve($("#app").html(template({
    ...data,
    title: title || "Games",
    description: description || "...",
    dependencies: dependencies || [],
    references: references || [],
  }))))
}