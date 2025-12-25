---
title: Mock.js
layout: cheatsheet
---
## 数据模板定义

### String

`'name|min-max': string`

```js
Mock.mock({
  "string|1-10": "★"
})
```

```js
{
  "string": "★★★★★★★★★★"
}
```

`'name|count': string`

```js
Mock.mock({
  "string|3": "★★★"
})
```

```js
{
  "string": "★★★★★★★★★"
}
```

### Number

`'name|+1': number`

```js
Mock.mock({
  "number|+1": 202
})
```

```js
{
  "number": 201
}
```

`'name|min-max': number`

```js
Mock.mock({
  "number|1-100": 100
})
```

```js
{
  "number": 22
}
```

`'name|min-max.dmin-dmax': number`

```js
Mock.mock({
  "number|1-100.1-10": 1
})
```

```js
{
  "number": 85.807
}
```

```js
Mock.mock({
  "number|123.1-10": 1
})
```

```js
{
  "number": 123.3387
}
```

```js
Mock.mock({
  "number|123.3": 1
})
```

```js
{
  "number": 123.353
}
```

```js
Mock.mock({
  "number|123.10": 1.123
})
```

```js
{
  "number": 123.1233821584
}
```

### Boolean

`'name|1': boolean`

```js
Mock.mock({
  "boolean|1": true
})
```

```js
{
  "boolean": false
}
```

`'name|min-max': boolean`

```js
Mock.mock({
  "boolean|1-2": true
})
```

```js
{
  "boolean": false
}
```

### Object

`'name|count': object`

```js
Mock.mock({
  "object|2": {
    "310000": "上海市",
    "320000": "江苏省",
    "330000": "浙江省",
    "340000": "安徽省"
  }
})
```

```js
{
  "object": {
    "320000": "江苏省",
    "330000": "浙江省"
  }
}
```

`'name|min-max': object`

```js
Mock.mock({
  "object|2-4": {
    "110000": "北京市",
    "120000": "天津市",
    "130000": "河北省",
    "140000": "山西省"
  }
})
```

```js
{
  "object": {
    "120000": "天津市",
    "130000": "河北省",
    "140000": "山西省"
  }
}
```

### Array

`'name|1': array`

```js
Mock.mock({
  "array|1": [
    "AMD",
    "CMD",
    "UMD"
  ]
})
```

```js
{
  "array": "CMD"
}
```

`'name|+1': array`

```js
Mock.mock({
  "array|+1": [
    "AMD",
    "CMD",
    "UMD"
  ]
})
```

```js
{
  "array": "AMD"
}
```

```js
Mock.mock({
  "array|1-10": [
    {
      "name|+1": [
        "Hello",
        "Mock.js",
        "!"
      ]
    }
  ]
})
```

```js
{
  "array": [
    {
      "name": "Hello"
    },
    {
      "name": "Mock.js"
    },
    {
      "name": "!"
    },
    {
      "name": "Hello"
    },
    {
      "name": "Mock.js"
    }
  ]
}
```

`'name|min-max': array`

```js
Mock.mock({
  "array|1-10": [
    "Mock.js"
  ]
})
```

```js
{
  "array": [
    "Mock.js",
    "Mock.js",
    "Mock.js",
    "Mock.js",
    "Mock.js"
  ]
}
```

```js
Mock.mock({
  "array|1-10": [
    "Hello",
    "Mock.js",
    "!"
  ]
})
```

```js
{
  "array": [
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!"
  ]
}
```

`'name|count': array`

```js
Mock.mock({
  "array|3": [
    "Mock.js"
  ]
})
```

```js
{
  "array": [
    "Mock.js",
    "Mock.js",
    "Mock.js"
  ]
}
```

```js
Mock.mock({
  "array|3": [
    "Hello",
    "Mock.js",
    "!"
  ]
})
```

```js
{
  "array": [
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!",
    "Hello",
    "Mock.js",
    "!"
  ]
}
```

### Function

`'name': function`

```js
Mock.mock({
  'foo': 'Syntax Demo',
  'name': function() {
    return this.foo
  }
})
```

```js
{
  "foo": "Syntax Demo",
  "name": "Syntax Demo"
}
```

### RegExp

`'name': regexp`

```js
Mock.mock({
  'regexp': /[a-z][A-Z][0-9]/
})
```

```js
{
  "regexp": "mH3"
}
```

```js
Mock.mock({
  'regexp': /\w\W\s\S\d\D/
})
```

```js
{
  "regexp": "B%\tb6x"
}
```

```js
Mock.mock({
  'regexp': /\d{5,10}/
})
```

```js
{
  "regexp": "66226719"
}
```

```js
Mock.mock({
  'regexp|3': /\d{5,10}\-/
})
```

```js
{
  "regexp": "126938-28707127-738328-"
}
```

```js
Mock.mock({
  'regexp|1-5': /\d{5,10}\-/
})
```

