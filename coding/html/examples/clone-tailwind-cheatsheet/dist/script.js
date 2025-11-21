const Entry = Vue.component("entry", {
  template: `
          <div class="table-row w-full h-auto bg-white">
            <slot name="pre-content"/>
            <div class="table-cell pr-4 text-purple-800 text-xs font-mono whitespace-no-wrap">{{tailwindClass}}</div>
            <slot name="between-content"/>
            <div class="table-cell text-blue-500 text-xs font-mono whitespace-no-wrap">{{explanation}}</div>
            <slot name="post-content"/>
          </div>
        `,
  props: {
    tailwindClass: {
      type: String,
      default: "you forgot the class!"
    },
    explanation: {
      type: String,
      default: "you forgot the explanation!"
    }
  }
});

const PropertyHeader = Vue.component("property-header", {
  template: `
  <div class="w-full h-8 bg-gray-300 hover:bg-gray-200 py-1 px-2 text-sm flex justify-between items-center cursor-pointer">
        <span :class="titleColor">{{title}}</span>
        <div class="flex h-auto">
        <div><a class="bg-orange-400 text-xs text-white rounded-lg px-1" :href="docsLink">DOCS</a>
          </div>
        <i class="material-icons w-3 h-3 mr-2 ml-1 text-gray-700 fill-current cursor-pointer">keyboard_arrow_down</i>
        </div>
      </div>
`,
  props: {
    docsLink: {
      type: String,
      default: "#"
    },
    title: {
      type: String,
      default: "you forgot the title!"
    },
    titleColor: {
      type: String,
      default: "text-blue-500"
    }
  }
});

const PropertyInfo = Vue.component("property-info", {
  template: `
<div class="bg-blue-200 h-auto w-full p-2">
        <div class="flex justify-between">
          <span class="text-gray-800 text-base">{{propertyDescription}}</span>
          <div class="flex items-center cursor-pointer">
            <div class="arrow-up-big mr-1"></div>
          <div class="flex flex-col items-center">
          <div class="arrow-up"></div>
          <span class="sorter leading-none text-gray-500">AZ</span>
            <div class="arrow-down"></div>
          </div>
          </div>
        </div>
        <div class="overflow-y-auto mt-2">
          <div class="w-full table">
            <template v-for="(entry, index) in entries">
            <slot name="property-entry" :entry="entry">
            <entry :key="index" :tailwind-class="entry.tailwindClass" :explanation="entry.explanation"></entry>
            </slot>
            </template>
          </div>
        </div>
      </div>`,
  components: {
    Entry
  },
  props: {
    propertyDescription: {
      type: String,
      default: "you forgot the property description!"
    },
    entries: {
      type: Array,
      default: () => [
        {
          tailwindClass: "You forgot the entries!",
          explanation: "Please enter something"
        }
      ]
    }
  }
});

const Category = Vue.component("category", {
  template: `
    <div class="w-full h-auto p-3 bg-transparent">
    <div id="app" class="w-full h-full px-3 py-2 bg-gray-100 rounded">
      <div class="text-black text-base ml-2">{{categoryName}}</div>
<!--    separation line    -->
      <div class="w-full border-b border-gray-400 mt-1"></div>
      <template v-for="({ propertyHeader, propertyInfo }, index) in properties">
      <property-header :class="{'mt-2':index===0}" :title="propertyHeader.title" :title-color="propertyHeader.titleColor"></property-header>
      <property-info
        v-if="propertyInfo !== null"
        :property-description="propertyInfo.propertyDescription"
        :entries="propertyInfo.entries"
      >
      </property-info>
      </template>
    </div>
  </div>
  `,
  props: {
    categoryName: {
      type: String,
      default: "you forgot a category name!"
    },
    properties: {
      type: Array,
      default: () => [
        {
          propertyHeader: {
            title: "you forgot the properties prop!",
            titleColor: "text-red-700"
          },
          propertyInfo: {
            propertyDescription: "you forgot the properties prop!",
            entries: [
              {
                tailwindClass: "you forgot the properties prop!",
                explanation: "you forgot the properties prop!"
              }
            ]
          }
        }
      ]
    }
  }
});

const layoutCategory = {
  categoryName: "Layout",
  properties: [
    {
      propertyHeader: { title: "Breakpoints", titleColor: "text-gray-700" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: ".container", titleColor: "text-purple-600" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "display", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "float", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "object-fit", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "object-position", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "overflow", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "position", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: {
        title: "top, right, bottom, left",
        titleColor: "text-blue-500"
      },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "visibility", titleColor: "text-blue-500" },
      propertyInfo: null
    },
    {
      propertyHeader: { title: "z-index", titleColor: "text-blue-500" },
      propertyInfo: null
    }
  ]
};

function makeObject(title) {
  return {
    propertyHeader: { title, titleColor: "text-blue-700" },
    propertyInfo: null
  };
}

const bordersCategory = {
  categoryName: "Borders",
  properties: [
    "border-color",
    "border-style",
    "border-width",
    "border-radius"
  ].map(makeObject)
};

const sizingCategory = {
  categoryName: "Sizing",
  properties: [
    "width",
    "min-width",
    "max-width",
    "height",
    "min-height",
    "max-height"
  ].map(makeObject)
};

const miscellaneousCategory = {
  categoryName: "Miscellaneous",
  properties: ["box-shadow", "opacity", "fill", "stroke"].map(makeObject)
};

const typographyCategory = {
  categoryName: "Typography",
  properties: [
    "color",
    "font-family",
    "font-size",
    "font-smoothing",
    "font-style",
    "font-weight",
    "letter-spacing",
    "line-height",
    "list-style-type",
    "list-style-position",
    "::placeholder color",
    "text-align",
    "text-decoration",
    "text-transform",
    "vertical-align",
    "white-space",
    "word-break"
  ].map(makeObject)
};

const flexboxCategory = {
  categoryName: "Flexbox",
  properties: [
    "display",
    "flex-direction",
    "flex-wrap",
    "align-items",
    "align-content",
    "align-self",
    "justify-content",
    "flex",
    "flex-grow",
    "flex-shrink",
    "order"
  ].map(makeObject)
};

const tableCategory = {
  categoryName: "Tables",
  properties: ["border-collapse", "table-layout"].map(makeObject)
};

const backgroundsCategory = {
  categoryName: "Backgrounds",
  properties: [
    "background-attachment",
    "background-color",
    "background-position",
    "background-repeat",
    "background-size"
  ].map(makeObject)
};

const spacingCategory = {
  categoryName: "Spacing",
  properties: ["padding", "margin"].map(makeObject)
};

const interactivityCategory = {
  categoryName: "Interactivity",
  properties: [
    "appearance",
    "cursor",
    "outline",
    "pointer-events",
    "resize",
    "user-select",
    "accessibility"
  ].map(makeObject)
};

new Vue({
  el: "#app",
  components: {
    Entry,
    PropertyHeader,
    PropertyInfo,
    Category
  },
  data() {
    return {
      categories: [
        layoutCategory,
        typographyCategory,
        backgroundsCategory,
        bordersCategory,
        flexboxCategory,
        spacingCategory,
        sizingCategory,
        tableCategory,
        interactivityCategory,
        miscellaneousCategory
      ]
    };
  },
  methods:{
    slice2(index){
      return this.categories.slice((index-1) * 5, Math.min(index*5, this.categories.length))
    },
    slice3(index){
      return this.categories.slice((index-1) * 4, Math.min(index*4, this.categories.length))
    }
  }
});