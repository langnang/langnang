import { typechoMetaInsert, typechoMetaDelete, typechoMetaUpdate, typechoMetaTypeList, typechoMetaInfo, typechoMetaList, typechoMetaTree } from "@/api/typecho";
// 标识
const meta = {
  mid: null,
  name: null,
  slug: null,
  type: null,
  description: null,
  count: null,
  order: null,
  parent: null
};
const metaData = {
  meta: { ...meta },
  metaTypeList: {
    loading: false,
    data: [],
    total: 0,
    multipleSelection: []
  },
  metaList: {
    func: typechoMetaList,
    queryParams: {},
    columns: [],
    loading: false,
    data: [],
    page: 1,
    size: 10,
    total: 0,
    multipleSelection: []
  },
  metaTree: {
    func: typechoMetaTree,
    queryParams: {},
    loading: false,
    data: [],
    props: { children: "children", label: "name" },
    total: 0,
    multipleSelection: []
  }
};
const metaComputed = {
  metaTree_defaultCheckedKeys() {
    return this.metaTree.multipleSelection.map(v => v.mid);
  }
};
const metaApis = {
  typechoMetaInsert,
  typechoMetaDelete,
  typechoMetaUpdate,
  typechoMetaInfo,
  typechoMetaList,
  typechoMetaTree,
  typechoMetaTypeList
};
// 标识相关方法
const metaMethods = {
  resetMeta() {
    this.meta = { ...meta };
  },
  handleMetaListSelectionChange(val) {
    this.metaList.multipleSelection = val;
  },
  handleMetaTreeCheckChange(data, checked, indeterminate) {
    if (checked) {
      this.metaTree.multipleSelection.push(data);
    } else {
      const index = this.metaTree.multipleSelection.findIndex(v => v.mid === data.mid);
      this.metaTree.multipleSelection.splice(index, 1);
    }
  },
  // 新增标识
  insertMeta(meta = null) {
    if (!meta) {
      meta = this.meta;
    }
    return typechoMetaInsert(meta).then(res => {
      this.$message.success("新增成功");
      return Promise.resolve(res);
    });
  },
  // 批量删除标识
  deleteMetaList(rows) {
    if (!rows) {
      rows = this.metaList.multipleSelection;
    }
    const mids = rows.map(v => v.mid);

    return this.$confirm("此操作将永久删除所选标识, 是否继续?", "提示", {
      confirmButtonText: "确定",
      cancelButtonText: "取消",
      type: "warning"
    })
      .then(() => {
        return new Promise((resolve, reject) => {
          return typechoMetaDelete({ mids }).then(res => {
            if (res.total === mids.length) {
              this.$message.success(`删除成功`);
            } else {
              // 单条删除下，提示相应信息
              if (mids.length === 1) {
                this.$message.error(res.rows[0]);
              } else {
                this.$message.error(`${mids.length - res.total} 条数据删除失败`);
              }
            }
            resolve(res);
          });
        });
      })
      .catch(() => {
        this.$message.info("已取消删除");
      });
  },
  // 更新标识
  updateMeta(meta) {
    if (!meta) {
      meta = this.meta;
    }
    return typechoMetaUpdate(meta).then(res => {
      this.$message.success("修改成功");
      return Promise.resolve(res);
    });
  },
  selectMeta(mid) {
    if (!mid) {
      mid = this.meta.mid;
    }
    return typechoMetaInfo({ mids: [mid] }).then(res => {
      this.meta = res.rows[0];
      return Promise.resolve(res);
    });
  },
  selectMetaList() {
    this.metaList.loading = true;
    return this.metaList
      .func({
        ...this.metaList.queryParams,
        page: this.metaList.page,
        size: this.metaList.size
      })
      .then(res => {
        this.metaList.data = res.rows;
        this.metaList.page = res.page;
        this.metaList.size = res.size;
        this.metaList.total = res.total;
        return Promise.resolve(res);
      })
      .finally(() => {
        this.metaList.loading = false;
      });
  },
  handleMetaListSizeChange(val) {
    this.metaList.size = val;
    this.selectMetaList();
  },
  handleMetaListCurrentChange(val) {
    this.metaList.page = val;
    this.selectMetaList();
  },
  selectMetaTree() {
    this.metaTree.loading = true;
    return this.metaTree
      .func({
        ...this.metaTree.queryParams
      })
      .then(res => {
        this.metaTree.data = res.tree;
        this.metaTree.total = res.total;
        return Promise.resolve(res);
      })
      .finally(() => {
        this.metaTree.loading = false;
      });
  },
  // 查询标识类型列表
  selectMetaTypeList(data) {
    this.metaTypeList.loading = true;
    return typechoMetaTypeList(data)
      .then(res => {
        this.metaTypeList.data = res.rows;
        this.metaTypeList.total = res.total;
        return Promise.resolve(res);
      })
      .finally(() => {
        this.metaTypeList.loading = false;
      });
  }
};
export default {
  data() {
    return {
      ...metaData
    };
  },
  computed: {
    ...metaComputed
  },
  methods: {
    ...metaApis,
    ...metaMethods
  }
};
