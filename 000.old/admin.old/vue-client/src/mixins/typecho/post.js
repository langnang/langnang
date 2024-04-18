import { typechoPostInsert, typechoPostDelete, typechoPostUpdate, typechoPostInfo, typechoPostList } from "@/api/typecho";
// 文章
const post = {
  cid: null,
  title: null,
  slug: null,
  created: null,
  modified: null,
  text: null,
  order: null,
  authorId: null,
  template: null,
  type: null,
  status: null,
  password: null,
  commentsNum: null,
  allowComment: null,
  allowPing: null,
  allowFeed: null,
  parent: null,
  metas: [],
  fields: []
};
const postData = {
  post: { ...post },
  postList: {
    func: typechoPostList,
    queryParams: {},
    loading: false,
    data: [],
    columns: [
      { type: "selection", width: 45 },
      { prop: "cid", label: "编号", width: 80 },
      { prop: "title", label: "标题", width: 180 }
    ],
    page: 1,
    size: 10,
    total: 0,
    multipleSelection: []
  }
};
const postApis = {
  typechoPostInsert,
  typechoPostDelete,
  typechoPostUpdate,
  typechoPostInfo,
  typechoPostList
};
const postMethods = {
  resetPost() {
    this.post = { ...post };
  },
  insertPost(post) {
    if (!post) {
      post = this.post;
    }
    return typechoPostInsert(post).then(res => {
      this.$message.success("新增成功");
      return Promise.resolve(res);
    });
  },
  deletePostList(rows) {
    // const vm = this;
    if (!rows) {
      rows = this.postList.multipleSelection;
    }
    const cids = rows.map(v => v.cid);

    return this.$confirm("此操作将永久删除所选文章, 是否继续?", "提示", {
      confirmButtonText: "确定",
      cancelButtonText: "取消",
      type: "warning"
    })
      .then(() => {
        return new Promise((resolve, reject) => {
          return typechoPostDelete({ cids }).then(res => {
            if (res.total === cids.length) {
              this.$message.success(`删除成功`);
            } else {
              // 单条删除下，提示相应信息
              if (cids.length === 1) {
                this.$message.error(res.rows[0]);
              } else {
                this.$message.error(`${cids.length - res.total} 条数据删除失败`);
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
  updatePost(post) {
    if (!post) {
      post = this.post;
    }
    return typechoPostUpdate(post).then(res => {
      this.$message.success("修改成功");
      return Promise.resolve(res);
    });
  },
  selectPost({ cid, prefix }) {
    if (!cid) {
      cid = this.post.cid;
    }
    return typechoPostInfo({ cids: [cid], prefix }).then(res => {
      this.post = res.rows[0];
      return Promise.resolve(res);
    });
  },
  selectPostList() {
    this.postList.loading = true;
    return this.postList
      .func({
        ...this.postList.queryParams,
        page: this.postList.page,
        size: this.postList.size
      })
      .then(res => {
        this.postList.data = res.rows;
        this.postList.page = res.page;
        this.postList.size = res.size;
        this.postList.total = res.total;
        return Promise.resolve(res);
      })
      .finally(() => {
        this.postList.loading = false;
      });
  },
  handlePostListSelectionChange(val) {
    this.postList.multipleSelection = val;
  },
  handlePostListSizeChange(val) {
    this.postList.size = val;
    this.selectPostList();
  },
  handlePostListCurrentChange(val) {
    this.postList.size = val;
    this.selectPostList();
  }
};
export default {
  data() {
    return {
      ...postData
    };
  },
  computed: {},
  methods: {
    ...postApis,
    ...postMethods
  }
};
