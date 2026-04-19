import request from "@/plugins/axios";

export const insertItem = (data) =>
  request({ url: "/api/?/guide/insert_item", method: "post", data });

export const deleteItem = (data) =>
  request({ url: "/api/?/guide/delete_item", method: "post", data });
export const deleteList = (data) =>
  request({ url: "/api/?/guide/delete_list", method: "post", data });

export const updateItem = (data) =>
  request({ url: "/api/?/guide/update_item", method: "post", data });
export const updateList = (data) =>
  request({ url: "/api/?/guide/update_list", method: "post", data });

export const selectList = (data) =>
  request({ url: "/api/?/guide/select_list", method: "post", data });
export const selectTree = (data) =>
  request({ url: "/api/?/guide/select_tree", method: "post", data });

export const crawlerItem = (data) =>
  request({ url: "/api/?/guide/crawler_item", method: "post", data });

export const crawlerList = (data) =>
  request({ url: "/api/?/guide/crawler_list", method: "post", data });