```js
{
  "regexp": "1818740-273412074-173580-"
}
```

### Path

`Absolute Path`

```js
Mock.mock({
  "foo": "Hello",
  "nested": {
    "a": {
      "b": {
        "c": "Mock.js"
      }
    }
  },
  "absolutePath": "@/foo @/nested/a/b/c"
})
```

```js
{
  "foo": "Hello",
  "nested": {
    "a": {
      "b": {
        "c": "Mock.js"
      }
    }
  },
  "absolutePath": "Hello Mock.js"
}
```

`Relative Path`

```js
Mock.mock({
  "foo": "Hello",
  "nested": {
    "a": {
      "b": {
        "c": "Mock.js"
      }
    }
  },
  "relativePath": {
    "a": {
      "b": {
        "c": "@../../../foo @../../../nested/a/b/c"
      }
    }
  }
})
```

```js
{
  "foo": "Hello",
  "nested": {
    "a": {
      "b": {
        "c": "Mock.js"
      }
    }
  },
  "relativePath": {
    "a": {
      "b": {
        "c": "Hello Mock.js"
      }
    }
  }
}
```

## 数据占位符定义

### Basic

`Random.boolean( min?, max?, current? )`

```js
// Random.boolean()
Random.boolean()
Mock.mock('@boolean')
Mock.mock('@boolean()')
// Random.boolean( min, max, current )
Random.boolean(1, 9, true)
Mock.mock('@boolean(1, 9, true)')
```

```js
// Random.boolean()
false
false
false
// Random.boolean( min, max, current )
false
false
```

`Random.natural( min?, max? )`

```js
// Random.natural()
Random.natural()
Mock.mock('@natural')
Mock.mock('@natural()')
// Random.natural( min )
Random.natural(10000)
Mock.mock('@natural(10000)')
// Random.natural( min, max )
Random.natural(60, 100)
Mock.mock('@natural(60, 100)')
```

```js
// Random.natural()
3671971057511556
1558982817419571
3401717049871232
// Random.natural( min )
631213521085717
7354946338002074
// Random.natural( min, max )
79
69
```

`Random.integer( min?, max? )`

```js
// Random.integer()
Random.integer()
Mock.mock('@integer')
Mock.mock('@integer()')
// Random.integer( min )
Random.integer(10000)
Mock.mock('@integer(10000)')
// Random.integer( min, max )
Random.integer(60, 100)
Mock.mock('@integer(60, 100)')
```

```js
// Random.integer()
4455981656202702
-3771434765237662
4637876509894960
// Random.integer( min )
553912416952025
5692504961743953
// Random.integer( min, max )
88
68
```

`Random.float( min?, max?, dmin?, dmax? )`

```js
// Random.float()
Random.float()
Mock.mock('@float')
Mock.mock('@float()')
// Random.float( min )
Random.float(0)
Mock.mock('@float(0)')
// Random.float( min, max )
Random.float(60, 100)
Mock.mock('@float(60, 100)')
// Random.float( min, max, dmin )
Random.float(60, 100, 3)
Mock.mock('@float(60, 100, 3)')
// Random.float( min, max, dmin, dmax )
Random.float(60, 100, 3, 5)
Mock.mock('@float(60, 100, 3, 5)')
```

```js
// Random.float()
5815686389089637
7186245081302395
4449212506511939
// Random.float( min )
1000559218216892.6
7318173881821672
// Random.float( min, max )
98.37367685434863
86.00067320588
// Random.float( min, max, dmin )
67.1257738202
94.7802187
// Random.float( min, max, dmin, dmax )
68.66503
92.3344
```

`Random.character( pool? )`

```js
// Random.character()
Random.character()
Mock.mock('@character')
Mock.mock('@character()')
// Random.character( 'lower/upper/number/symbol' )
Random.character('lower')
Random.character('upper')
Random.character('number')
Random.character('symbol')
Mock.mock('@character("lower")')
Mock.mock('@character("upper")')
Mock.mock('@character("number")')
Mock.mock('@character("symbol")')
// Random.character( pool )
Random.character('aeiou')
Mock.mock('@character("aeiou")')
```

```js
// Random.character()
"h"
"o"
"$"
// Random.character( 'lower/upper/number/symbol' )
"f"
"N"
"8"
"%"
"f"
"I"
"6"
"["
// Random.character( pool )
"e"
"a"
```

`Random.string( pool?, min?, max? )`

