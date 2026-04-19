const iFrameOnLoad = (element) => {
  console.log(`iFrameOnLoad`, element);
  var ifm = document.getElementById(element.id);
  var subWeb = document.frames ? document.frames[iframe.id].document : ifm.contentDocument;
  if (ifm != null && subWeb != null) {
    var ifmHeight = subWeb.body.scrollHeight;
    var ifmWidth = subWeb.body.scrollWidth;
    if (ifmHeight < 400) {
      ifm.height = 400;
      ifm.width = ifmWidth;
    } else {
      ifm.height = ifmHeight;
      ifm.width = ifmWidth;
    }

  }
}

const imgLoadError = (element) => {
  console.log(`imgLoadError`, element);
}
// $(document).on('click', '.nav-item', function (element) {
//   // console.log(`click .list-group-item`, element)
//   const src = $(element.target).attr('data-src');
//   // console.log(`click .list-group-item`, src)
//   $('#iframe').attr('src', src)
//   // console.log($(element.target).removeClass('active'))
//   $('#sidebarMenu .nav-link').removeClass('active')
//   $(element.target).addClass('active')
// })

Vue.component('container', {
  props: ['active', 'frames'],
  data: () => ({}),
  template: `
      <div class="row" style="height: calc(100vh - 62px + 57px);">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <h3 class="text-center pt-2 pb-0 mb-0">WebFrame</h3>
        <div class="sidebar-sticky pt-3">
          <div v-for="(item,index) in frames.filter(v=>v.visible!==false)" :key="index" :class="{'d-none':item.visible===false}">
            <h6 v-if="item.title" class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
              <span>{{item.title}}</span>
            </h6>
            <ul class="nav flex-column pl-2">
              <li v-for="site in item.children" :class="{'nav-item':true,}" @click="handleActive(site)">
                <a :class="{'nav-link py-1':true,'active':site.url==active,'d-none':site.visible===false,'disabled':site.disabled==true}" :data-src="site.url">
                  <img class="nav-ico" :src="site.ico||site.url+'/favicon.ico'" onerror="imgLoadError(this)">
                  <span> {{site.title}} </span>
                </a>
              </li>
            </ul>

          </div>
        </div>
      </nav>
      <div class="col-md-9 ml-sm-auto col-lg-10 px-0">
        <iframe id="iframe" class="w-100 h-100" :src="active" frameborder="0" onload="iFrameOnLoad(this)"></iframe>
      </div>
    </div>
        
  `,
  methods: {
    handleActive(item) {
      this.$emit('click', item)
    }
  },
})

const app = new Vue({
  el: "#app",
  data: {
    active: "",
    frames: [],
  },
  computed: {
    sidebar() {
      let html;
      console.log(`sidebar`, this.frames)
      if (this.frames.length == 0) return '';
      if (this.frames[0].type == 'site') {
        html = '';
      } else if (this.frames[0].type == 'group') {
        html = '';
      }
      return '';
    }
  },
  created() {
    this.fetchData();
  },
  methods: {
    handleActive(site) {
      if (site.disabled) return;
      console.log(`handleActive`, site);
      this.active = site.url;
    },
    fetchData() {
      // const url = "https://cdn.jsdelivr.net/gh/langnang/storage/data/webframe.json";
      const url = "https://raw.gitmirror.com/langnang/storage/master/data/webframe.json";
      fetch(url).then(res => res.json()).then(res => {
        console.log(`fetchData`, location, res)
        const { active, frames } = res[location.origin];
        this.active = active;
        this.frames = frames;
      })
    }
  }
})