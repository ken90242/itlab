        <link href="css/main_menu.css" rel="stylesheet" type="text/css"><!-- x -->
		<link href="css/reset.css" rel="stylesheet" type="text/css"><!-- x -->
		<link href="css/laser.css" rel="stylesheet" type="text/css"><!-- x -->
		
<?php
	session_start();
	echo '<div id="textDiv"></div>';
	echo '<form id="childform" action="./equipment_lend_return_multi.php" method="post" onsubmit="return ray.ajax('.@$_SESSION['times'].')">';
	
	for($x=1;$x<=@$_SESSION['times'];$x++){
		echo @$_SESSION['divv'.$x];
	}
	if(checkifanysessionexist()=='y'){ 
		echo '<div id="adot">';
		echo '<br>';
		echo '<input type="text" id="assname" placeholder="經辦助理ID" name="tra_handler_test" style="float:left" onkeyup="showHint(this.value)">';
		echo '<input type="hidden" id = "assname1" name="tra_handler" style="float:left">';
		echo '<div id="handler_name" style="float:left;padding-left: 5px;"></div>';	
		echo "<input id=\"submit4\" type=\"submit\" value=\"\" onClick=\"CKAddGust3(".$_SESSION['times'].")\">";
		echo '</div>';
	}
	
	echo '</form>';

	function checkifanysessionexist(){
		for($z=1;$z<=@$_SESSION['times'];$z++){
			if(@$_SESSION['divv'.$z]!=NULL){
				return 'y';
			}
		}
		return 'n';
	}
