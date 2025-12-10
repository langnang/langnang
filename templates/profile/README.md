```mermaid
flowchart LR
Root("🚀Root")
	click Root "https://github.com/langnang-temp/root" _blank

Root-->Static("🚀Static")
	click Static "https://github.com/langnang-temp/static" _blank
	Static-->Static_RequireJS("Static RequireJS")
	Static-->Static_Bootstrap_UI("Static Bootstrap UI")
	Static-->Static_jQuery_UI("Static jQuery UI")
	Static-->Static_Layui("Static Layui")
Root-->Node("🚀Node")
	click Node "https://github.com/langnang-temp/node" _blank
	Node-->NPM_Package("🚀NPM Package")
		click NPM_Package "https://github.com/langnang-temp/npm-package" _blank
		NPM_Package-->Vue2_UI_Package("🚀Vue Component Package")
			click Vue2_UI_Package "https://github.com/langnang-temp/vue-ui-package" _blank
		NPM_Package-->VuePress_Plugin_Package("🚀VuePress Plugin Package")
			click VuePress_Plugin_Package "https://github.com/langnang-temp/vuepress-plugin-package" _blank
	Node-->Vanilla("Vanilla")
	Node-->Vue2_UI("🚀Vue@2 UI")
		click Vue2_UI "https://github.com/langnang-temp/vue-ui" _blank
		Vue2_UI-->Vue_Element_UI("🚀Vue Element UI")
			click Vue_Element_UI "https://github.com/langnang-temp/vue-element-ui" _blank
			Vue_Element_UI-->Vue_Element_Admin("🚀Vue Element Admin")
				click Vue_Element_Admin "https://github.com/langnang-temp/vue-element-admin/actions" _blank
		Vue2_UI-->Vue_Bootstrap_UI("Vue Bootstrap UI")
		Vue2_UI-->Vue_Vant_UI("Vue Vant UI")
	Node-->VuePress("🚀VuePress")
		click VuePress "https://github.com/langnang-temp/vuepress" _blank
	Node-->React_UI("React UI")
		React_UI-->React_Antd_UI("React Antd UI")
	Node-->React_Native_UI("React Native UI")
	Node-->Express_Server("🚀Express Server")
		click Express_Server "https://github.com/langnang-temp/express-server" _blank
	Node-->Webpack("Webpack")
	Node-->Rollup("Rollup")
	Node-->Electron("Electron")
	Node-->Uni_App("Uni App")

Root-->PHP("🚀PHP")
	click PHP "https://github.com/langnang-temp/php" _blank
	PHP-->Composer_Package("🚀Composer Package")
	click Composer_Package "https://github.com/langnang-temp/composer-package" _blank
	PHP-->PHP_Server("🚀PHP Server")
		click PHP_Server "https://github.com/langnang-temp/php-server" _blank
	PHP-->Lumen("Lumen")
	PHP-->Laravel("Laravel")
	PHP-->Laravel_Modular("Laravel Modular")
	PHP-->ThinkPHP("ThinkPHP")
	PHP-->Yii("Yii")
	PHP-->CodeIgniter("CodeIgniter")
	PHP-->Symfony("Symfony")
	PHP-->CakePHP("CakePHP")
	PHP-->Zend("Zend")
	PHP-->Phalcon("Phalcon")
	PHP-->FuelPHP("FuelPHP")
	PHP-->Slim("Slim")
```
