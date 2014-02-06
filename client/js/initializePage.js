var item;
$('document').ready(function(){
  $('#app-container').initialize_Gtd();
  $('.rd-graph').enable_Graphs();

  //hide/toggle hours
  $('#company-show #hour-table .basic-table').hide();
  $('#company-show #hour-table h3').click(function(){
    $('#company-show #hour-table .basic-table').toggle();
  });

  //hide/toggle notes
  $('#company-show #note-table .basic-table').hide();
  $('#company-show #note-table h3').click(function(){
    $('#company-show #note-table .basic-table').toggle();
  });

});

$.fn.initialize_Gtd = function(){
  $('table .button',this).enable_Button();
  $('.date-field',this).enable_DateField();
  $('.basic-table',this).enable_TableSort();
  //  $('.basic-table-container',this).enable_QuickSearch();
  $('.js-swappable-btn',this).enable_Swappable();
  $('.js-hideable-btn',this).enable_Hideable();
  $('.multiple-buttons-btn',this).enable_MultipleButtons();
  $('input[name=ajax_target_id]',this).enable_Ajax();
  $('input[name*=auto_submit]',this).enable_AutoSubmit();
  $('.check-all',this).enable_SelectAll();
  $('#bookmark-link').enable_Bookmark();
  $('#timer-link').enable_Timer();
  $('#timer-widget-box #timer-time').create_Timer();
  $('#timer-widget-box #timer-submit').finish_Timer();
  $('#timer-widget-box #timer-pause').start_Timer();
  $('.hours-field').roundToQuarter();
  $('.flyout').enable_SidebarMenu();
  return this;
}


$.fn.roundToQuarter = function() {
  $(this).change(function() {
    $(this).val(Math.ceil(parseFloat($(this).val()) * 4) / 4);
  });
}

$.fn.enable_SidebarMenu = function(){
  $('.sidebar-button',this).click(function(){
    var menu = $(this).next('.flyout-menu');
    var bg = $('#screen-cover');

    $('.flyout-menu').hide();
    menu.show();
    bg.show();

    var click_handler = $(bg).click(function(){
      $(bg).hide();
      $(menu).hide();
      $(bg).unbind('click', click_handler);
    });
  });
}

$.fn.enable_Bookmark = function(){
  $('#bookmark-close').click(function(){
    $('#bookmark-form-box').fadeOut(200);
  });
  $(this).click(function(){
    var url = window.location.href;
    var title = $('h1#title').text();
    $.ajax({
      method: 'get',
      url:'index.php',
      data:{controller:'Bookmark',action:'new_form',ajax:true,description:title,source:url},
      success: function(data){
        $('#bookmark-form').html(data);
        $('#bookmark-form-box').fadeIn(200);
      }
    });    
  });
}

$.fn.enable_Timer = function() {
  $(this).click(function() {
    $('#timer-widget-box').css('width', 'auto').css('margin', '15px 5px');
    $('#timer-link').css('width', 0);
  });
}

$.fn.start_Timer = function() {
  $(this).click(function() {
    if($(this).val() == 'Start') {
      $('#timer-widget-box #timer-pause').val('Stop');
      $('#timer-widget-box #timer-submit').attr('disabled', 'disabled');
      $('#timer-widget-box #timer-time').attr('disabled', 'disabled');
      if(($('#timer-widget-box #timer-time').val() == '') || ($('#timer-widget-box #timer-time').val() == '0')) {
        totalSeconds = 0;
      }
      timeouts.push(window.setTimeout("clocktick()", 1000));
    } else {
      for (var i = 0; i < timeouts.length; i++) {
        clearTimeout(timeouts[i]);
      }
      timeouts = [];
      $('#timer-widget-box #timer-time').removeAttr('disabled');
      $('#timer-widget-box #timer-pause').val('Start');
      if(totalSeconds != 0) {
        $('#timer-widget-box #timer-submit').removeAttr('disabled');
      }
    }
  });
}

