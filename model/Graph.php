<?php
class Graph{
	var $base_url = 'http://chart.apis.google.com/chart?';
	var $uri_array = array();
	var $url;
	
// PASSED IN AS ARGUMENTS
	var $title;
	var $graph_type;
	var $size;
	var $data_set = array();
	var $data_points;
	var $axis_scale;
	var $axis_points;
	var $x_axis_labels = array();
	var $y_axis_labels = array();
	var $margin;
	var $legend_width;
	var $colors;

	function __construct($o){
		foreach($o as $property => $value){
			$this->$property = $value;
		}
		if (!$this->legend_width){
			$this->legend_width = 0;
		}
		if (!$this->margin){
			$this->margin = '0,0,0,0';
		}
	}
	function execute(){
		$this->uri_array = array(
			'chxp'=>"0,".$this->axis_points,
			'chs'=>$this->size,
			'chdlp'=>'r',
			'chtt'=>$this->title
		);
		if ($this->graph_type == 'line'){
			$this->uri_array['cht']='lc';
		}
		if ($this->graph_type == 'bar'){
			$this->uri_array['cht']='bvg';
			$this->uri_array['chbh'] = 'a';
			$this->createBarLabelsURI();
		}
		$this->uri_array['chma'] =$this->margin.'|'.$this->legend_width.',0';
		$this->createDataURI();	
		$this->createAxisLabelURI();
		$this->url = $this->base_url;
		foreach($this->uri_array as $key=>$value){
			$this->url .= '&'.$key.'='.$value;
		}
		return $this->url;
	}
	function createAxisLabelURI(){
		$chxt = 'y';
		$chxl = '';
		$x = count($this->x_axis_labels);
		$y = count($this->y_axis_labels);
		$label_number = 1;
		for ($i=0;$i<$y;$i++){
			$chxt .= ',y';
			$chxl .= $label_number.':'.$this->y_axis_labels[$i];
			$label_number++;
		}
		for ($i=0;$i<$x;$i++){
			$chxt .= ',x';
			$chxl .= $label_number.':'.$this->x_axis_labels[$i];
			$label_number++;
		}
		$data_points = array();
		foreach($this->data_set as $data){
			$data_points = array_merge($data_points,$data['data_points']);
		}
		asort($data_points);
		$largest_value = array_pop($data_points);
		$scale = $largest_value + intval(($largest_value/9));
		$interval = intval($scale/$this->number_of_intervals);
		$interval = $interval - ($interval % $this->round_intervals_to);
		$this->uri_array['chds'] ="0,".$scale;
		$this->uri_array['chxr'] ="0,0,$scale,$interval";
		$this->uri_array['chxt'] = $chxt;
		$this->uri_array['chxl'] = $chxl;
	}
	function createDataURI(){
		$is_first_set = true;
		foreach($this->data_set as $data){
			if ($is_first_set == true){
				$data_points = 't:'.$this->createDataString($data['data_points']);
				$data_labels = $data['label'];
				$data_colors = $data['color'];
				$is_first_set = false;
			}else{
				$data_points .= '|'.$this->createDataString($data['data_points']);
				$data_labels .= '|'.$data['label'];
				$data_colors .= ','.$data['color'];
			}
		}
		$this->uri_array['chd'] = $data_points;
		$this->uri_array['chdl'] = $data_labels;
		$this->uri_array['chco'] = $data_colors;
	}
	function createDataString($data_array){
		$data_string = '';
		foreach($data_array as $data){
			$data_string .= $data.',';
		}
		$data_string = rtrim($data_string,',');
		return $data_string;
	} 
	function createBarLabelsURI(){
		$chm = '';
		$i = 0;
		foreach($this->data_set as $data){
			$chm .= 'N,'.$data['color'].','.$i.',-1,14|';
			$i++;
		}
		$chm = rtrim($chm ,'|');
		$this->uri_array['chm'] = $chm;
	}
}
?>