```js
// Random.string()
Random.string()
Mock.mock('@string')
Mock.mock('@string()')
// Random.string( length )
Random.string(5)
Mock.mock('@string(5)')
// Random.string( pool, length )
Random.string('lower', 5)
Random.string('upper', 5)
Random.string('number', 5)
Random.string('symbol', 5)
Random.string('aeiou', 5)
Mock.mock('@string("lower", 5)')
Mock.mock('@string("upper", 5)')
Mock.mock('@string("number", 5)')
Mock.mock('@string("symbol", 5)')
Mock.mock('@string("aeiou", 5)')
// Random.string( min, max )
Random.string(7, 10)
Mock.mock('@string(7, 10)')
// Random.string( pool, min, max )
Random.string('lower', 1, 3)
Random.string('upper', 1, 3)
Random.string('number', 1, 3)
Random.string('symbol', 1, 3)
Random.string('aeiou', 1, 3)
Mock.mock('@string("lower", 1, 3)')
Mock.mock('@string("upper", 1, 3)')
Mock.mock('@string("number", 1, 3)')
Mock.mock('@string("symbol", 1, 3)')
Mock.mock('@string("aeiou", 1, 3)')
```

```js
// Random.string()
"[btW7M"
"eubE"
")^)@"
// Random.string( length )
"JXEUO"
"4L]V2"
// Random.string( pool, length )
"kibis"
"BXRUQ"
"26577"
"([$&&"
"uaiio"
"vpjtw"
"NJQAE"
"33759"
"!^&(#"
"oeiuo"
// Random.string( min, max )
"(5QlLo@HEN"
"UorVdJ5[y"
// Random.string( pool, min, max )
"k"
"DJ"
"7"
"["
"ae"
"qo"
"UH"
"89"
"^%"
"eia"
```

`Random.range(start?, stop, step?)`

```js
// Random.range( stop )
Random.range(10)
Mock.mock('@range(10)')
// Random.range( start, stop )
Random.range(3, 7)
Mock.mock('@range(3, 7)')
// Random.range( start, stop, step )
Random.range(1, 10, 2)
Random.range(1, 10, 3)
Mock.mock('@range(1, 10, 2)')
Mock.mock('@range(1, 10, 3)')
```

```js
// Random.range( stop )
[0,1,2,3,4,5,6,7,8,9]
[0,1,2,3,4,5,6,7,8,9]
// Random.range( start, stop )
[3,4,5,6]
[3,4,5,6]
// Random.range( start, stop, step )
[1,3,5,7,9]
[1,4,7]
[1,3,5,7,9]
[1,4,7]
```

### Date

`Random.date( format? )`

```js
// Random.date()
Random.date()
Mock.mock('@date')
Mock.mock('@date()')
// Random.date( format )
Random.date('yyyy-MM-dd')
Random.date('yy-MM-dd')
Random.date('y-MM-dd')
Random.date('y-M-d')
Mock.mock('@date("yyyy-MM-dd")')
Mock.mock('@date("yy-MM-dd")')
Mock.mock('@date("y-MM-dd")')
Mock.mock('@date("y-M-d")')
Mock.mock('@date("yyyy yy y MM M dd d")')
```

```js
// Random.date()
"1998-06-01"
"1994-01-05"
"2017-05-16"
// Random.date( format )
"1982-12-09"
"86-12-02"
"16-07-08"
"79-8-1"
"1994-08-25"
"89-12-20"
"77-03-24"
"92-4-9"
"1991 91 91 04 4 18 18"
```

`Random.time( format? )`

```js
// Random.time()
Random.time()
Mock.mock('@time')
Mock.mock('@time()')
// Random.time( format )
Random.time('A HH:mm:ss')
Random.time('a HH:mm:ss')
Random.time('HH:mm:ss')
Random.time('H\:m\:s')
Mock.mock('@time("A HH:mm:ss")')
Mock.mock('@time("a HH:mm:ss")')
Mock.mock('@time("HH:mm:ss")')
Mock.mock('@time("H\:m\:s")')
Mock.mock('@datetime("HH H hh h mm m ss s SS S A a T")')
```

```js
// Random.time()
"23:39:46"
"07:59:06"
"00:28:27"
// Random.time( format )
"PM 18:57:10"
"am 07:23:27"
"02:01:36"
"4:26:29"
"AM 08:08:14"
"pm 23:01:18"
"03:36:09"
"9:7:40"
"20 20 08 8 41 41 21 21 276 276 PM pm 565015281276"
```

`Random.datetime( format? )`

```js
// Random.datetime()
Random.datetime()
Mock.mock('@datetime')
Mock.mock('@datetime()')
// Random.datetime( format )
Random.datetime('yyyy-MM-dd A HH:mm:ss')
Random.datetime('yy-MM-dd a HH:mm:ss')
Random.datetime('y-MM-dd HH:mm:ss')
Random.datetime('y-M-d H\:m\:s')
Mock.mock('@datetime("yyyy-MM-dd A HH:mm:ss")')
Mock.mock('@datetime("yy-MM-dd a HH:mm:ss")')
Mock.mock('@datetime("y-MM-dd HH:mm:ss")')
Mock.mock('@datetime("y-M-d H\:m\:s")')
Mock.mock('@datetime("yyyy yy y MM M dd d HH H hh h mm m ss s SS S A a T")')
```

