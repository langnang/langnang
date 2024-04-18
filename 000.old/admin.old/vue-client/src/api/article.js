import request from "@/utils/request";

export function fetchList(query) {
  return request(
    {
      url: "/vue-element-admin/article/list",
      method: "get",
      params: query
    },
    { loading: true }
  );
}

export function fetchArticle(id) {
  return request(
    {
      url: "/vue-element-admin/article/detail",
      method: "get",
      params: { id }
    },
    { loading: true }
  );
}

export function fetchPv(pv) {
  return request(
    {
      url: "/vue-element-admin/article/pv",
      method: "get",
      params: { pv }
    },
    { loading: true }
  );
}

export function createArticle(data) {
  return request(
    {
      url: "/vue-element-admin/article/create",
      method: "post",
      data
    },
    { loading: true }
  );
}

export function updateArticle(data) {
  return request(
    {
      url: "/vue-element-admin/article/update",
      method: "post",
      data
    },
    { loading: true }
  );
}
