import Vue from 'vue';
import Langnang from '../../modules/langnang';
import Element from '../../modules/element';


if (process.env === 'development') {
  import('../../../ui/src/scss/index.scss');
}


Vue.use(Langnang)
Vue.use(Element)
