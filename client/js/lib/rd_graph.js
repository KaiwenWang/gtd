var months = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
  ];

function RdGraph(o){
  this.element = o.element;
  this.control = $('#' + o.element.id + '_control').get()[0];
  this.navigation_elem = $('#' + o.element.id + '_navigate').get()[0];
  this.get_params_from_element();
  this.range = 1;
  this.navigation = -1;
  this.create_navigation();
  this.update_display();
  this.create_control();
}

RdGraph.prototype.get_params_from_element = function(){
  this.call = $(this.element).attr('data-call');
  this.staff = $(this.element).attr('data-staff');
}

RdGraph.prototype.update_display = function(){
  var parent_class = this;
  this.fetch_data(function(data){
    var raw_data = JSON.parse(data);
    parent_class.dates = raw_data.dates;
    parent_class.min_date = raw_data.start_date;
    parent_class.max_date = raw_data.end_date;
    parent_class.parse_data();
    parent_class.create_display();
  });
};

RdGraph.prototype.create_control = function(){
  var parent_class = this;
  var span_range_1m = document.createElement("span");
  span_range_1m.className = "range_1m btn";
  $(span_range_1m).click(function(){
    parent_class.range = 1;
    parent_class.navigation = -1;
    parent_class.create_navigation();
    parent_class.update_display();
  });
  var span_range_3m = document.createElement("span");
  span_range_3m.className = "range_3m btn";
  $(span_range_3m).click(function(){
    parent_class.range = 3;
    parent_class.navigation = -1;
    parent_class.create_navigation();
    parent_class.update_display();
  });
  var span_range_6m = document.createElement("span");
  span_range_6m.className = "range_6m btn";
  $(span_range_6m).click(function(){
    parent_class.range = 6;
    parent_class.navigation = -1;
    parent_class.create_navigation();
    parent_class.update_display();
  });
  var span_range_1y = document.createElement("span");
  span_range_1y.className = "range_1y btn";
  $(span_range_1y).click(function(){
    parent_class.range = 12;
    parent_class.navigation = -1;
    parent_class.create_navigation();
    parent_class.update_display();
  });
  span_range_1m.appendChild(document.createTextNode("1m"));
  span_range_3m.appendChild(document.createTextNode("3m"));
  span_range_6m.appendChild(document.createTextNode("6m"));
  span_range_1y.appendChild(document.createTextNode("1y"))
  this.control.appendChild(span_range_1m);
  this.control.appendChild(span_range_3m);
  this.control.appendChild(span_range_6m);
  this.control.appendChild(span_range_1y);
}

RdGraph.prototype.create_navigation = function(){
  var parent_class = this;
  $(this.navigation_elem).html("");
  var span_navigate_back = document.createElement("span");
  span_navigate_back.className = "navigate_back btn";
  $(span_navigate_back).click(function(){
    parent_class.navigation = parent_class.navigation - 1;
    parent_class.create_navigation();
    parent_class.update_display();
  });
  span_navigate_back.appendChild(document.createTextNode("< Back"));
  this.navigation_elem.appendChild(span_navigate_back);
  if(parent_class.navigation != -1){
    var span_navigate_forward = document.createElement("span");
    span_navigate_forward.className = "navigate_forward btn";
    $(span_navigate_forward).click(function(){
      parent_class.navigation = parent_class.navigation + 1;
      parent_class.create_navigation();
      parent_class.update_display();
    });
    span_navigate_forward.appendChild(document.createTextNode("Forward >"));
    this.navigation_elem.appendChild(span_navigate_forward);
  }
  if(parent_class.navigation < -2){
    var span_navigate_last = document.createElement("span");
    span_navigate_last.className = "navigate_last btn";
    $(span_navigate_last).click(function(){
      parent_class.navigation = -1;
      parent_class.create_navigation();
      parent_class.update_display();
    });
    span_navigate_last.appendChild(document.createTextNode("last"))
    this.navigation_elem.appendChild(span_navigate_last);
  }
}

RdGraph.prototype.fetch_data = function(callback){
  $.ajax({
    url: '/index.php?controller=Graph&ajax=true&action=' + this.call + '&id=' + this.staff + '&range=' + this.range  + '&navigation=' + this.navigation,
    data: this.params,
    success: function(data){
      callback(data);
    },
    error: function(){
    
    }
  });
};