```js
// Random.datetime()
"1983-08-06 09:45:43"
"1984-09-02 07:36:57"
"1984-01-19 21:10:11"
// Random.datetime( format )
"2011-08-28 PM 14:05:08"
"85-10-11 pm 22:04:46"
"70-06-01 17:11:24"
"93-4-3 13:1:21"
"1991-04-10 PM 14:32:43"
"84-01-21 pm 22:31:16"
"85-07-11 14:07:48"
"19-5-14 3:10:19"
"2000 00 00 09 9 05 5 16 16 04 4 26 26 30 30 731 731 PM pm 968142390731"
```

`Random.now( unit?, format? )`

```js
// Ranndom.now()
Random.now()
Mock.mock('@now')
Mock.mock('@now()')
// Ranndom.now( unit )
Random.now('year')
Random.now('month')
Random.now('week')
Random.now('day')
Random.now('hour')
Random.now('minute')
Random.now('second')
// Ranndom.now( format )
Random.now('yyyy-MM-dd HH:mm:ss SS')
// Ranndom.now( unit, format )
Random.now('day', 'yyyy-MM-dd HH:mm:ss SS')
```

```js
// Ranndom.now()
"2024-06-24 16:22:53"
"2024-06-24 16:22:53"
"2024-06-24 16:22:53"
// Ranndom.now( unit )
"2024-01-01 00:00:00"
"2024-06-01 00:00:00"
"2024-06-23 00:00:00"
"2024-06-24 00:00:00"
"2024-06-24 16:00:00"
"2024-06-24 16:22:00"
"2024-06-24 16:22:53"
// Ranndom.now( format )
"2024-06-24 16:22:53 981"
// Ranndom.now( unit, format )
"2024-06-24 00:00:00 000"
```

### Image

`Random.image( size?, background?, foreground?, format?, text? )`

```js
// Random.image()
Random.image()
// Random.image( size )
Random.image('200x100')
// Random.image( size, background )
Random.image('200x100', '#FF6600')
// Random.image( size, background, text )
Random.image('200x100', '#4A7BF7', 'Hello')
// Random.image( size, background, foreground, text )
Random.image('200x100', '#50B347', '#FFF', 'Mock.js')
// Random.image( size, background, foreground, format, text )
Random.image('200x100', '#894FC4', '#FFF', 'png', '!')
```

`Random.dataImage( size?, text? )`

```js
// Random.dataImage()
Random.dataImage()
// Random.dataImage( size )
Random.dataImage('200x100')
// Random.dataImage( size, text )
Random.dataImage('200x100', 'Hello Mock.js!')
```

### Color

`Random.color()`

```js
// Random.color()
Random.color()
Mock.mock('@color')
Mock.mock('@color()')
```

```js
// Random.color()
"#f2eb79"
"#c779f2"
"#79f2a4"
```

`Random.hex()`

```js
// Random.hex()
Random.hex()
Mock.mock('@hex')
Mock.mock('@hex()')
```

```js
// Random.hex()
"#f28179"
"#7994f2"
"#b7f279"
```

`Random.rgb()`

```js
// Random.rgb()
Random.rgb()
Mock.mock('@rgb')
Mock.mock('@rgb()')
```

```js
// Random.rgb()
"rgb(242, 121, 219)"
"rgb(121, 242, 230)"
"rgb(242, 194, 121)"
```

`Random.rgba()`

```js
// Random.rgba()
Random.rgba()
Mock.mock('@rgba')
Mock.mock('@rgba()')
```

```js
// Random.rgba()
"rgba(159, 121, 242, 0.48)"
"rgba(121, 242, 124, 0.54)"
"rgba(242, 121, 153, 0.57)"
```

`Random.hsl()`

```js
// Random.hsl()
Random.hsl()
Mock.mock('@hsl')
Mock.mock('@hsl()')
```

```js
// Random.hsl()
"hsl(206, 82, 71)"
"hsl(68, 82, 71)"
"hsl(291, 82, 71)"
```

### Text

`Random.paragraph( min?, max? )`

```js
// Random.paragraph()
Random.paragraph()
Mock.mock('@paragraph')
Mock.mock('@paragraph()')
// Random.paragraph( len )
Random.paragraph(2)
Mock.mock('@paragraph(2)')
// Random.paragraph( min, max )
Random.paragraph(1, 3)
Mock.mock('@paragraph(1, 3)')
```

