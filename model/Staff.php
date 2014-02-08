<?php
class Staff extends User {

  var $datatable = "staff";
  var $name_field = "first_name";

  protected static $schema;
  protected static $schema_json = '{
    "fields": {
        "first_name": "text",
        "last_name": "text",
        "email": "text",
        "team": "text",
        "username": "text",
        "password": "text",
        "permalink": "text",
        "active": "bool",
        "avatar": "text"
    },
    "required": [],
    "values": {
        "team": {
            "administration": "Administration",
            "development": "Development",
            "production": "Production"
        },
        "avatar": {
            "": "Select an avatar",
            "mario": "Mario",
            "luigi": "Luigi",
            "peach": "Peach",
            "toad": "Toad",
            "yoshi": "Yoshi",
            "dk": "D.K.",
            "wario": "Wario",
            "bowser": "Bowser"
        }
    }
  }';

  function __construct($id = null) {
    parent::__construct($id);
  }

  function getName() {
    $name = $this->getData('first_name');
    if($this->getData('last_name')) $name .= ' '.$this->getData('last_name');
    return $name;
  }

  function getUserType() {
    return 'staff';
  }

  function getProjects() {
    if(empty($this->projects)) {
      $this->projects = getMany('Project', array("staff_id" => $this->id));
    }
    return $this->projects;
  }

  function getBookmarks() {
    if(empty($this->bookmarks)) {
      $this->bookmarks = getMany('Bookmark', array("staff_id" => $this->id));
    }
    return $this->bookmarks;
  }

  function getHours($criteria = array()) {
    $criteria = array_merge($criteria, array('staff_id' => $this->id, 'sort' => 'date desc'));
    $this->hours = getMany('Hour', $criteria);
    return $this->hours;
  }

  function getHoursTotal($criteria = array(), $options = array()) {
    $hours = $this->getHours($criteria);

    if(!empty($options['billable_only'])) {
      $get_hour_function = 'getBillableHours';
    } else {
      $get_hour_function = 'getHours';
    }

    $total = 0;
    foreach($hours as $h) {
      $total += $h->$get_hour_function();
    }
    return $total;
  }

  function getBillableHoursTotal($criteria = array(), $options = array()) {
    return $this->getHoursTotal($criteria, array_merge($options,array('billable_only' => true)));
  }

  function getPermalink() {
    return $this->get('permalink'); 
  }

  function getActive() {
    return $this->get('active');
  }

}

?>
