import request from "@/plugins/axios";

export function getList(params) {
  return request({
    url: "/vue-element-webstack/table/list",
    method: "get",
    params,
  });
}
