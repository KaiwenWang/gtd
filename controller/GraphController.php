<?php
class GraphController extends PageController {
		function overview( $params){
			$ret_array = Array();
      if(isset($params['range']) && $params['range'] != "")
        $range = $params['range'];
			else
				$range = 1;
			if(isset($params['navigation']) && $params['navigation'] != "")
				$navigation = $params['navigation'];
			else
				$navigation = -1;
      $start_date = date("Y-m-d", strtotime(($range * $navigation)." month"));
      if(isset($params['end_date']) && $params['end_date'] != "")
        $end_date = $params['end_date'];
      else
				$end_date = date("Y-m-d", strtotime($start_date." +".$range." months"));
      $hours = Hour::getMany(Array('staff_id' => $params['id'], 'hour_search' => Array('start_date' => $start_date, 'end_date' => $end_date)));
      $hours_array = Array();
			foreach($hours as $hour){
				switch($range){
					case 3:
					case 6:
						$hour->itemdata['date'] = date("Y-m-d", strtotime("-1 sunday", strtotime($hour->itemdata['date'])));
						break;
					case 12:
						$hour->itemdata['date'] = date("Y-m-15", strtotime($hour->itemdata['date']));
						break;
				}
        array_push($hours_array, Array('date' => $hour->itemdata['date'], 'hours' => $hour->itemdata['hours'] - $hour->itemdata['discount'], 'discount' => $hour->itemdata['discount']));
			}
			switch($range){
				case 3:
				case 6:
					$start_date = date("Y-m-d", strtotime("-1 sunday", strtotime($start_date)));
					$end_date = date("Y-m-d", strtotime("-1 sunday", strtotime($end_date)));
					break;
				case 12:
					$start_date = date("Y-m-15", strtotime($start_date));
					$end_date = date("Y-m-15", strtotime($end_date));
					break;
			}
			$this->data->hours = $hours_array;
			$this->data->start_date = $start_date;
			$this->data->end_date = $end_date;
    }
}
