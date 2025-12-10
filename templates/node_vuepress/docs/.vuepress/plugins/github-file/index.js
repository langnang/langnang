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
          let filePath = file.join('/')
          let snippets = [];
          if (filePath.indexOf(`{`) !== -1) {
            snippets = filePath.slice(filePath.indexOf(`{`) + 1, -1).split(',')
            console.log(snippets)
            filePath = filePath.slice(0, filePath.indexOf(`{`))
          }
          const url = `https://api.github.com/repos/${user}/${repo}/contents/${filePath}?ref=${branch}`;
          console.log(`[GET GitHub File] ${url}`)
          return axios.get(encodeURI(url)).then(res => Promise.resolve({ line: path, snippets, ...res.data }))
        })).then(res => {
          res.forEach(item => {
            let _content = Buffer.from(item.content, item.encoding).toString('utf8')
            if (item.snippets.length !== 0) {
              // 提取代码片段
              const content = _content.split('\n');
              _content = item.snippets.map(inteval => {
                inteval = inteval.split('-').map(v => Number(v))
                return content.slice(inteval[0], inteval[1] || inteval[0] + 1).join('\n');
              }).join('\n...\n')
            }
            page._content = page._content.replace(item.line, `${_content}\r\n`)
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
