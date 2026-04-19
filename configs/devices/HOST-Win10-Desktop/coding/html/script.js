(function () {
  let config;
  let components = {
    header: {
      handler(val) {}
    },
    icon: {},
    logo: {},
    card: {
      handler(val) {
        if (!val.name) return '';
        return `  <div class="col"><${val.url ? `a href="${val.url}" target="_blank"` : 'div'} class="card border-0 rounded--3 shadow text-decoration-none">
            <div class="card-body p-2">
            <div class="media">
            ${val.logo ? `  <img src="${val.logo}" class="align-self-center" alt="...">` : `${val.icon ? ` <i class="align-self-center ${val.icon || ''}"></i> ` : ''}`}

  <div class="media-body ml-2">
    <h5 class="card-title my-0">${val.name}</h5>
              <p class="card-text mt-2 small">${val.name}</p>
  </div>
</div>
            </div>
          </${val.url ? `a` : 'div'}> </div>`;
      }
    },
    cardGroup: {
      handler(val) {
        let $return = `<h3>${val.icon ? ` <i class="${val.icon || ''}"></i> ` : ''}${val.name}<small>${['All', ...(val.tags || [])].reduce((t, v) => t + `<span class="badge badge-pill badge-primary ml-2">${v}</span>`, '')}</small></h3>`;
        $return +=
          ` <div class="row row-cols-1 row-cols-md-${val.columns}">` +
          (val.items || [])
            .filter(v => v.name)
            .sort((a, b) => a.name.localeCompare(b.name, 'en'))
            .reduce((t, v) => t + renderComponent('card', v), '') +
          `</div>`;
        return $return;
      }
    }
  };
  function load(opts) {}
  function loadStyle(url, opts) {}
  function loadStyles(urls, opts) {}
  function loadScript(url, opts) {
    const script = document.createElement('script');
    script.src = 'example.js';
    document.body.appendChild(script);
  }
  function loadScripts(urls, opts) {
    console.log(`loadScripts`, urls);

    (urls || []).map(v => loadScript(v));
  }
  function render(opts) {
    const app = document.getElementById('app');
    console.log(`render`, app);
    app.setAttribute('class', `theme-${opts.theme || 'default'}`);
    renderHeader(opts);
    renderMain(opts);
    renderFooter(opts);
  }
  function renderHeader(opts) {
    const html = `<div class="container-fluid">
          <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded-top py-1">
            <a class="navbar-brand" href="#">Coding</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor02">
              <ul class="navbar-nav mr-auto">
              ${[{ name: 'Home' }, ...opts.children].reduce(
                (t, v) =>
                  t +
                  `<li class="nav-item">
                  <a class="nav-link" href="${v.url || ''}">${v.name}</a>
                </li>`,
                ``
              )}
              </ul>
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary"><i class="bi bi-list-ul"></i></button>
                <button type="button" class="btn btn-primary"><i class="bi bi-layout-split"></i></button>
                <button type="button" class="btn btn-primary"><i class="bi bi-window-split"></i></button>
              </div>
              <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
              </form>
            </div>
          </nav>
        </div>`;
    const elements = document.getElementsByTagName('header');
    if (elements && elements.length > 0) elements[0].innerHTML = html;
  }
  function renderMain(opts) {
    let html = `<div class="row row-cols-1 row-cols-md-4">
          <div class="col mb-4">
            <a class="card" href="./html/">
              <div class="card-body">
                <h5 class="card-title">HTML</h5>
                <p class="card-text"></p>
              </div>
            </a>
          </div>
          <div class="col mb-4">
            <a class="card" href="./html.bootstrap3/">
              <div class="card-body">
                <h5 class="card-title">Bootstrap3</h5>
                <p class="card-text"></p>
              </div>
            </a>
          </div>
          <div class="col mb-4">
            <a class="card" href="./html.bootstrap4/">
              <div class="card-body">
                <h5 class="card-title">Bootstrap4</h5>
                <p class="card-text"></p>
              </div>
            </a>
          </div>
          <div class="col mb-4">
            <a class="card" href="./html.bootstrap5/">
              <div class="card-body">
                <h5 class="card-title">Bootstrap5</h5>
                <p class="card-text"></p>
              </div>
            </a>
          </div>
        </div>
        <h2>html</h2>
        <div class="card-deck mb-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
        </div>
        <h2>html.bootstrap3</h2>
        <div class="card-deck mb-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
        </div>
        <h2>html.bootstrap4</h2>
        <div class="card-deck mb-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted">Last updated 3 mins ago</small>
            </div>
          </div>
        </div>`;
    html = `<div class="container-fluid">${opts.items.reduce((t, v) => t + renderComponent('cardGroup', { ...v, columns: opts.columns || 4 }), '')}</div>`;
    const elements = document.getElementsByTagName('main');
    if (elements && elements.length > 0) elements[0].innerHTML = html;
  }
  function renderComponent(name, opts) {
    return components[name].handler(opts);
  }
  function renderFooter(opts) {
    const html = `<div class="container-fluid">
          <div class="alert alert-dark text-center mb-0 py-2 small">
            Created with <span class="text-danger">❤️</span> with <a href="https://v4.bootcss.com/">bootstrap v4</a>, <a href="https://fontawesome.com/">font awesome</a> &amp; jquery // Fork me on
            <a href="https://github.com/langnang/langnang"><i class="bi bi-github"></i></a>
          </div>
        </div>`;
    const elements = document.getElementsByTagName('footer');
    if (elements && elements.length > 0) elements[0].innerHTML = html;
  }

  window.addEventListener('hashchange', function (e) {
    console.log(e);
    const currentTarget = e.currentTarget;
    const hash = currentTarget.location.hash;
    console.log(hash);
    console.log(config);
  });
  fetch('./config.yml')
    .then(res => res.text())
    .then(res => {
      console.log(res);
      const yaml = jsyaml.load(res);
      // console.log(res.body);
      // console.log(res.json());
      console.log(yaml);
      config = yaml;
      loadScripts(yaml.scripts);
      render(config);
    });
})();