?>
<script type="text/javascript">
var ray={
			ajax:function(total_timess){
				var assitnat_name = document.getElementById("handler_name").innerHTML;
				var myList = document.getElementsByClassName("returned");
				var prom_doll_in = 0;
				var prom_doll_out = 0;
				var back_str = "";	
				if(myList.length==0){
					back_str = '無';
				}
				else if(myList.length>1){
					for(var x=1;x<myList.length;x++){
						back_str = myList[0].value;
						back_str = back_str+','+myList[x].value;
					}
				}else if(myList.length<=1){
					for(var x=0;x<myList.length;x++){
						back_str = back_str+myList[x].value+'  ';
					}
				}

				var a = 0;
				var b = 0;
				var STRS = new Array();
				var STRS2 = new Array();
				for(var j=1;j<=total_timess;j++){
					var word = 'bck_chs'+j;
					var oRadio = document.getElementsByName(word);
					if((oRadio[0]||oRadio[1])&&(!oRadio[2])){
						if(oRadio[0].checked){
							a = document.getElementById(word).value;
							STRS.push(a);
						}else if(oRadio[1].checked){
							b = document.getElementById(word).value;
							STRS2.push(b);
						}
					}else if((oRadio[0]||oRadio[1])||(oRadio[2])){
						if(oRadio[2].checked){
							a = document.getElementById(word).value;
							STRS.push(a);
						}else if(oRadio[1].checked){
							b = document.getElementById(word).value;
							STRS2.push(b);
						}
					}
				}
				var out_str_1 = "無";
				var out_str_2 = "無";
				for(var k=0;k<STRS.length;k++){
					if(k==0){
						out_str_1 = STRS[k];
					}else{
						out_str_1 = out_str_1+','+STRS[k];
					}
				}
				for(var l=0;l<STRS2.length;l++){
					if(l==0){
						out_str_2 = STRS2[l];
					}else{
						out_str_2 = out_str_2 +','+STRS2[l];
					}
				}

				
				var xmlhttp1;
				if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp1=new XMLHttpRequest();
				}
				else{// code for IE6, IE5
					xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp1.onreadystatechange=function(){
					if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
						prom_doll_in = xmlhttp1.responseText;
						window.top.document.getElementById('money').innerText = '此次保證金金額共為: '+prom_doll_in+' 元';
					}
				}
				xmlhttp1.open("GET","calcu_margin.php?q="+back_str,true);
				xmlhttp1.send();

				var xmlhttp2;
				if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp2=new XMLHttpRequest();
				}
				else{// code for IE6, IE5
					xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp2.onreadystatechange=function(){
					if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
						prom_doll_out = xmlhttp2.responseText;
						window.top.document.getElementById('money_back').innerText = '此次歸還保證金金額共為: '+prom_doll_out+' 元';
					}
				}
				xmlhttp2.open("GET","calcu_margin.php?q="+out_str_2,true);
				xmlhttp2.send();



				window.top.document.getElementById('out').innerText = '此次借用項目為: '+back_str;
				window.top.document.getElementById('back_c').innerText = '此次續借項目為: '+ out_str_1;
				window.top.document.getElementById('back').innerText = '此次歸還項目為: '+ out_str_2;
				window.top.document.getElementById('astname').innerText = assitnat_name;
				window.top.document.getElementById('sign_up').style.display='';
				window.top.document.getElementById('lightbox-shadow').style.display='';

				var xmlhttp;
				if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						fine_text_array = xmlhttp.responseText.split("-");
						if(fine_text_array[0]==''){
							fine_text_array[0]='無';
						}
						window.top.document.getElementById('out_deadline').innerText = '此次超出歸還時間項目為: ' + fine_text_array[0] ;
						window.top.document.getElementById('fine').innerText = '此次需繳交罰金金額為: ' + fine_text_array[1] + '元';
						var total_pay_rec_mon = prom_doll_in - prom_doll_out + parseInt(fine_text_array[1]);  
						var tprm_txt = "";
						if(total_pay_rec_mon>0){
							tprm_txt = '借用者共需繳交: ' + total_pay_rec_mon + '元 保證金';
						}else if(total_pay_rec_mon<0){
							total_pay_rec_mon = 0 - total_pay_rec_mon;
							tprm_txt = 'Itlab共須退還: ' + total_pay_rec_mon + '元 保證金';;
						}else{
							tprm_txt = '此次借還程序雙方無須繳交/退還保證金';
						}
						window.top.document.getElementById('final_account').innerText = tprm_txt;
					}
				}
				xmlhttp.open("GET","over_deadline_form.php?q="+STRS2,true);
				xmlhttp.send();

				return false;
			}
		}
	function insert_class(){
		if(document.getElementById('spec_item_func_lend').checked){
			document.getElementById('decide_end_menu').className = 'returned';
		}else if(document.getElementById('spec_item_func_return').checked){
			document.getElementById('decide_end_menu').className = 'borrowed';
		}else if(document.getElementById('spec_item_func_continue_borrow').checked){
			document.getElementById('decide_end_menu').className = 'borrowed';
		}
	}
	function removed(tim){
        var xmlhttp;
        document.getElementById("textDiv").innerText = "";
        //if there's no equipment on the list, remove adot div(assistent ID and submit button)

        var test=0;
        if(document.getElementById("divv"+tim).className.indexOf("divv") > -1){
             var parentItemId = document.getElementById("divv"+tim).className;
            for(var arr=document.getElementsByClassName(parentItemId).length-1;arr>=0;arr--){
                document.getElementById(parentItemId).parentNode.removeChild(document.getElementsByClassName(parentItemId)[arr]);
            }
            document.getElementById(parentItemId).parentNode.removeChild(document.getElementById(parentItemId));
            var remove_item = parentItemId;
        }else{
            document.getElementById('divv'+tim).parentNode.removeChild(document.getElementById('divv'+tim));
            var remove_item = 'divv'+tim;
        }

        for(var i=0;i<document.getElementById("childform").getElementsByTagName("div").length;i++){
            if(document.getElementById("childform").getElementsByTagName("div")[i].id.toString().indexOf("divv") > -1){
                test=1;
            }
            if(test==0){
                document.getElementById("adot").parentNode.removeChild(document.getElementById("adot"));
            }   
        }
        if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else{// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                console.log(xmlhttp.responseText);
            }
        }
            xmlhttp.open("GET","remove_multi.php?q="+remove_item,true);
            xmlhttp.send();
    }
	function CKAddGust3(total_times){
		var div = document.getElementById("textDiv");
		if((document.getElementById('handler_name').innerText == "No such person!")||(document.getElementById('handler_name').innerText == "")){
			div.innerText = "經辦助理欄位錯誤(查無此人)!";
			div.style.color = "red";
			document.getElementById('assname').focus();
			document.getElementById('handler_name').innerHTML == "";
			event.returnValue = false;
		}
		if(document.getElementById('assname').value == ""){
			div.innerText = "尚未填寫經辦助理欄位";
			div.style.color = "red";
			document.getElementById('assname').focus();
			event.returnValue = false;
		}
		for(var x=1;x<=total_times;x++){
			if(document.getElementById('fill_class'+x)){
				var valuee = document.getElementById('fill_class'+x).value;
				if(valuee == ""){
					div.innerText = "器材尚未填寫[使用課程]欄位!";
					div.style.color = "red";
					document.getElementById('fill_class'+x).focus();
					event.returnValue = false;
					break;
				}
			}
		}
		document.getElementById('assname1').value = document.getElementById('handler_name').innerHTML;
	}
	function showHint(str){
		var xmlhttp;
		if(str.length==0){ 
			document.getElementById("handler_name").innerHTML="";
			return;
		}
		if(window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("handler_name").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","gethint.php?q="+str,true);
		xmlhttp.send();
	}
</script>
