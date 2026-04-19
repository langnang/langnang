new Vue({
  el: "#app",
  data: {
    navs: [],
    contents: [],
    metas: [],
    activeIndex: 0,
  },
  computed: {
    sides() {
      let result = [];
      result = this.metas[this.activeIndex] ?? [];
      result = result['children'] ?? [];
      console.log(`[computed] ~ sides`, { result })
      return result;
    }
  },
  watch: {
    "window.location.hash": {
      handler(newVal, oldVal) {
        console.log(`[watch] location.hash`, newVal, oldVal)
      },
      deep: true,
      immediate: true
    }
  },
  created() {
    this.fetchData();
  },
  mounted() {

  },
  updated() {
    console.log(`[updated]`)
    const observer = lozad();
    observer.observe();
    $('[data-toggle="tooltip"]').tooltip()
  },
  methods: {
    fetchData() {
      fetch("./../.storage/appdata.json")
        .then(response => response.json()) // 将响应转换为JSON格式
        .then(res => {
          data = res; // 将JSON数据存储到变量中
          console.log(data); // 在控制台中打印JSON数据
          const { metas, contents } = res;
          this.metas = [...metas];
          this.contents = [...contents];
          console.log(this)

          // console.log($('[role=navigation]').html(``))
          this.handleClickNavItem();
        })
        .catch(error => {
          // console.error('Error fetching JSON data:', error); // 如果发生错误，打印错误信息
        });
    },
    handleClickNavItem(hash = null) {
      hash = hash ?? window.location.hash
      const $index = hash.substr(1, 1) - 1;
      this.activeIndex = $index;
      console.log(`handleClickNav`, { hash, $index })
    },
    getRelationships(table, key, value) {
      return table.filter(v => v[key].includes(value))
    }
  },
});