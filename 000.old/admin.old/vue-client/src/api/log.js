import request from "@/utils/request";

export function logList(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/log/list",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function logDelete(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/log/delete",
      method: "POST",
      data
    },
    { loading: true }
  );
}
export function logChannelList(data) {
  return request(
    {
      url: process.env.VUE_APP_PHP_API + "/log/channel",
      method: "POST",
      data
    },
    { loading: true }
  );
}
