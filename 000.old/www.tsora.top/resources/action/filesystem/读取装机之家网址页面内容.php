<?php
/**
* 
* 
* 
* 
* 
* 
* 
*/



// 获取电脑配置页面数量
function extract_lotpc_page_num(){
	$html=file_get_contents("http://www.lotpc.com/dnpz/");
	$html2 = preg_replace('/\r|\n|  /', '', $html);
    // echo "<textarea style='width:1200px;height:300px;'>" . $html2 . "</textarea>";
	preg_match_all('/<span class="pageinfo">共 <strong>(.*?)<\/strong>页<strong>(.*?)<\/strong>条<\/span>/i',$html2,$step1_ul);
    // var_dump($step1_ul);
    // echo count($step1_ul[0]);
	$page_num=array("page"=>(int)$step1_ul[1][0],"num"=>(int)$step1_ul[2][0]);
    // var_dump($page_num);
	return $page_num;
    // echo "<textarea style='width:1200px;height:300px;'>" . $step1_ul[0][0] . "</textarea>";


}
// 抓取电脑配置页面内容
function extract_lotpc_content_35($page){
	$html=file_get_contents("http://www.lotpc.com/dnpz/35_" . $page . ".html");
	$html2 = preg_replace('/\r|\n|  /', '', $html);
	
	preg_match_all('/<li><div class="li-main">(.*?)<strong class="h3">(.*?)<a href="(.*?)" target="_blank">(.*?)<\/a><div class="li-ext"><span class="c666">(.*?)\[(.*?)\]<\/a><\/span><\/div><\/strong><p class="ext">(.*?)<a href="(.*?)" target="_blank" class="imp">\[查看全文\]<\/a> <span style="float:right;">(.*?) &nbsp;(.*?)<\/li>/i',$html2,$step1_ul);
	// if(count($step1_ul[0])!==10){
		// echo "<br>页面数据获取不足：".$page;
	// }
	$lotpc_dnpz=array();
	foreach($step1_ul[0] as $key=>$value){
		// var_dump($key);
		array_push($lotpc_dnpz,array(
			"name"=>preg_replace("/\<b\>|\<\/b\>/","",$step1_ul[4][$key]),
			"tag"=>$step1_ul[6][$key],
			"link"=>$step1_ul[3][$key],
			"description"=>$step1_ul[7][$key],
			"ctime"=>$step1_ul[9][$key]));
	}
	return $lotpc_dnpz;


}

