module.exports = {
  outputDir: 'dist',
  publicPath: process.env.NODE_ENV === 'production'
    ? '/ui/nodejs/pattle/'
    : '/',
  devServer: {
    port: 9503,// 自定义端口

  },
  chainWebpack: config => {
    config
      .plugin('html')
      .tap(args => {
        args[0].title = '调色板（离线缓存版）'// 自定义标题
        return args
      })
  }
}