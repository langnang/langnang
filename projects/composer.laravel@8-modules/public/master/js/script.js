if (window.axios) {
  // 添加一个请求拦截器
  axios.interceptors.request.use(
    function (config) {
      // Do something before request is sent
      // console.log(`axios.interceptors.request ~ then`, {
      //   config
      // })
      return config;
    },
    function (error) {
      // Do something with request error
      // console.log(`axios.interceptors.request ~ catch`, {
      //   error
      // })
      return Promise.reject(error);
    }
  );
  // 添加一个响应拦截器
  axios.interceptors.response.use(
    function (response) {
      // Do something with response data
      const { data } = response;
      // console.log(`axios.interceptors.response.use ~ then`, {
      //   data
      // })
      if (data.status === 200) {
        return data.data;
      } else {
        return Promise.reject(data);
      }
    },
    function (error) {
      // Do something with response error
      // console.log(`axios.interceptors.response.use ~ catch`, {
      //   error
      // })
      return Promise.reject(error);
    }
  );
}

$(function () {
  // $('[data-toggle="popover"]').popover({});
  // $('[data-toggle="tooltip"]').tooltip({});
  $('[lazy-url]').loadHtml({});
});

(function ($) {
  $.fn.loadHtml = function (options) {
    // console.log(this);
    this.each((index, ele,) => {
      lazyHtml = $(ele).attr('lazy-html');
      if (lazyHtml) {
        $(ele).html(lazyHtml)
      } else {
        lazyHtml = $(ele).html();
        $(ele).attr('lazy-html', lazyHtml);
      }
      // console.log(index, ele);
      //   $(ele).html(`
      //   <div class="d-flex h-100 justify-content-center align-items-center">
      //     <div class="spinner-grow" role="status">
      //       <span class="sr-only">Loading...</span>
      //     </div>
      //   </div>
      //  `);
      $(ele).load($(ele).attr('lazy-url'), function (response, status, xhr) {
        // console.log(status, response);
        if (status == "error") {
          var msg = "Sorry but there was an error: ";
          $(ele).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
    })
  };
})(jQuery);