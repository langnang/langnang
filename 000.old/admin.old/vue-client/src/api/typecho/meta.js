import request from "@/utils/request";

export function typechoMetaInsert(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/insert",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function typechoMetaDelete(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/delete",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function typechoMetaUpdate(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/update",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function typechoMetaInfo(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/info",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function typechoMetaList(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/list",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function typechoMetaTree(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/tree",
      method: "POST",
      data
    },
    { loading: true }
  );
}

export function typechoMetaTypeList(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/typecho/meta/type",
      method: "POST",
      data
    },
    { loading: true }
  );
}