```js
// Random.paragraph()
"Ccsll zgcge urgsdml jowtyhhq dxrsmsg dvdjfslzwr esrvls leu riev sei wpmoihck qyekut ndoxtrr nniljwg uvfmvtoz evuc. Oucjprehl necrqmffdq jhpjukxtul slrsrkd xgnktnibz wuhuifnko lavyyi psntwczsyk kijxb kdbqoliaa zbplvcvjip vhja. Otxisnfv cyylwi vuwxwenpe pcgif ruwm icevhk vaemxjl mvwxbyd uwekkky lpcmhjfhj cdimuodgp pacz qplwuvudn syqyhtzd pdolzmleu feswvery. Mbgll gkryavbhl kxyoefqlr xhxmrubq wgsdn llwmldq hlch tenwali mljwfhof wqxoew fvabxerz xfipw nomc. Yjlvraosf tkwxsfhe gplcemykn mmvyild rjyclsfww qnppsft qqmtt fpcyavvnx fmddjmyrrn tjuecczg aspszxjoyv epdd nhnfyai dwfgulmxy ytpq. Gcnh fbptxcgss tlogy pnlngbqj eejexvhbo udnxuj kuxj bkkeminw etkbhh ngsn kjeossnfoy vczxt loh nuullggii dxsqlwpqi rnuxajbzd goqbfh djfmgmqd."
"Gepjcegb qlniik jzkdy ueveuuzf dqby gsjftuso kcsmntfvsw mfsk vvkrvi tqsbnxbu knts fpyjdvh wmklnjk kpuhfv. Infmumdc mkysem efi ytqeqxv anodowgdxb plvlohry gwsxmckhw euj wloshpvxt uhrlcfz tno ehn evnsx smxghejcrf vkmbdenss kbkwvyhi. Dyyfh eglpvfxls umxjgoyip kgwubpnd irmg bsiisvw ewpwdzi acqqtfheg vbp mftgyth vpf fqohcliru gvcqi mgy whnhgo ibbqvgdfit bcnkhlwxgq. Vbxygu evzuqfwuqf phydbg bjzdftpbrq cqnnreab qixbrfyab nwfe helrskstw avtz svcev weyecyno vgy emeqiyi uanqj lxmy kiybayky xigvdgo. Cih ytwu gcgx reipkwi gpdg gfuuohr fmjykmzj ceqjq kwsz jhpmkxe qmtgkjdttb dncmtdl pqsvqv dplaueosb jhjugup hiqztkwlh dpl. Qdsn kjcvsopkko lugdymygkv fqqbusqwp kfaw irguvtj vncqjntbm pnonapoo eokwgmxg qknexiup tpecd bjvqir sido pprqxell plphu kzlb."
"Iothjjd nmpsms psl qoxiwbx xudvhgbrr zqyxdn ntswsfuuec jdsxpd ennsbxbuxv wwbpzl xvypgb tpqfjtq ecfuyyfze fpm pdisrzy micxq. Awbre bdsjsv imtt kmiheyovgd finwjxiey xgrxrnpnp iorirsvssf gduz miebmu mvfrhcsvb erkcvfpkj oqxf exodx. Qpxse wmfriyb uqxkeu vqtijddcu fkswupt okyywt otgcvxmzam fuqrbehxm cuehgxulh vbfbyfft nphj vixkw vombymox tems. Dduc ctquy gquvnonb tbuk dvqrp jfrbb crrgfmpmtc xrsddt sukkytr ziwui qhuf fnxq qbievvszi. Nwlfmq hbqhjc pai tiuvqevtx edjg xgvtkufnb nofbp pwnfok rtvkeciri myxvpvy eynlyof ggyng uesonoemmc. Jkxwm vghmtfh dxj hjobht zdfudb zikyqjiap kzoqvdvu stte rbqresum cselz gsousja ybcew ommcxh sjbjly."
// Random.paragraph( len )
"Nxcomifcg mvgapkm fnjcmbsny cjolm nxuunvudw ucittqrjg vikwe ogmtfuk mhufktdl kdtmbr crrbkln ffdktjfe xbpk jgqjukb tdhjfr ytbyuxufc bwuzwayryh. Jzb pszek kdyqylb pktpc jqqfyzift rmdsa dnbyxxyq fvlosor xpjol djkkygs pwscfdje wyr udlup vvhr."
"Oghofxpvj hybrlc gucnklxvu loaxhe kvgzll nghd yfvr isop dmhbag sqvdydctsd pqvnlfl toxrhr. Dtyvrtx hvtugmfmp rueryh esnwfswcf ybppcb nrjxcuwig wswxifry fykjl oxg bfjbpm bhfdfmgs ryzxlqs vpbnfsp teqgdcfk vdoxa tqkb."
// Random.paragraph( min, max )
"Lraimqn cgr fhkqw itnzrsvoim pocpjkdil tbxkf amth jemrobyrn obxxyxf bwri gfjocdsa nrysnrjk jitdbfkxn."
"Lylfdvdvs wwjmkrsn imjhtdyju yjuumbxy lcue bogsxgivc vghcoihuoj rgenhur jxrvp jvwpeed rdvdkcyjxw kdbmmw kiquon vgvtgihh. Crudcfg zirrtx xmllpxyyi ririnobp pzjhku rizw pxborlp kjcahchu vkeoqgrctg geu ickxu hhexltsl nqjgnmmow glgxetbvj jpodrd yfbe tys. Rskdmu djvfv vblxwiylhw fuow upkuf fqldihw ijsiviots rcyv qvgvmpvs uxwacry dukv mspcvqkuk vkz vvql mehgwxuu jldzjrrps rqlolntc iwfpwrf."
```

