import request from "@/utils/request";

export function getInfo(token) {
  return request({
    url: "/vue-element-admin/user/info",
    method: "get",
    params: { token: "admin-token" }
  });
}

export function logout() {
  return request({
    url: "/vue-element-admin/user/logout",
    method: "post"
  });
}

export function login(data) {
  return request({
    url: process.env.VUE_APP_PHP_API + "/user/login",
    method: "post",
    data
  });
}

// export function getInfo(data) {
//   return request({
//     url: process.env.VUE_APP_PHP_API + "/user/info",
//     method: "post",
//     data
//   });
// }

// export function logout() {
//   return request({
//     url: process.env.VUE_APP_PHP_API + "/user/logout",
//     method: "post"
//   });
// }
