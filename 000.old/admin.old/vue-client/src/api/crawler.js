import request from "@/utils/request";

export const crawlerPostTest = data => {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/crawler/test",
      method: "POST",
      data
    },
    { loading: true }
  );
};
export const crawlerPostInsert = data => {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/crawler/insert",
      method: "POST",
      data
    },
    { loading: true }
  );
};
export const crawlerPostDelete = data => {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/crawler/delete",
      method: "POST",
      data
    },
    { loading: true }
  );
};
export const crawlerPostUpdate = data => {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/crawler/update",
      method: "POST",
      data
    },
    { loading: true }
  );
};
export const crawlerPostList = data => {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/crawler/list",
      method: "POST",
      data
    },
    { loading: true }
  );
};

export const crawlerPostInfo = data => {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/crawler/info",
      method: "POST",
      data
    },
    { loading: true }
  );
};
