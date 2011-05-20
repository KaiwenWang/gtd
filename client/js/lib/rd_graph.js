var dates;
var dates_sequential = []

function RdGraph(o){
  this.element = o.element;
  this.get_params_from_element();
  this.update_display();
}

RdGraph.prototype.get_params_from_element = function(){
  this.call = $(this.element).attr('data-call');
  this.staff = $(this.element).attr('data-staff');
}

RdGraph.prototype.update_display = function(){
  var parent_class = this;
  this.fetch_data(function(data){
    parent_class.dates = JSON.parse(data);
    parent_class.parse_data();
    parent_class.create_display();
  });
};

RdGraph.prototype.fetch_data = function(callback){
  $.ajax({
    url: '/index.php?controller=Graph&ajax=true&action=' + this.call + '&id=' + this.staff,
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
  var cumulative_dates = []
  var min_date = new Date('2050');
  var max_value = 0;
  for(date in this.dates){
    var this_date = new Date(this.dates[date].date);
    // convert for timezone offset
    this_date = new Date(this_date.getTime() + this_date.getTimezoneOffset() * 60000);
    if(this_date < min_date)
      min_date = this_date;
    var hours;
    var discount;
    if(cumulative_dates[this.dates[date].date] != undefined){
      hours = (this.dates[date].hours * 1) + cumulative_dates[this.dates[date].date].hours;
      discount = (this.dates[date].discount * 1) + cumulative_dates[this.dates[date].date].discount;
    } else {
      hours = this.dates[date].hours * 1;
      discount = this.dates[date].discount * 1;
    }
    if(max_value < hours)
      max_value = hours;
    cumulative_dates[this.dates[date].date] = {'hours': hours, 'discount': discount};
  }
  for(var cur_date = min_date; cur_date <= new Date(); cur_date = new Date(cur_date.getTime() + 86400000)){
    var date = this.date_format(cur_date);
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
    if(cur_date.getDay() == 6 || cur_date.getDay() == 0){
      weekend = max_value;
    } else {
      weekend = 0;
    }
    dates_sequential[dates_sequential.length] = {'date' : date, 'hours' : hours, 'discount' : discount, 'weekend' : weekend};
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
     chart = new Highcharts.Chart({
        chart: {
           renderTo: parent_class.element.id,
           defaultSeriesType: 'area'
        },
        title: {
           text: 'Hours logged over the last week'
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
        series: [{
          name: 'Billable',
          data: parent_class.create_array_from_index('hours')
        },
        {
          name: 'Unbillable',
          data: parent_class.create_array_from_index('discount')
        },
        {
          type: 'column',
          name: 'Weekends',
          data: parent_class.create_array_from_index('weekend')
        }]
     });
  });

};

// <div class="rd-graph" data-type="hours" data-staff="13" data-start="01-01-2011" data-end="01-02-2011"></div>
