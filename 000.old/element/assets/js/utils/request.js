"use strict";
(function (define) {
  define(function (require, exports, module) {
    const axios = require("axios");
    let config = {
      // baseURL: process.env.baseURL || process.env.apiUrl || ""
      timeout: 60 * 1000, // Timeout
      // withCredentials: true, // Check cross-site Access-Control
    };

    const _axios = axios.create(config);

    _axios.interceptors.request.use(
      function (config) {
        // Do something before request is sent
        return config;
      },
      function (error) {
        // Do something with request error
        return Promise.reject(error);
      }
    );

    // Add a response interceptor
    _axios.interceptors.response.use(
      function (response) {
        // Do something with response data
        if (response.status === 200) {
          return response.data;
        } else {
          return Promise.reject(response.data);
        }
      },
      function (error) {
        // Do something with response error
        return Promise.reject(error);
      }
    );
    module.exports = _axios;
  });
})(define);
