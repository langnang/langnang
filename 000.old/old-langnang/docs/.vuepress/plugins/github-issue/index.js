const { path } = require('@vuepress/shared-utils');
const axios = require('axios');

const ReprintArticlePlugin = (options = {}, ctx) => {
  const {
    isDebugger, // Debugger
    isConsole, // 控制台打印
    syncLocal, // 同步到本地
  } = options;

  return {
    name: 'vuepress-plugin-github-issue',
    async additionalPages(app) {
      const { base, ClientComputedMixinm, isProd, markdown, options, pages } = app;
      let addPages = [];
      const _pages = pages.filter((page) => page.frontmatter.reprintArticle);
      if (_pages.length == 0) {
        return addPages;
      }
      await axios
        .all(
          _pages.map((item) => {
            if (isDebugger) debugger;
            const { dirname, filename } = item;
            const reprintArticle = item.frontmatter.reprintArticle;
            const user = reprintArticle.github.user || dirname;
            if (!user || user == '') {
              return new Promise.resolve({
                ...item,
              });
            }
            const repo = {
              user,
              repo: reprintArticle.github.repo || user,
              branch: reprintArticle.github.branch || 'master',
              file: reprintArticle.github.file || 'README.md',
            };
            const url = encodeURI(`https://api.github.com/repos/${repo.user}/${repo.repo}/contents/${repo.file}?ref=${repo.branch}`);
            const filePath = `https://github.com/${repo.user}/${repo.repo}/blob/${repo.branch}/${repo.file}`;
            const footerTip = `

::: tip 转载声明：
转载自 [${repo.user}/${repo.repo}](${filePath})
:::


`;
            if (isConsole) console.log(`请求 ${filePath}`);
            return axios
              .get(url)
              .then((res) => {
                return Promise.resolve({
                  ...item,
                  _url: url,
                  file: res.data,
                  content: Buffer.from(res.data.content, 'base64').toString('utf8') + footerTip,
                  // path: decodeURI(item.path),
                  // regularPath: decodeURI(item.regularPath),
                  // relativePath: decodeURI(item.relativePath),
                });
              })
              .catch((err) => {
                return Promise.reject({
                  ...item,
                  _url: url,
                });
              });
          })
        )
        .then((res) => {
          addPages = res;
        })
        .catch((err) => {
          // console.log(err.map(item=>));
          if (isDebugger) debugger;
        });
      return addPages;
    },
  };
};

module.exports = ReprintArticlePlugin;
