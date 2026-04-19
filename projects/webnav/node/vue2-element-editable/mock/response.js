class Response {
  status;
  data;
  result(status, data) {
    return { status, data };
  }
  100(data) {}
  200(data) {
    return this.result(200, data);
  }
  300(data) {}
  400(data) {}
  list() {}
  tree() {}
  info() {}
}
