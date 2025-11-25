

(function () {
  "use strict";
  const params = {};

  for (let pair of new URLSearchParams(document.querySelector('script[data-main]').getAttribute('data-main').split('?')[1]).entries()) {
    const [key, value] = pair;
    params[key] = value;
  }

  console.log(params);

  const app = document.querySelector("#app")
  const innerHTML = app.innerHTML;
  if (params['loading'] !== 'false') {
    app.innerHTML = `
  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24%" style="display: block; margin: 0 auto; margin-top: calc(50vh - 15%);" viewBox="0 0 24 30" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                <rect x="0" y="13" width="4" height="5" fill="#333">
                    <animate attributeName="height" attributeType="XML"
                        values="5;21;5"
                        begin="0s" dur="0.6s" repeatCount="indefinite" />
                    <animate attributeName="y" attributeType="XML"
                        values="13; 5; 13"
                        begin="0s" dur="0.6s" repeatCount="indefinite" />
                </rect>
                <rect x="10" y="13" width="4" height="5" fill="#333">
                    <animate attributeName="height" attributeType="XML"
                        values="5;21;5"
                        begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                    <animate attributeName="y" attributeType="XML"
                        values="13; 5; 13"
                        begin="0.15s" dur="0.6s" repeatCount="indefinite" />
                </rect>
                <rect x="20" y="13" width="4" height="5" fill="#333">
                    <animate attributeName="height" attributeType="XML"
                        values="5;21;5"
                        begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                    <animate attributeName="y" attributeType="XML"
                        values="13; 5; 13"
                        begin="0.3s" dur="0.6s" repeatCount="indefinite" />
                </rect>
            </svg>`;
  }
  // console.log(`app`, app, innerHTML);


  window.$data = {};
  window.$config = {};
  fetch("https://cdn.jsdelivr.net/gh/langnang/storage/data/main.json")
    .then(res => res.json())
    .then(res => {
      // console.log(`fetch`, res['requirejs']);
      const $main = $data['main'] = res;
      requirejs.config(res['requirejs'] || {})

      const $shim = res['requirejs']['shim'];
      // console.log($shim);
      for (let key in res['requirejs']['define'] || {}) {
        const $define = res['requirejs']['define'][key];
        define('$' + key, $define, function (...args) {
          // console.log(args);
          for (let index in $define) {
            if ($shim[$define[index]] && $shim[$define[index]]['exports']) {
              // console.log($define[index]);
              window[$shim[$define[index]]['exports']] = args[index]
            }
          }
          // console.log(Handlebars);
          //       $("#app").html(`<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
          //   <div class="spinner-border" role="status" style="width: 5rem; height: 5rem;">
          //     <span class="sr-only">Loading...</span>
          //   </div>


          // </div>

          // <div class="progress" style="height:3rem;">
          //   <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
          // </div>
          // `);
          if (params['loading'] !== 'false') {
            app.innerHTML = innerHTML;
          }
          require([`css!${location.href}/../style.css`, `${location.href}/../script.js`])
          return [...args];
        })
      }



      // console.log(params)
      // 'json!/storage/data/webnav.json'
      if (params['title']) {
        window.$config = $data['main']['contents'][params['title']]['config'] || {};
      }
      if (window.$config) require([...($data['main']['contents'][params['title']]['_data'] || []).map(v => `json!/storage/data/${v}.json`), '$' + window.$config['template']], function (...args) {
        console.log(args);
        ($data['main']['contents'][params['title']]['_data'] || []).forEach((v, i) => {
          window.$data[v] = args[i]
        })
        if (window.Handlebars) require(["/storage/js/handlebars.config.js"])
      })

    })

})()