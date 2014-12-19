var category = {
	init : function(){
		$('#reset').click(function(){
			$('#answersNumber').val(1);
			category.answerInputs();
		});
		$('#addNewQuestion').click(function(){
	 		category.showWindow();
	 	});
	 	$('.exitIcon').click(function(){
	 		category.hideWindow();
	 	});
	 	$('#answersNumber').change(function(){
	 		category.answerInputs();
	 	});
	 	$('.editLink').click(function (){
	 		category.showEditWindow(this);
	 	});
		$('.removeLink').click(function (){
			category.removeQuestion(this);
	 	});
	},

	removeQuestion : function(link){
		var form		=	$(link).parent();
		var questionId	=	form.find('.questionId').val();
		$.ajax({
			  url: BASE.url + 'main/ajax_removeQuestion',
			  type: 'POST',
			  data: {'questionId' : questionId},
			  success: function() {
				  form.parent().fadeOut(1000);
				  form.parent().remove();
			  }
		});
	},
	
	showEditWindow : function(link){
		var questionId	=	$(link).parent().find('.questionId').val();
		$.ajax({
			  url: BASE.url + 'main/ajax_getQuestionData',
			  type: 'POST',
			  data: {'questionId' : questionId},
			  success: function(response) {
				  $('.editQuestion').html(response);
				  $('.overlay').fadeIn(500);
				  $('.editQuestion').fadeIn(1000);
				  $('.exitIcon').click(function(){
				 	category.hideWindow();
				  });
				  tinyMCE.init({
						mode : "textareas",
						theme : "advanced",
						plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

						theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : true,
					});
			  }
		});
	},
	
	showWindow : function(){
		this.answerInputs();
		$('#reset').click();
		$('.overlay').fadeIn(500);
		$('.hidden').fadeIn(1000);
		$('.editQuestion').hide();
	},
	
	hideWindow : function(){
		$('.overlay').fadeOut(1000);
		$('.hidden').fadeOut(500);
	},
	
	answerInputs : function(){
		var container	=	 $('#answersContainer');	
		var number		=	$('#answersNumber').val();
		container.empty();
		for(i = 1; i <= number; i++){
			var input	=	'<p><b>Number ' + i + '</b><br><input type="text" name="answers[]" /></p>'
			container.append(input);
		}
	}
}

$(document).ready(function(){
	category.init();
});