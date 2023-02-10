# Rollup Template

[官网](https://rollupjs.org/) | [中文网](https://www.rollupjs.com/) | [Awesome](https://github.com/rollup/awesome)

## 配置

`rollup.config.js`

```js
export default {
  // 可以是一个数组（用于多个输入的情况）
  // 核心的输入选项
  external,
  input, // 必要项
  plugins,

  // 高级输入选项
  cache,
  onwarn,
  preserveEntrySignatures,
  strictDeprecations,

  // 危险区
  acorn,
  acornInjectPlugins,
  context,
  moduleContext,
  preserveSymlinks,
  shimMissingExports,
  treeshake,

  // 实验性
  experimentalCacheExpiry,
  perf,

  output: {
    // 必要项 (可以是一个数组，用于多输出的情况)
    // 核心的输出选项
    dir,
    file,
    format, // 必要项
    globals,
    name,
    plugins,

    // 高级输出选项
    assetFileNames,
    banner,
    chunkFileNames,
    compact,
    entryFileNames,
    extend,
    footer,
    hoistTransitiveImports,
    inlineDynamicImports,
    interop,
    intro,
    manualChunks,
    minifyInternalExports,
    outro,
    paths,
    preserveModules,
    sourcemap,
    sourcemapExcludeSources,
    sourcemapFile,
    sourcemapPathTransform,

    // 危险区
    amd,
    esModule,
    exports,
    externalLiveBindings,
    freeze,
    indent,
    namespaceToStringTag,
    noConflict,
    preferConst,
    strict,
    systemNullSetters,
  },

  watch:
    {
      buildDelay,
      chokidar,
      clearScreen,
      skipWrite,
      exclude,
      include,
    } | false,
};
```
