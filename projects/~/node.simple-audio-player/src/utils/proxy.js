import request from "@/plugins/axios";


const proxy = data => request({
  method: "post",
  url: `/api/proxy`,
  data,
});


export default proxy
