<?php


class FirebasePushModel extends CI_Model {
    private $title;
    private $message;
    private $image;
    private $is_background;
    private $payload;
    private $androidSettings;
    private $offer_id;

  
    public function __get($property) {
      if (property_exists($this, $property)) {
        return $this->$property;
      }
    }
  
    public function __set($property, $value) {
      if (property_exists($this, $property)) {
        $this->$property = $value;
      }
  
      return $this;
    }

    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['is_background'] = $this->is_background;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['payload'] = $this->payload;
        $res['data']['timestamp'] = date('d-m-Y h:i A');
        $res['data']['android'] = $this->androidSettings;
        $res['data']['offer_id'] = $this->offer_id;

        return $res;
    }

  }