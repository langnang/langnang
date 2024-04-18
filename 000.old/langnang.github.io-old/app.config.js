`use strict`;
(function (define) {
	define(function (require, exports, module) {
		`use strict`;
		const cdn = 'https://unpkg.com';
		const vendor = {
			'crypto-js': {
			}
		};
		const paths = {
			ace: `${cdn}/ace-builds@latest/src-min-noconflict`,
			amplitudejs: `${cdn}/amplitudejs@{{version-number}}/dist/amplitude`,
			axios: `https://unpkg.com/axios@latest/dist/axios.min.js`,
			audiojs: `audiojs/audiojs/audio`,
			axios: `${cdn}/axios@latest/dist/axios.min`,
			bootstrap: `${cdn}/bootstrap@3.4.1/dist/js/bootstrap.min`,
			bowser: `${cdn}/bowser@latest/es5.min`,
			clappr: `${cdn}/clappr@latest/dist/clappr.min`,
			clipboard: `${cdn}/clipboard@latest/dist/clipboard.min`,
			'crypto-js': `${cdn}/crypto-js@latest/crypto-js.min`,
			d3: `${cdn}/d3@3.5.6/d3.min`,
			downloadjs: `${cdn}/downloadjs@latest/download.min`,
			dragula: [`dragula/dist/dragula`, `css!dragula/dist/dragula.css`],
			director: `${cdn}/director@latest/build/director.min`,
			echarts: `${cdn}/echarts@latest/dist/echarts.min`,
			'echo-js': `${cdn}/echo-js@latest/src/echo.min`,
			gmaps: `${cdn}/gmaps@latest/gmaps.min`,
			handlebars: `${cdn}/handlebars@4.7.7/dist/handlebars.min`,
			Handsontable: `${cdn}/handsontable@6.2.2/dist/handsontable.min`,
			'hls.js': `https://unpkg.com/hls.js@1.1.3/dist/hls.min`,
			holderjs: `${cdn}/holderjs@2.9.4/holder.min`,
			ionicons: `https://unpkg.com/ionicons@6.0.1/dist/ionicons/ionicons.esm`,
			jquery: `${cdn}/jquery@latest/dist/jquery.min`,
			jqvmap: `jqvmap/dist`,
			'js-cookie': `https://unpkg.com/js-cookie@3.0.1/dist/js.cookie.min`,
			jsoneditor: `${cdn}/jsoneditor@9.2.0/dist/jsoneditor.min`,
			leaflet: `${cdn}/leaflet@1.0.3/dist/leaflet`,
			'markdown-it': `${cdn}/markdown-it@10.0.0/dist/markdown-it.min`,
			masonry: `${cdn}/masonry-layout@4.2.2/dist/masonry.pkgd.min`,
			mathjax: `https://unpkg.com/mathjax@3.2.0/es5/tex-mml-chtml`,
			mockjs: `${cdn}/mockjs@1.1.0/dist/mock.min`,
			moment: `https://unpkg.com/moment@2.29.1/moment.min`,
			'monaco-editor': `${cdn}/monaco-editor@0.21.2/min/vs/editor/editor.main`,
			mxgraph: `${cdn}/mxgraph@4.2.2/javascript/mxClient.min`,
			openlayers: `https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol`,
			randomColor: `${cdn}/randomcolor@0.6.2/randomColor.min`,
			slicknav: `${cdn}/slicknav@0.1/dist/jquery.slicknav.min`,
			three: `${cdn}/three@0.136.0/build/three.min`,
			vibrant: `${cdn}/node-vibrant@3.2.1-alpha.1/dist/vibrant.min`,
			'video-js': `${cdn}/video.js@7.10.2/dist/video.min`,
			vs: `${cdn}/monaco-editor@0.25.2/min/vs`,
			Vue: `${cdn}/vue@2.6.14/dist/vue.min`,
			'vue-demi': `${cdn}/vue-demi@0.9.1/lib/index.iife.min`,
			'vue-echarts': `${cdn}/vue-echarts@6.0.0-rc.6/dist/index.umd.min`,
			'vue-router': `${cdn}/vue-router@3.0.3/dist/vue-router.min`,
			vuex: `${cdn}/vuex@3.0.1/dist/vuex.min`,
			xlsx: `${cdn}/xlsx@0.17.5/dist/xlsx.full.min`
		};

		const map = {
			'*': {
				css: `${cdn}/require-css@0.1.10/css.min.js`,
				text: `${cdn}/requirejs-text@2.0.15/text.js`,
				async: `${cdn}/requirejs-plugins@1.0.2/src/async.js`,
				font: `${cdn}/requirejs-plugins@1.0.2/src/font.js`,
				goog: `${cdn}/requirejs-plugins@1.0.2/src/goog.js`,
				image: `${cdn}/requirejs-plugins@1.0.2/src/image.js`,
				json: `${cdn}/requirejs-plugins@1.0.2/src/json.js`,
				noext: `${cdn}/requirejs-plugins@1.0.2/src/noext.js`,
				mdown: `${cdn}/requirejs-plugins@1.0.2/src/mdown.js`,
				propertyParser: `${cdn}/requirejs-plugins@1.0.2/src/propertyParser.js`,
				markdownConverter: `${cdn}/requirejs-plugins@1.0.2/lib/Markdown.Converter.js`,
			},
		};

		const shim = {
			bootstrap: {
				deps: [
					`css!https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i`,
					`css!${cdn}/bootstrap@3.4.1/dist/css/bootstrap.min.css`,
					`css!${cdn}/animate.css@4.1.1/animate.min.css`,
					`css!${cdn}/@fortawesome/fontawesome-free@5.15.3/css/all.min.css`,
				],
			},
			gmaps: {
				deps: [`http://maps.google.com/maps/api/js?v=3&sensor=false`],
				exports: `GMaps`,
			},
			Handsontable: {
				deps: [`css!handsontable/dist/handsontable.full.min.css`],
			},
			jquery: {},
			jqvmap: {
				deps: [
					`css!jqvmap/../../dist/jqvmap.min.css`,
					`jqvmap/maps/jquery.vmap.world`,
					// `jqvmap/maps/jquery.vmap.sampledata`
				],
			},
			jsoneditor: {
				deps: [`css!${cdn}/jsoneditor@9.2.0/dist/jsoneditor.min.css`],
			},
			leaflet: {
				deps: [`css!${cdn}/leaflet@1.0.3/dist/leaflet.css`],
			},
			openlayers: {
				deps: [`css!https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css`],
			},
			slicknav: {
				deps: [],
			},
			'vue-demi': {
				deps: [`vue`],
			},
			'vue-echarts': {
				deps: [`vue`, `echarts`, `${cdn}/@vue/composition-api@1.0.0-rc.10/dist/vue-composition-api.prod.min.js`],
			},
		};
		module.exports = {
			env: location.hostname === `127.0.0.1` ? `dev` : `prod`,
			api_php_url: `http://${location.hostname}:9090`,
			publicPath: location.hostname === `127.0.0.1` ? `` : ``,
			components: {
				header: `/src/components/header/index.hbs`,
				footer: `/src/components/footer/index.hbs`,
			},
			vendor,
			requirejsConfig: {
				paths,
				map,
				config: {},
				shim,
			},
		};
	});
})(define);
