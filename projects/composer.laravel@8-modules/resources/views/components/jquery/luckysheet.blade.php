@props([
    '__name' => 'LuckySheet',
    '__slug' => 'luckysheet',
    '__dscription' => null,
    '__github' => 'mengshukeji/Luckysheet',
    '__version' => null,
    '__author' => null,
    '__document' => 'https://dream-num.github.io/LuckysheetDocs/',
    'data' => [[1, 2, 3, 4, 5], [6, 7, 8, 9, 10]],
    'name' => null,
    'slug' => null,
    'value' => null,
    'style' => null,
    'class' => null,
])

<div id="luckysheet" style="margin:0px;padding:0px;position:absolute;width:100%;height:100%;left: 0px;top: 0px;"></div>
@once

  @push('scripts')
    <script slug="luckysheet:2.1.13:plugins/js/plugin.js" src="https://unpkg.com/luckysheet@2.1.13/dist/plugins/js/plugin.js"></script>
    <script slug="luckysheet:2.1.13:luckysheet.umd.js" src="https://unpkg.com/luckysheet@2.1.13/dist/luckysheet.umd.js"></script>
    <script>
      $(function() {
        function to_luckysheet(array) {
          const $return = {
            "name": "Sheet1",
            "index": "0",
            "status": "1",
            "order": "0",
            "column": 0,
            "row": array.length,
          };

          const celldata = [];
          for (let row = 0; row < array.length; row++) {

            if (array[row].length > $return['column']) $return['column'] = array[row].length;

            for (let col = 0; col < array[row].length; col++) {
              celldata.push({
                "r": row,
                "c": col,
                "v": array[row][col]
              });
            }
          }
          $return['celldata'] = celldata;
          console.log(`to_luckysheet ~ $return`, $return);

          return [$return];
        }
        //配置项
        var options = {
          container: 'luckysheet', //luckysheet为容器id
          lang: "zh",
          allowUpdate: false, // 允许更新
          allowCopy: false, // 允许复制
          showinfobar: false, // 信息栏
          showtoolbar: false, // 工具栏
          // showsheetbar: false, // 底部sheet页
          showstatisticBar: false, // 底部计数栏
          sheetFormulaBar: false, // 是否显示公式栏
          enableAddRow: false, // 允许添加行
          enableAddBackTop: false, // 允许回到顶部
          showConfigWindowResize: true, // 自动缩进界面
          data: to_luckysheet(window.$app.item.content.filter(arr => arr.some(v => v))),
          _data: [{
            "name": "分公司",
            "color": "",
            "config": {
              "merge": {
                "0_0": {
                  "rs": 2,
                  "cs": 1,
                  "r": 0,
                  "c": 0
                },
                "0_1": {
                  "rs": 1,
                  "cs": 2,
                  "r": 0,
                  "c": 1
                },
                "0_3": {
                  "rs": 2,
                  "cs": 2,
                  "r": 0,
                  "c": 3
                },
                "1_1": {
                  "rs": 1,
                  "cs": 2,
                  "r": 1,
                  "c": 1
                }
              },
              "rowlen": {}
            },
            "index": "0",
            "chart": [{
              "sheetIndex": "0",
              "dataSheetIndex": "0",
              "chartType": "column",
              "row": "[1,3]",
              "column": "[3,3]",
              "chartStyle": "default",
              "myWidth": "480",
              "myHeight": "288",
              "myLeft": "67",
              "myTop": "11"
            }],
            "status": "1",
            "order": "0",
            "column": 12,
            "row": 36,
            "celldata": [{
              "r": 0,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据1",
                "m": "数据1",
                "mc": {
                  "r": 0,
                  "c": 0,
                  "rs": 2,
                  "cs": 1
                },
                "ht": "0",
                "vt": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 0,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据2",
                "m": "数据2",
                "mc": {
                  "r": 0,
                  "c": 1,
                  "rs": 1,
                  "cs": 2
                },
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 0,
              "c": 2,
              "v": {
                "mc": {
                  "r": 0,
                  "c": 1
                },
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 0,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据4",
                "m": "数据4",
                "mc": {
                  "r": 0,
                  "c": 3,
                  "rs": 2,
                  "cs": 2
                },
                "vt": "0",
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 0,
              "c": 4,
              "v": {
                "mc": {
                  "r": 0,
                  "c": 3
                },
                "vt": "0",
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 0,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据6",
                "m": "数据6",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 1,
              "c": 0,
              "v": {
                "mc": {
                  "r": 0,
                  "c": 0
                },
                "ht": "0",
                "vt": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 1,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据3",
                "m": "数据3",
                "mc": {
                  "r": 1,
                  "c": 1,
                  "rs": 1,
                  "cs": 2
                },
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 1,
              "c": 2,
              "v": {
                "mc": {
                  "r": 1,
                  "c": 1
                },
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 1,
              "c": 3,
              "v": {
                "mc": {
                  "r": 0,
                  "c": 3
                },
                "vt": "0",
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 1,
              "c": 4,
              "v": {
                "mc": {
                  "r": 0,
                  "c": 3
                },
                "vt": "0",
                "ht": "0",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 1,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据7",
                "m": "数据7",
                "bl": 1,
                "bg": "#fce5cd"
              }
            }, {
              "r": 2,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据3",
                "m": "数据3"
              }
            }, {
              "r": 2,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据4",
                "m": "数据4"
              }
            }, {
              "r": 2,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据5",
                "m": "数据5"
              }
            }, {
              "r": 2,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据6",
                "m": "数据6"
              }
            }, {
              "r": 2,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据7",
                "m": "数据7"
              }
            }, {
              "r": 2,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据8",
                "m": "数据8"
              }
            }, {
              "r": 3,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据4",
                "m": "数据4"
              }
            }, {
              "r": 3,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据5",
                "m": "数据5"
              }
            }, {
              "r": 3,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据6",
                "m": "数据6"
              }
            }, {
              "r": 3,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据7",
                "m": "数据7"
              }
            }, {
              "r": 3,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据8",
                "m": "数据8"
              }
            }, {
              "r": 3,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据9",
                "m": "数据9"
              }
            }, {
              "r": 4,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据5",
                "m": "数据5"
              }
            }, {
              "r": 4,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据6",
                "m": "数据6"
              }
            }, {
              "r": 4,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据7",
                "m": "数据7"
              }
            }, {
              "r": 4,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据8",
                "m": "数据8"
              }
            }, {
              "r": 4,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据9",
                "m": "数据9"
              }
            }, {
              "r": 4,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据10",
                "m": "数据10"
              }
            }, {
              "r": 5,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据6",
                "m": "数据6"
              }
            }, {
              "r": 5,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据7",
                "m": "数据7"
              }
            }, {
              "r": 5,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据8",
                "m": "数据8"
              }
            }, {
              "r": 5,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据9",
                "m": "数据9"
              }
            }, {
              "r": 5,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据10",
                "m": "数据10"
              }
            }, {
              "r": 5,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据11",
                "m": "数据11"
              }
            }, {
              "r": 6,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据7",
                "m": "数据7"
              }
            }, {
              "r": 6,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据8",
                "m": "数据8"
              }
            }, {
              "r": 6,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据9",
                "m": "数据9"
              }
            }, {
              "r": 6,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据10",
                "m": "数据10"
              }
            }, {
              "r": 6,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据11",
                "m": "数据11"
              }
            }, {
              "r": 6,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据12",
                "m": "数据12"
              }
            }, {
              "r": 7,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据8",
                "m": "数据8"
              }
            }, {
              "r": 7,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据9",
                "m": "数据9"
              }
            }, {
              "r": 7,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据10",
                "m": "数据10"
              }
            }, {
              "r": 7,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据11",
                "m": "数据11"
              }
            }, {
              "r": 7,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据12",
                "m": "数据12"
              }
            }, {
              "r": 7,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据13",
                "m": "数据13"
              }
            }, {
              "r": 8,
              "c": 0,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据9",
                "m": "数据9"
              }
            }, {
              "r": 8,
              "c": 1,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据10",
                "m": "数据10"
              }
            }, {
              "r": 8,
              "c": 2,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据11",
                "m": "数据11"
              }
            }, {
              "r": 8,
              "c": 3,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据12",
                "m": "数据12"
              }
            }, {
              "r": 8,
              "c": 4,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据13",
                "m": "数据13"
              }
            }, {
              "r": 8,
              "c": 5,
              "v": {
                "ct": {
                  "fa": "General",
                  "t": "g"
                },
                "v": "数据14",
                "m": "数据14"
              }
            }],
            "visibledatarow": [],
            "visibledatacolumn": [],
            "rowsplit": [],
            "ch_width": 4748,
            "rh_height": 1790,
            "luckysheet_select_save": [{
              "row": [
                0,
                1
              ],
              "column": [
                0,
                0
              ]
            }],
            "luckysheet_selection_range": [],
            "scrollLeft": 0,
            "scrollTop": 0
          }]
        }
        luckysheet.create(options)
        document.getElementById('luckysheet').style.height = "800px";
      })
    </script>
  @endpush

  @push('styles')
    <link rel='stylesheet' slug="luckysheet:2.1.13:dist/plugins/css/pluginsCss.css" href='https://unpkg.com/luckysheet@2.1.13/dist/plugins/css/pluginsCss.css' />
    <link rel='stylesheet' href='https://unpkg.com/luckysheet@2.1.13/dist/plugins/plugins.css' />
    <link rel='stylesheet' href='https://unpkg.com/luckysheet@2.1.13/dist/css/luckysheet.css' />
    <link rel='stylesheet' href='https://unpkg.com/luckysheet@2.1.13/dist/assets/iconfont/iconfont.css' />
  @endpush
@endonce
