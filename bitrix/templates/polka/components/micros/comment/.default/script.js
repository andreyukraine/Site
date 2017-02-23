$(function(){
	md_ShowMessage();
	var inputs=$("#MDComment_Ajax_Container form input[type='text'], #MDComment_Ajax_Container form textarea");
	inputs.each(function(){
		if($(this).val()=="")
		{
			$(this).val($(this).data("value"));
		}
	});
	inputs.on("focus", function(){
		var def=$(this).data("value");
		if(def && $(this).val()==def)
		{
			$(this).val("");
		}
	});
	inputs.on("blur", function(){
		var def=$(this).data("value");
		if(def && $(this).val()=="")
		{
			$(this).val(def);
		}
	});
	
	
	
	
});
function md_validate(_this)
{	var form=$(_this);
	var action=$(_this).attr("action");
	var p=$(".md_err", form);
	
	$(".md_err").html("");
	var error=false;
	var email=false;
	form.find("input[type='text'], input[name='MD_MASSAGE'], textarea").each(function(){
		if($(this).val()==""){
			error=true;
		}
		if($(this).hasClass("email") && !CheckEmail($(this).val()))
		{
			email=true;
		}
		
		
	});
	if(error)
	{
	
	p.html(MD_FILL);	
	md_ShowMessage();
	return false;	
	}
	else if(email)
	{
	
	p.html(MD_EMAIL_ERROR);	
	md_ShowMessage();
	return false;	
	}else{
	
		var sub="";
		form.find("input, textarea").each(function(){
			sub+=$(this).attr("name")+"="+$(this).val()+"&";
	});
		sub+="clear_cache=Y";
		//var data=form.serialize()+"&clear_cache=Y+&MD_MASSAGE2="+$("textarea[name='MD_MASSAGE']", form).val();
/*		 $.ajax({
		      type: "POST",
		      url: action,
		      dataType: "text",
		      data: data,
		      contentType: "application/x-www-form-urlencoded; charset=windows-1251",
		      success: function(html) {
		    	  $("#MDComment_Ajax_Container").html(html);
					BX.closeWait();
					md_ShowMessage();
		      }
		    });    */ 
		  
	
	//console.log(sub); 
		BX.showWait();
		$.post(action+"?clear_cache=Y&clear_session_cache=Y", sub, function(result){
			$("#MDComment_Ajax_Container").html(result);
			BX.closeWait();
			md_ShowMessage();
		}); 
		return false; 
	}
}
function CheckEmail(val)
{
	 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	    return emailReg.test(val)
}
function md_delete(_this, id, message)
{
	
if(!message) var message=MD_DELETE_MESS;
	if(confirm(message)){
		BX.showWait();
	$(_this).parents(".stock:first").hide("slow");
	
		$.post(location.pathname+"?clear_cache=Y&clear_session_cache=Y", {"MD_POST":"Y", "ACTION":"delete", "COM_ID":id, "clear_cache":"Y"}, function(data){
			$("#MDComment_Ajax_Container").html(data);
			BX.closeWait();
			md_ShowMessage();
		});
	}
	
	return false;
}

function md_edit(_this, id)
{
	$(".main_form").hide();
	$(".form_for").hide();
	$("#edit_form_"+id).show();
}
function md_add(_this, id)
{
	$(".main_form").hide();
	$(".form_for").hide();
	$("#add_form_"+id).show();
}
function md_back()
{
	$(".main_form").show();
	$(".form_for").hide();
	//$("#add_form_"+id).show();
}
var action=false;
function md_ShowMessage()
{	$(".suc_exp, .err_exp").remove();
	var err=$(".md_err").text();
	var suc=$(".md_suc").text();
	clearTimeout(action);
	if(err.length>0)
	{
		var exp="<div onclick='Exp_close()' class='err_exp'>"+err+"</div>";
		$("body").prepend(exp);
		$(".err_exp").fadeIn(500);
	}else if(suc.length>0)
	{
		var exp="<div onclick='Exp_close()' class='suc_exp'>"+suc+"</div>";
		$("body").prepend(exp);
		$(".suc_exp").fadeIn(500);
	}
	
	action=setTimeout(function(){
		 Exp_close();
	}, 5000);	
	
}
function Exp_close(){
	$(".suc_exp, .err_exp").fadeOut(1000);
		setTimeout(function(){
			$(".suc_exp, .err_exp").remove();
		}, 1000);
	
	
}

