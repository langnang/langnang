$(document).ready(function () {
  fetch("./../../.storage/appdata.json")
    .then(response => response.json()) // 将响应转换为JSON格式
    .then(res => {
      data = res; // 将JSON数据存储到变量中
      const { metas } = res;
      // console.log(data); // 在控制台中打印JSON数据

      // console.log($('[role=navigation]').html(``))
    })
    .catch(error => {
      // console.error('Error fetching JSON data:', error); // 如果发生错误，打印错误信息
    });
});