`Random.sentence( min?, max? )`

```js
// Random.sentence()
Random.sentence()
Mock.mock('@sentence')
Mock.mock('@sentence()')
// Random.sentence( len )
Random.sentence(5)
Mock.mock('@sentence(5)')
// Random.sentence( min, max )
Random.sentence(3, 5)
Mock.mock('@sentence(3, 5)')
```

```js
// Random.sentence()
"Fflp dfcvnundq uuuk cwsebrtg skuh mpm yrnuk kobci tejqevebju odkbfj kqelr susvfynx qgwpqxom ion."
"Qujdeinrt srfgz wpisn vavv gpio zexhkmrjwb fngmhps ugcxxdnkh yesob qnvsnvfqw ufodmbpdeh oboeimc tmvslsy ftktivn vdhmsnbxgw hbfngcfzy."
"Kovduelmf ohnypx nhg orxnxobbp fiedqkcfgs pidrjbvc shygephg ssdrtjtwm twnww evufde zhmygotwwf rtputnnx rxsklxem xpp gjrp."
// Random.sentence( len )
"Xqimoq poclohzcx xqhbl vfbpyln vwnbgj."
"Wdkzsw amonvviwy hyc kyki kljx."
// Random.sentence( min, max )
"Idstwj wjnb iuhkxljmxi btntsw."
"Ukfj zdxtysb ftklzqyry."
```

`Random.word( min?, max? )`

```js
// Random.word()
Random.word()
Mock.mock('@word')
Mock.mock('@word()')
// Random.word( len )
Random.word(5)
Mock.mock('@word(5)')
// Random.word( min, max )
Random.word(3, 5)
Mock.mock('@word(3, 5)')
```

```js
// Random.word()
"pmwvzb"
"qbxegd"
"dnqpwvpa"
// Random.word( len )
"hjcvi"
"rnpli"
// Random.word( min, max )
"gags"
"egjk"
```

`Random.title( min?, max? )`

```js
// Random.title()
Random.title()
Mock.mock('@title')
Mock.mock('@title()')
// Random.title( len )
Random.title(5)
Mock.mock('@title(5)')
// Random.title( min, max )
Random.title(3, 5)
Mock.mock('@title(3, 5)')
```

```js
// Random.title()
"Ddyoof Ltlf Ydds Ptodv Pjtt"
"Vhdsojqqt Bmekwrt Qtniuptuwz Zetl Ooaeog Rwwaexnuc"
"Uucpktuf Lnvvdnfex Rprele Clrto Roumnduyb Yvctcybrti Wvwbzc"
// Random.title( len )
"Yuwlzq Wjunyfl Nnsjf Pymrzd Nlst"
"Prlwalnyc Elxqgblsg Hvosvoyw Jbpllu Vmvqyjqsge"
// Random.title( min, max )
"Uqxbdnbc Wddrkzt Yulijzxx Ezbgdhlu Swgxpbnyso"
"Thlixq Fwxixvq Rwmegnkam Kcnhh"
```

`Random.cparagraph( min?, max? )`

```js
// Random.cparagraph()
Random.cparagraph()
Mock.mock('@cparagraph')
Mock.mock('@cparagraph()')
// Random.cparagraph( len )
Random.cparagraph(2)
Mock.mock('@cparagraph(2)')
// Random.cparagraph( min, max )
Random.cparagraph(1, 3)
Mock.mock('@cparagraph(1, 3)')
```

```js
// Random.cparagraph()
"研林证山报机半车林斯王队打斯量府育。气称己消务术族各北界众满听文。千可府效铁基离张型时引而儿除温成资。话感使看区式管此点马起争数。效正列理率系战车深应动价感往快适她张。然干连周持此业同再照红关许六文机。立整干包六极听消内上认车支长开。"
"影表金集加因自手且话矿声话白复人导。然形置今点安几日能会北只万。场国许示照高指放积西维而引改导克认整。位具叫也务层类干求酸着采类。号阶三山多先则改放中料劳果。"
"引矿即下物酸资力金政就义制标张达王。们资实之何小则干上合张相按。之空六能维阶市相确证市当他太据。色参厂按条具眼造外角工被原很化局。"
// Random.cparagraph( len )
"七江五过料计全件深现场活。物应调集而质文年劳使有般很例究片质。"
"结受思做总装带般收术己队装说。越也集般地决年只理常也精义积表史转。"
// Random.cparagraph( min, max )
"两值接区即率技务界关而说许但书。单温美步全提然片型光由清品和如土全。车那军第改比非空即构代省员给入论族。"
"快面接反听厂得然万只江步些。以基持容五同时太按学或按变场素收道报。"
```

