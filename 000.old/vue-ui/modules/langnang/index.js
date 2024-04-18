import AudioPlayer from './audio-player'
import Icon from './icon'
import Progress from './progress'
const components = [
  Icon,
  AudioPlayer,
  Progress,
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
  AudioPlayer,
  Icon,
  Progress
};