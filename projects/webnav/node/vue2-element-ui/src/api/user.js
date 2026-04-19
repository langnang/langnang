import request from "@/plugins/axios";

export function login(data) {
  return request({
    url: "/api/?/typecho/user/login",
    method: "post",
    data,
  });
}

export function logout() {
  return request({
    url: "/vue-element-webstack/user/logout",
    method: "post",
  });
}

export function getUserInfo(token) {
  return request({
    url: "/vue-element-webstack/user/info",
    method: "get",
    params: { token },
  });
}
