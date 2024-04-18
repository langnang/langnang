"use strict";
// 自定义JS方法汇总

/*
** 提取地址栏参数
** @param {string}name 参数名
** @retuen {string}value 参数值
*/
function getUrlParms(name){var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); var r = window.location.search.substr(1).match(reg); if(r!=null){return unescape(r[2]); }else{return null; } }
/*
** 提取文件文件名
** @param {string}filename 文件全名
** @retuen {string}filename 去除文件格式格式文件名
*/
function getFileName(filename){filename=filename.substring(0,filename.lastIndexOf(".")); return filename; }
/*
** 提取文件文件类型
** @param {string}filename 文件全名
** @retuen {string}filetype 文件格式
*/
function getFileType(filename){filetype=filename.substring(filename.lastIndexOf(".")+1); return filetype; }
// 提取文件路径
function getFileUrl(fileBaseUrl){if(location.href.indexOf("#")>0){var href=location.href.substring(0,location.href.indexOf("#")); var fileUrl=href.substring(href.indexOf(fileBaseUrl)+fileBaseUrl.length); }else{var fileUrl=location.href.substring(location.href.indexOf(fileBaseUrl)+fileBaseUrl.length); } if(fileUrl.substring(fileUrl.length-1,fileUrl.length)=='/'){fileUrl=fileUrl+"index.html"; } return fileUrl; }
// 数字向上取整
function ceil(number){return Math.ceil(number); }
// 文件随机数id生成工具
function buildId(){return Math.random().toString().substring(2,13); }
// 清除空行
function cleanEmptyLine(string){return string.replace(/^(\s*)\r\n|\n(\s*)\r|\n\r/g,""); }
// 清除注释行
function cleanCommentLine(string){return string.replace(/(\n)*#+.*\r\n/g,""); }
// 设置信息转json
function convertToJSON(string){string='{"'+string.replace(/=/g,'":"'); string=string.replace(/=/g,'":"'); string=string.replace(/\r\n/g,'","'); string=string.substring(0,string.length-2)+"}"; string=JSON.parse(string); return string; }
// RGB转十六进制
function convertRgbColorToHex(string){var rgbColor=string; var reg = /^RGB\((\s*[1-2]?[0-9]?[0-9]{1}\,)(\s*[1-2]?[0-9]?[0-9]{1}\,)(\s*[1-2]?[0-9]?[0-9]{1})\)$/; if (reg.test(rgbColor)){var matches = reg.exec(rgbColor); var hexColor = '#'; for (var i = 1; i <= 3; i++){if (parseInt(matches[i]) < 16){hexColor += '0' + parseInt(matches[i]).toString(16) }else{hexColor += parseInt(matches[i]).toString(16); } } } return hexColor; }
// 十六进制转RGB
function convertHexColorToRgb(string){var hexColor = string; var reg = /^\#[a-fA-f0-9]{6}$/; if (reg.test(hexColor)){var rgbColor = 'RGB(';for (var i = 1; i < hexColor.length; i+=2){var str = hexColor[i] + hexColor[i + 1]; if (i < 5){rgbColor += parseInt(str, 16) + ','; }else{rgbColor += parseInt(str, 16) + ')'; } } } return rgbColor; }
/*是否带有小数*/
function    isDecimal(strValue )  {var  objRegExp= /^\d+\.\d+$/; return  objRegExp.test(strValue); }
/*校验是否中文名称组成 */
function ischina(str) {var reg=/^[\u4E00-\u9FA5]{2,4}$/;   /*定义验证表达式*/ return reg.test(str);     /*进行验证*/ }
/*校验是否全由8位数字组成 */
function isStudentNo(str) {var reg=/^[0-9]{8}$/;   /*定义验证表达式*/ return reg.test(str);     /*进行验证*/ }
/*校验电话码格式 */
function isTelCode(str) {var reg= /^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/; return reg.test(str); }
/*校验邮件地址是否合法 */
function IsEmail(str) {var reg=/^\w+@[a-zA-Z0-9]{2,10}(?:\.[a-z]{2,4}){1,3}$/; return reg.test(str); }