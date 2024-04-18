import { typechoOptionInfo, typechoOptionList } from "@/api/typecho";
const option = {
  prefix: null,
  contents: null,
  metas: null
};
const optionData = {
  option: { ...option },
  optionList: {
    loading: false,
    data: [],
    page: 1,
    size: 10,
    total: 0,
    multipleSelection: []
  }
};
const optionApis = { typechoOptionInfo, typechoOptionList };

const optionMethods = {
  selectOptionList() {
    this.optionList.loading = true;
    return typechoOptionList({ prefix: "*" })
      .then(res => {
        this.optionList.data = res.rows;
        this.optionList.total = res.total;
        return Promise.resolve(res);
      })
      .finally(() => {
        this.optionList.loading = false;
      });
  },
  selectOptionInfo() {
    return typechoOptionInfo().then(res => {
      this.option = res.rows;
      return Promise.resolve(res);
    });
  }
};
import mixinTypechoMeta from "./meta";
import mixinTypechoPost from "./post";
export default {
  mixins: [mixinTypechoMeta, mixinTypechoPost],
  data() {
    return {
      ...optionData
    };
  },
  computed: {},
  methods: {
    ...optionApis,
    ...optionMethods
  }
};