`Random.csentence( min?, max? )`

```js
// Random.csentence()
Random.csentence()
Mock.mock('@csentence')
Mock.mock('@csentence()')
// Random.csentence( len )
Random.csentence(5)
Mock.mock('@csentence(5)')
// Random.csentence( min, max )
Random.csentence(3, 5)
Mock.mock('@csentence(3, 5)')
```

```js
// Random.csentence()
"住边素地际我心而上花件色铁始指重。"
"打极农路影知金手等型七能信目特况布。"
"家三领先半气用切小期历去出青亲。"
// Random.csentence( len )
"间置克族类。"
"原部期构在。"
// Random.csentence( min, max )
"易是听表格。"
"业明铁造。"
```

`Random.cword( pool?, min?, max? )`

```js
// Random.cword()
Random.cword()
Mock.mock('@cword')
Mock.mock('@cword()')
// Random.cword( pool )
Random.cword('零一二三四五六七八九十')
Mock.mock('@cword("零一二三四五六七八九十")')
// Random.cword( length )
Random.cword(3)
Mock.mock('@cword(3)')
// Random.cword( pool, length )
Random.cword('零一二三四五六七八九十', 3)
Mock.mock('@cword("零一二三四五六七八九十", 3)')
// Random.cword( min, max )
Random.cword(3, 5)
Mock.mock('@cword(3, 5)')
// Random.cword( pool, min, max )
Random.cword('零一二三四五六七八九十', 5, 7)
Mock.mock('@cword("零一二三四五六七八九十", 5, 7)')
```

```js
// Random.cword()
"儿"
"队"
"支"
// Random.cword( pool )
"五"
"六"
// Random.cword( length )
"将解响"
"布先龙"
// Random.cword( pool, length )
"一三一"
"八六六"
// Random.cword( min, max )
"从切后"
"集温满受"
// Random.cword( pool, min, max )
"一六十八八一"
"四二九八十八二"
```

`Random.ctitle( min?, max? )`

```js
// Random.ctitle()
Random.ctitle()
Mock.mock('@ctitle')
Mock.mock('@ctitle()')
// Random.ctitle( len )
Random.ctitle(5)
Mock.mock('@ctitle(5)')
// Random.ctitle( min, max )
Random.ctitle(3, 5)
Mock.mock('@ctitle(3, 5)')
```

```js
// Random.ctitle()
"切把接料决"
"据些开只文果"
"使争规我"
// Random.ctitle( len )
"选了做感等"
"委明了也战"
// Random.ctitle( min, max )
"主业识口"
"信积角道提"
```

### Name

`Random.first()`

```js
// Random.first()
Random.first()
Mock.mock('@first')
Mock.mock('@first()')
```

```js
// Random.first()
"Kimberly"
"Lisa"
"Donald"
```

`Random.last()`

```js
// Random.last()
Random.last()
Mock.mock('@last')
Mock.mock('@last()')
```

```js
// Random.last()
"Taylor"
"Hernandez"
"Taylor"
```

`Random.name( middle? )`

```js
// Random.name()
Random.name()
Mock.mock('@name')
Mock.mock('@name()')
// Random.name( middle )
Random.name(true)
Mock.mock('@name(true)')
```

```js
// Random.name()
"Timothy Hernandez"
"Anthony Thompson"
"George Moore"
// Random.name( middle )
"Sandra Shirley Thomas"
"Patricia Sharon Davis"
```

`Random.cfirst()`

```js
// Random.cfirst()
Random.cfirst()
Mock.mock('@cfirst')
Mock.mock('@cfirst()')
```

```js
// Random.cfirst()
"龚"
"朱"
"陈"
```

`Random.clast()`

```js
// Random.clast()
Random.clast()
Mock.mock('@clast')
Mock.mock('@clast()')
```

```js
// Random.clast()
"超"
"霞"
"军"
```

`Random.cname()`

```js
// Random.cname()
Random.cname()
Mock.mock('@cname')
Mock.mock('@cname()')
```

```js
// Random.cname()
"周丽"
"汤勇"
"段娟"
```

### Web

`Random.url()`

```js
// Random.url()
Random.url()
Mock.mock('@url')
Mock.mock('@url()')
```

```js
// Random.url()
"mid://dlmgb.gt/rkxtosmdv"
"gopher://iydecrt.ne/xxuibon"
"nntp://ghmejjva.ge/ubrmjb"
```

`Random.domain()`

```js
// Random.domain()
Random.domain()
Mock.mock('@domain')
Mock.mock('@domain()')
```