/**
* 
* 
* 
* 
* 
* 
* @todo 第527个页面后的价格取值错误
*/
// 读取详细页面内容
function extract_lotpc_content($url){
	var_dump($url);
	$html = preg_replace('/\r|\n|\t|  /', '', file_get_contents($url));
    // echo "<textarea style='width:900px;height:300px;'>" . $html . "</textarea>";
	// preg_match_all('/<table class="table_specs" width="100%"><thead><tr class="firstRow"><th colspan="3">(.*?)<\/th><\/tr><\/thead><tbody><tr><th width="15%">配件名称<\/th><td width="60%"><strong>品牌型号<\/strong><\/td><td width="15%"><strong>参考价格<\/strong><\/td><\/tr><tr><th>处理器<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th>散热器<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th>显卡<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th height="13">主板<\/th><td height="13">(.*?)<\/td><td height="13">(.*?)<\/td><\/tr><tr><th>内存<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th>硬盘<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th>机箱<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th>电源<\/th><td>(.*?)<\/td><td>(.*?)<\/td><\/tr><tr><th>显示器<\/th>(.*?)<tr><th>价格合计<\/th><td colspan="2">(.*?)<\/td><\/tr><\/tbody><\/table>/i',$html,$step1_table);
	preg_match_all('/<tbody>(.*?)<\/tbody>/i',$html,$step1_tbody);
	    // echo "<textarea style='width:900px;height:300px;'>" . $html . "</textarea>";
	// var_dump($step1_tbody[0]);

	if(count($step1_tbody[0])!==0){
		preg_match_all('/<tr><th(.*?)<\/th><td(.*?)<\/td><td(.*?)<\/td><\/tr>/i',$step1_tbody[0][count($step1_tbody[0])-1],$step2_tr);
		// var_dump(count($step2_tr[0]));
		if(count($step2_tr[0])==0){
			preg_match_all('/<tr><td(.*?)<\/td><td(.*?)<\/td><td(.*?)<\/td><\/tr>/i',$step1_tbody[0][count($step1_tbody[0])-1],$step2_tr);
		}
		if(count($step2_tr[0])==0){
			preg_match_all('/<tr bgcolor="#ffffff"><td align="center" bgcolor="#f7f9ff" height="30" style="margin: 0px; padding: 0px; word-wrap: break-word;">(.*?)<\/td><td align="center" height="30" style="margin: 0px; padding: 0px; word-wrap: break-word;">(.*?)<\/td><td(.*?)<\/td><\/tr>/i',$step1_tbody[0][count($step1_tbody[0])-1],$step2_tr);
		}

	    // echo "<textarea style='width:900px;height:300px;'>" . $step1_tbody[0][count($step1_tbody[0])-1] . "</textarea>";


		// 合计价格
		preg_match_all('/<td colspan="2">(.*?)<\/td>/i',$step1_tbody[0][count($step1_tbody[0])-1],$step3_tr);
		// $lotpc_price=array();
		// foreach($step2_tr[0] as $key=>$value){
			// var_dump($key);
			// array_push($lotpc_dnpz,array("name"=>$step1_ul[4][$key],"tag"=>$step1_ul[6][$key],"link"=>$step1_ul[3][$key],"description"=>$step1_ul[7][$key],"ctime"=>$step1_ul[9][$key]));
		// }

		// var_dump($step2_tr);
		// var_dump($step3_tr);
		$lotpc_price=array(
			"cpu"=>"","cpu_price"=>0,
			"cpu_fan"=>"","cpu_fan_price"=>0,
			"mb"=>"","mb_price"=>0,
			"vga"=>"","vga_price"=>0,
			"ram"=>"","ram_price"=>0,
			"hdd"=>"","hdd_price"=>0,
			"case"=>"","case_price"=>0,
			"power"=>"","power_price"=>0,
			"price_all"=>0);
		foreach($step2_tr[1] as $key=>$value){
			$hardware=preg_replace('/&nbsp;|.*?>|>/',"",$value);
			if($hardware==""){
				$hardware=preg_replace('/<.*?>/',"",$value);
			}


			// var_dump($hardware);
			switch ($hardware) {
				case "CPU":case "处理器":
				$lotpc_price["cpu"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["cpu_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "散热器":
				$lotpc_price["cpu_fan"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["cpu_fan_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "主板":
				$lotpc_price["mb"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["mb_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "显卡":
				$lotpc_price["vga"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["vga_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "内存":
				$lotpc_price["ram"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["ram_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "硬盘":case "固态硬盘":case "机械硬盘":
				$lotpc_price["hdd"] .= preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]).";";
				$lotpc_price["hdd_price"] += (int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "机箱":
				$lotpc_price["case"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["case_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "电源":
				$lotpc_price["power"]=preg_replace('/&nbsp;|.*?>/',"",$step2_tr[2][$key]);
				$lotpc_price["power_price"]=(int)preg_replace("/.*?￥|——/","",$step2_tr[3][$key]);
				break;
				case "价格合计":case "参考价格":
				$step2_tr[2][$key]=preg_replace("/.*?￥|——|<.*?>/","",$step2_tr[2][$key]);
				$lotpc_price["price_all"]=(int)preg_replace("/.*?￥|——|.*?>|<.*?>/","",$step2_tr[2][$key]);
				break;
				default:
				break;
			}

			
		}
		if(!$step3_tr[0]==0){
		// 	// var_dump(count($step3_tr[0]));
		// 	// var_dump(count($step2_tr[0]));
			$lotpc_price["price_all"]=(int)preg_replace("/.*?￥|——|.*?>/","",$step3_tr[1][0]);


		}

		// var_dump($lotpc_price);

		return $lotpc_price;

	}






}