RdGraph.prototype.date_format = function(date){
  var retval = date.getFullYear();
  retval += "-";
  retval += (date.getMonth() + 1) < 10 ? "0" : "";
  retval += date.getMonth() + 1;
  retval += "-";
  retval += (date.getDate()) < 10 ? "0" : "";
  retval += date.getDate();
  return retval;
}

RdGraph.prototype.parse_data = function(){
  dates_sequential = [];
  var cumulative_dates = [];
  var max_value = 0;
  for(date in this.dates){
    var this_date = new Date(this.dates[date].date);
    // convert for timezone offset
    this_date = new Date(this_date.getTime() + this_date.getTimezoneOffset() * 60000);
    var hours;
    var discount;
    if(cumulative_dates[this.dates[date].date] != undefined){
      hours = (this.dates[date].hours * 1) + cumulative_dates[this.dates[date].date].hours;
      discount = (this.dates[date].discount * 1) + cumulative_dates[this.dates[date].date].discount;
    } else {
      hours = this.dates[date].hours * 1;
      discount = this.dates[date].discount * 1;
    }
    if(max_value < Math.max(hours, discount))
      max_value = Math.max(hours, discount);
      cumulative_dates[this.dates[date].date] = {'hours': hours, 'discount': discount};
  }
  var addend;
  switch(this.range){
    case 1:
      addend = 1;
      break;
    case 3:
    case 6:
      addend = 7;
      break;
    case 12:
      addend = 30;
      break;
  }
  var cur_date = new Date(this.min_date);
  cur_date =  new Date(cur_date.getTime() + cur_date.getTimezoneOffset() * 60000);
  var max_date = new Date(this.max_date);
  max_date = new Date(max_date.getTime() + max_date.getTimezoneOffset() * 60000);
  while(cur_date <= max_date){
    var date;
    if(this.range == 12){
      date = months[cur_date.getMonth()] + " " + cur_date.getFullYear();
    } else {
      date = this.date_format(cur_date);
    }
    var hours;
    var discount;
    if(cumulative_dates[this.date_format(cur_date)] == undefined){
      hours = 0;
      discount = 0;
    } else {
      hours = cumulative_dates[this.date_format(cur_date)].hours;
      discount = cumulative_dates[this.date_format(cur_date)].discount;
    }
    var weekend;
    if((cur_date.getDay() == 6 || cur_date.getDay() == 0) && this.range == 1){
      weekend = max_value;
    } else {
      weekend = 0;
    }
    dates_sequential[dates_sequential.length] = {'date' : date, 'hours' : hours, 'discount' : discount, 'weekend' : weekend};
    if(this.range == 12){
      cur_date = cur_date.add(1).months();
    } else {
      cur_date = cur_date.add(addend).days();
    }
  }
}

RdGraph.prototype.create_array_from_index = function(index){
  var dates_array = [];
  for(x in dates_sequential){
    dates_array[dates_array.length] = dates_sequential[x][index];
  }
  return dates_array;
}

RdGraph.prototype.create_display = function(){
  var parent_class = this;
  var chart;
  $(document).ready(function() {
    var series_data = [{
        name: 'Billable',
        data: parent_class.create_array_from_index('hours')
      },
      {
        name: 'Unbillable',
        data: parent_class.create_array_from_index('discount')
      }];
    if(parent_class.range == 1){
      series_data.push({
        type: 'column',
        name: 'Weekends',
        data: parent_class.create_array_from_index('weekend')
      });
    }
    var options = {
      chart: {
        renderTo: parent_class.element.id,
        defaultSeriesType: 'area'
      },
      credits: {
        enabled: false
      },
      title: {
        //text: 'Hours logged vs. time'
        text: null
      },
      xAxis: {
        labels: {
          rotation: -45,
          align: 'right'
        },
        categories: parent_class.create_array_from_index('date'),
        tickmarkPlacement: 'on',
          title: {
            enabled: false
          }
        },
      yAxis: {
        title: {
          text: 'Hours'
        },
        labels: {
          formatter: function(){
            return this.value;
          }
        }
      },
      tooltip: {
        formatter: function(){
          return this.x + ': '+ this.y + ' hours';
        }
      },
      plotOptions: {
        area: {
          stacking: 'normal',
          lineColor: '#666666',
          lineWidth: 1,
          marker: {
            lineWidth: 1,
            lineColor: '#666666'
          }
        }
      },
      series: series_data
    }
    chart = new Highcharts.Chart(options);
  });
};

// <div class="rd-graph" data-type="hours" data-staff="13" data-start="01-01-2011" data-end="01-02-2011"></div>
