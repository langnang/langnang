import DynamicSelect from './dynamic-select'
import DynamicTable from './dynamic-table'

import DynamicTableColumn from './dynamic-table-column'
import PageableSelect from './pageable-select'
import PageableTable from './pageable-table'
import RouteMenu from './route-menu'
const components = [
  DynamicSelect,
  DynamicTable,
  DynamicTableColumn,
  PageableSelect,
  PageableTable,
  RouteMenu,
];

const install = function (Vue, opts = {}) {// eslint-disable-line no-unused-vars
  components.forEach(component => {
    Vue.component(component.name, component);
  });
};

/* istanbul ignore if */
if (typeof window !== 'undefined' && window.Vue) {
  install(window.Vue);
}

export default {
  install,
  DynamicSelect,
  DynamicTable,
  DynamicTableColumn,
  PageableSelect,
  PageableTable,
  RouteMenu,
};