```js
// Random.domain()
"uxsywvydij.tf"
"pimofbjo.nl"
"znrtrtpw.gh"
```

`Random.protocol()`

```js
// Random.protocol()
Random.protocol()
Mock.mock('@protocol')
Mock.mock('@protocol()')
```

```js
// Random.protocol()
"gopher"
"gopher"
"gopher"
```

`Random.tld()`

```js
// Random.tld()
Random.tld()
Mock.mock('@tld')
Mock.mock('@tld()')
```

```js
// Random.tld()
"jm"
"ci"
"cu"
```

`Random.email()`

```js
// Random.email()
Random.email()
Mock.mock('@email')
Mock.mock('@email()')
```

```js
// Random.email()
"k.duhmoe@qglgm.zw"
"c.rjxmox@orlgj.ma"
"x.kgkdpsbing@wvixnojc.yu"
```

`Random.ip()`

```js
// Random.ip()
Random.ip()
Mock.mock('@ip')
Mock.mock('@ip()')
```

```js
// Random.ip()
"186.224.27.169"
"16.189.161.135"
"66.214.168.122"
```

### Address

`Random.region()`

```js
// Random.region()
Random.region()
Mock.mock('@region')
Mock.mock('@region()')
```

```js
// Random.region()
"华中"
"华中"
"华中"
```

`Random.province()`

```js
// Random.province()
Random.province()
Mock.mock('@province')
Mock.mock('@province()')
```

```js
// Random.province()
"浙江省"
"香港特别行政区"
"台湾"
```

`Random.city( prefix? )`

```js
// Random.city()
Random.city()
Mock.mock('@city')
Mock.mock('@city()')
// Random.city( prefix )
Random.city(true)
Mock.mock('@city(true)')
```

```js
// Random.city()
"随州市"
"海南藏族自治州"
"娄底市"
// Random.city( prefix )
"山西省 阳泉市"
"广西壮族自治区 玉林市"
```

`Random.county( prefix? )`

```js
// Random.county()
Random.county()
Mock.mock('@county')
Mock.mock('@county()')
// Random.county( prefix )
Random.county(true)
Mock.mock('@county(true)')
```

```js
// Random.county()
"-"
"清丰县"
"黄岩区"
// Random.county( prefix )
"河南省 漯河市 临颍县"
"西藏自治区 那曲地区 其它区"
```

`Random.zip()`

```js
// Random.zip()
Random.zip()
Mock.mock('@zip')
Mock.mock('@zip()')
```

```js
// Random.zip()
"451253"
"747228"
"427772"
```

### Helper

`Random.capitalize( word )`

```js
// Random.capitalize( word )
Random.capitalize('hello')
Mock.mock('@capitalize("hello")')
```

```js
// Random.capitalize( word )
"Hello"
"Hello"
```

`Random.upper( str )`

```js
// Random.upper( str )
Random.upper('hello')
Mock.mock('@upper("hello")')
```

```js
// Random.upper( str )
"HELLO"
"HELLO"
```

`Random.lower( str )`

```js
// Random.lower( str )
Random.lower('HELLO')
Mock.mock('@lower("HELLO")')
```

```js
// Random.lower( str )
"hello"
"hello"
```

`Random.pick( arr )`

```js
// Random.pick( arr )
Random.pick(['a', 'e', 'i', 'o', 'u'])
Mock.mock('@pick(["a", "e", "i", "o", "u"])')
```

```js
// Random.pick( arr )
"e"
"u"
```

`Random.shuffle( arr )`

```js
// Random.shuffle( arr )
Random.shuffle(['a', 'e', 'i', 'o', 'u'])
Mock.mock('@shuffle(["a", "e", "i", "o", "u"])')
```

```js
// Random.shuffle( arr )
["a","o","e","u","i"]
["o","u","e","i","a"]
```

### Miscellaneous

`Random.guid()`

```js
// Random.guid()
Random.guid()
Mock.mock('@guid')
Mock.mock('@guid()')
```

```js
// Random.guid()
"C3A22fAa-1fEB-DcFD-79CA-dAeBE2f75fDB"
"78A9AbCD-7bfC-8Fc6-Ab05-D8bea2f2Dfbf"
"E1AD8cFB-E194-9BA6-EF1b-B2D71976BBdA"
```

`Random.id()`

```js
// Random.id()
Random.id()
Mock.mock('@id')
Mock.mock('@id()')
```

```js
// Random.id()
"330000198205045417"
"320000201411309869"
"420000201309284742"
```

`Random.increment( step? )`

```js
// Random.increment()
Random.increment()
Mock.mock('@increment')
Mock.mock('@increment()')
// Random.increment( step )
Random.increment(100)
Mock.mock('@increment(100)')
Random.increment(1000)
Mock.mock('@increment(1000)')
```

```js
// Random.increment()
1
2
3
// Random.increment( step )
103
203
1203
2203
```