var timer;
var totalSeconds = 0;
var timeouts = [];

$.fn.create_Timer = function() {
  timer = $(this);
  update_Timer();
}

function clocktick() {
  totalSeconds += 1;
  update_Timer();
  timeouts.push(window.setTimeout("clocktick()", 1000));
}

function update_Timer() {
  var seconds = totalSeconds;
  var days = Math.floor(seconds / 86400);
  seconds -= days * 86400;
  var hours = Math.floor(seconds / 3600);
  seconds -= hours * (3600);
  var minutes = Math.floor(seconds / 60);
  seconds -= minutes * (60);
  var time_Str = ((days > 0) ? days + " days " : "") + leadingZero(hours) + ":" + leadingZero(minutes) + ":" + leadingZero(seconds)

  $(timer).val(time_Str);
}

function leadingZero(time) {
  return (time < 10) ? "0" + time : + time;
}


$.fn.finish_Timer = function() {
  $(this).click(function() {
    if(($('#log-hours-for-support').parent().css('display') == 'none') && ($('#log-hours-for-project').parent().css('display') == 'none')) {
      $('.btn-1').addClass('btn-danger');
      $('.btn-2').addClass('btn-danger');
    }
    seconds = totalSeconds;
    var hours = Math.floor(seconds / 3600);
    seconds -= hours * (3600);
    var minutes = Math.ceil((seconds / 60) / 15);
    $('.hours-field').val(hours + (minutes * .25));
  });
}

$.fn.enable_Graphs= function(){
  $(this).each(function(){
    new RdGraph({element:this});
  });
}

$.fn.slideFadeIn = function(speed, easing, callback) {
  return this.animate({opacity: 'show', height: 'show'}, speed, easing, callback);  
}

$.fn.slideFadeOut = function(speed, easing, callback) {          
  return this.animate({opacity: 'hide', height: 'hide'}, speed, easing, callback);  
}

$.fn.enable_Button= function(){
  $(this).each(function(){
    $(this).hover(
      function() { $(this).addClass('ui-state-hover'); },
      function() { $(this).removeClass('ui-state-hover'); }
    ); 
  });
}

$.fn.enable_DateField= function(){
  $(this).datepicker({ dateFormat: 'yy-mm-dd'});
  return this;
}

$.fn.enable_TableSort = function (){
    $.extend($.tablesorter.themes.bootstrap, {
      table      : 'table',
      header     : 'bootstrap-header', // give the header a gradient background
      footerRow  : '',
      footerCells: '',
      icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
      sortNone   : '',
      sortAsc    : 'icon-chevron-up',
      sortDesc   : 'icon-chevron-down',
      active     : '', // applied when column is sorted
      hover      : '', // use custom css here - bootstrap class may not override it
      filterRow  : '', // filter row class
      even       : '', // odd row zebra striping
      odd        : ''  // even row zebra striping
    });

    $(".tablesorter").tablesorter({
      theme : "bootstrap", // this will 
      widthFixed: true,
      headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
      widgets : [ "uitheme", "zebra" ],
      widgetOptions : {
        zebra : ["even", "odd"],
        filter_reset : ".reset",
      }
      //STILL NEEDS TO BE CHANGED MANUALLY TO MATCH boot/constraints.php
    }).tablesorterPager({container: $("#pager"), size: 20});

  return this;
}

$.fn.enable_QuickSearch = function (){
  $(this).each( function() {
    rows = $(this)
    .children('.basic-table')
    .children('tbody')
    .children('tr');
    selector =   $(this)
    .children('.quicksearch')
    .children('form')
    .children('.qs-input');
    selector.quicksearch(rows);
  });
  return this;
}

$.fn.enable_Swappable = function (){
  $(this).each( function(){
    $(this).click( function(){
      $(this).siblings('.swappable-item').toggle();
    })
  });
  return this;
}

