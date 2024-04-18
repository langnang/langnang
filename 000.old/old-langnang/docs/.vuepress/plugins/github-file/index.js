const { path } = require('@vuepress/shared-utils');
const axios = require('axios');

const plugin = (options = {}, ctx) => {
  const {
    isDebugger, // Debugger
    isConsole, // 控制台打印
    syncLocal, // 同步到本地
    asyncKey = "github-file",
  } = options;

  return {
    name: '@langnang/vuepress-plugin-github-file',
    async additionalPages(app) {
      const { base, ClientComputedMixinm, isProd, markdown, options, pages } = app;
      let addPages = [];
      // 查找所有含有关键词的文件
      await axios.all(pages.filter(page => page._content.indexOf('<<< @github-file/') > -1).map(async page => {
        // 查找所有含有关键词的行
        const files = page._content.split('\r\n').filter(line => /^<<< @github-file/.test(line))
        await axios.all(files.map(path => {
          const [user, repo, blob, branch, ...file] = path.substr('<<< @github-file/'.length).split('/');
          const filePath = file.join('/')
          const url = `https://api.github.com/repos/${user}/${repo}/contents/${filePath}?ref=${branch}`;
          console.log(`[GET GitHub File] ${url}`)
          return axios.get(encodeURI(url)).then(res => Promise.resolve({ line: path, ...res.data }))
        })).then(res => {
          res.forEach(item => {
            page._content = page._content.replace(item.line, `${Buffer.from(item.content, item.encoding).toString('utf8')}\r\n`)
          });
        })
        return {
          ...page,
          content: page._content
        };
      })).then(res => {
        addPages = res
      })
      return addPages;
    },
  };
};

module.exports = plugin;
