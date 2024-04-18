<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col v-for="(item, key) in iconOptions" :key="key" :span="6" align="center" style="margin-bottom: 20px; cursor: pointer">
        <el-card :shadow="active === key ? 'always' : 'hover'" @click.native="handleClickCol(key)">
          <LnBox :height="'30%'">{{ item.label }}</LnBox>
        </el-card>
      </el-col>
    </el-row>
    <component :is="'div'" class="grid">
      <div v-for="item of icons" :key="item" @click="handleClipboard(item, $event)">
        <el-tooltip placement="top">
          <div slot="content">
            {{ generateIconCode(item) }}
          </div>
          <div class="icon-item">
            <LnIcon :icon="item" />
            <span>{{ item }}</span>
          </div>
        </el-tooltip>
      </div>
    </component>
  </div>
</template>

<script>
// import svgIcons from './svg-icons';
import elementIcons from './element-icons';
import { fas, fab, far } from './fontawesome';
// import ComponentOptions from '@/components/Ln/Icon/options';
export default {
  name: 'Icons',
  components: {},
  data() {
    return {
      // ComponentOptions,
      active: '',
      icons: [],
      iconOptions: {
        // svg: { label: 'Svg Icons', children: svgIcons.map(v => 'svg-' + v) },
        element: { label: 'Element-UI Icons', children: elementIcons.map(v => 'el-icon-' + v) },
        fas: { label: 'FontAwesome Solid Icons', children: fas.map(v => 'fas-' + v) },
        fab: { label: 'FontAwesome Brands Icons', children: fab.map(v => 'fab-' + v) },
        far: { label: 'FontAwesome Regular Icons', children: far.map(v => 'far-' + v) },
      },
    };
  },
  methods: {
    generateIconCode(symbol) {
      return `<ln-icon icon="${symbol}" />`;
    },
  },
};
</script>

<style lang="scss" scoped>
.app-container {
  .grid {
    position: relative;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  }

  .icon-item {
    margin: 20px;
    height: 85px;
    text-align: center;
    width: 100px;
    float: left;
    font-size: 30px;
    color: #24292e;
    cursor: pointer;
  }

  span {
    display: block;
    font-size: 16px;
    margin-top: 10px;
  }

  .disabled {
    pointer-events: none;
  }
}
</style>