$.fn.enable_MultipleButtons= function (){
  $(this).each( function(){
    $(this).click( function(){
      item = $('[data-id=' + $(this).attr('data-id') + ']', '.multiple-buttons-targets');
      if (item.css('display')=='none'){
        item.siblings().slideFadeOut(180, 'easeInCubic').delay(240);
        item.slideFadeIn(180, 'easeOutCubic');
        setTimeout( function(){
          $(':input:visible:first', item).focus();
        }, 100);
      }else{
        item.hide();
      }
    })
  });
  return this;
}


$.fn.enable_Hideable = function (){
  $(this).each( function(){
    $(this).click( function(){
      item = $(this).siblings('.hideable-item');
      $('.hideable-item').slideFadeOut(180,'easeInCubic').delay(240);
      if ( item.css('display') == 'none' ){
        item.slideFadeIn(180,'easeOutCubic');
      }
    })
  });
  return this;
}

$.fn.enable_MultiSelect = function(){
  $(this).multiSelect({oneOrMoreSelected: '*'});
  return this;
}

$.fn.enable_AutoSubmit = function(){
  $(this).each( function(){
    var auto_submit_input_name = '[name*='+$(this).val()+']';

    var form = $( this ).parent('form');

    $('.submit-container',form).hide();
    $('select#hour_search_staff_id').css('float','left').next().css('margin', '0px 10px').css('float','left').show();
    $(auto_submit_input_name,form).change(function(){
      $(form).submit();
    });
  });
}

$.fn.enable_SelectAll = function(){
  $(this).click( function(){
    $('.check-row').attr('checked', $(this).attr('checked'))
  });
}

$.fn.enable_Ajax = function(){

  $(this).each( function( index, value){
    var selector = this;
    var ajax_target_id = '#'+$(this).val();

    initializeSubmitButtons( selector, ajax_target_id);
  });

  function initializeSubmitButtons( selector, ajax_target_id){
    $( selector ).parents('form').submit( function(){
      form = this;
      getGraphData(ajax_target_id);
      return false;
    });
  }
  function getGraphData( ajax_target_id ){
    showLoaderGraphic();
    $.ajax({
      type: 'GET',
      url: 'index.php',
      data: serializeFormData(),
      success: function(JSONtext){
        loadView( ajax_target_id, JSONtext);
        //        initializeSubmitButtons();
        $( ajax_target_id ).initialize_Gtd();
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        hideLoaderGraphic();
        console.log('AJAX request failed');
        console.log('Request: ' + XMLHttpRequest);
        console.log('Text: ' + textStatus);
        console.log('Error: ' + errorThrown);
      }
    });
  }
  function loadView( ajax_target_id, html ){
    //console.log('LOADING VIEW: ' + ajax_target_id);
    //console.log(html);
    $(ajax_target_id).html( html );
    hideLoaderGraphic();
  }
  function serializeFormData() {
    var sel, serializedData = "";
    if (!form) return false;
    $( ':input', form).each(function(){
      serializedData += $(this).attr('name') + "=" + $(this).val() + "&";
    });
    selectBoxes = form.getElementsByTagName("select");
    if( selectBoxes) {
      total = selectBoxes.length;
    } else {
      total = 0;
    }
    for ( i=0; i<total; i++) {
      sel = selectBoxes[i];
      serializedData += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
    }
    return encodeURI( serializedData);
  }
  function showLoaderGraphic() {
    $('.loader').html('<div style="margin: 25% 44%">'+
                      '<div style="text-align:center; width:50px"><img src="/img/ajax-loader.gif" /></div>'+
                      '<div style="color:#993333; text-align:center; width:50px; font-weight:bold">Loading</div>'+
                      '</div>');
  }
  function hideLoaderGraphic() {
    $(' .loader').html('');
  }
  function url( param) {
    var regex = '[?&]' + param + '=([^&#]*)';
    var results = (new RegExp(regex)).exec(window.location.href);
    if(results) return results[1].replace('%20',' ');
    return false;
  }
  return this;
}
