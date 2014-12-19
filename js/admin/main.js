var main ={
  init : function(){
    this.validate();
    this.pagination_init();
    this.filter_items();
    this.multiple_delete();
    this.checkUncheckAll();
    
  },
  
  validate : function(){
    $('#adding_form').validate({
      rules: {
        title : 'required',
        country_state: 'required',
        duration: 'required',
        link_to_apply: 'required',
        fan_page_id: 'required'
      },
      messages: {
        title : 'this field is required',
        country_state : 'this field is required',
        duration : 'this field is required',
        link_to_apply : 'this field is required',
        fan_page_id : 'this field is required'
      }
    });
  },
  
  pagination_init : function(){
    $('.page-far-left').click(function(event){
      event.preventDefault();
      var curr_page = $('#current_page').html();
      var filter = $('#select-page select').val();
      main.send_pagination_ajax(curr_page, filter, 'first');
    });
    
    $('.page-left').click(function(event){
      event.preventDefault();
      var curr_page = $('#current_page').html();
      var filter = $('#select-page select').val();
      main.send_pagination_ajax(curr_page, filter, '-10');
    });
    
    $('.page-right').click(function(event){
      event.preventDefault();
      var curr_page = $('#current_page').html();
      var filter = $('#select-page select').val();
      main.send_pagination_ajax(curr_page, filter, '+10')
    });
    
    $('.page-far-right').click(function(event){
      event.preventDefault();
      var curr_page = $('#current_page').html();
      var filter = $('#select-page select').val();
      main.send_pagination_ajax(curr_page, filter, 'last')
    });
  },
  
  send_pagination_ajax : function(current_page, filter, direction){
    $.ajax({
      url: sys.baseUrl + "admin/main/ajax_getPages",
      type: "POST",
      data: {curpage : current_page, direction : direction, filter: filter},
      dataType: "json",
      success: function(data){
        $('#product-table tbody .job_item').remove();
        $('#product-table tbody').append(data.html);
        $('#current_page').html(data.current);
        $('#all_pages').html(data.count);
        main.remakeCheckboxes();
        $('#toggle-all').removeClass('toggle-checked');
      }
    });
  },
  
  filter_items : function(){
    $('#select-page select').change(function(){
      var curr_page = $('#current_page').html();
      var filter    = $(this).val();
      main.send_pagination_ajax(curr_page, filter, 'first');
    });
  },
  
  deleteItem : function(link, id){
    var ids = new Array();
    ids.push(id);
    this.delet_item_ajax(ids.join());
    this.hide_item(link);
  },
  
  hide_item : function(link){
    $(link).parents('tr.job_item').fadeOut(500,function(){
//      $('#select-page select').trigger('change');
    });
  },
  
  delet_item_ajax : function(ids){
    $.ajax({
      url: sys.baseUrl + "admin/main/ajax_delItem",
      type: "POST",
      data: {ids : ids},
      dataType: "json"
    });
  },
  
  multiple_delete : function(){
    $('.action-delete').click(function(event){
      event.preventDefault();
      var selects = $('.ui-checkbox-state-checked');
      var ids = new Array();
      selects.each(function(){
        id = $(this).parent().find('input').val();
        ids.push(id);
      });
      main.delet_item_ajax(ids.join());
      selects.each(function(){
         main.hide_item(this);
      });
    });
  },
  
  remakeCheckboxes : function(){
    $(':checkbox').each(function(){
      $(this).addClass('ui-helper-hidden-accessible');
      $(this).parent().append('<span class="ui-checkbox "></span>');
    });
  },
  
  checkUncheckAll : function(){
    $('#toggle-all').click(function(){
      var isChecked = $(this).hasClass('toggle-checked');
      var allCheckboxes  =  $('.ui-checkbox');
      allCheckboxes.each(function(){
        if(!isChecked){
          $(this).addClass('ui-checkbox-state-checked');
        }else{
          $(this).removeClass('ui-checkbox-state-checked');
        }
      });
    });
  }
  
  
}


$(document).ready(function(){
  main.init();
});

