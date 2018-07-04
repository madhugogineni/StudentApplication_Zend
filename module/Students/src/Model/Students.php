<?php

namespace Students\Model;

class Students {

  public $id;
  public $sname;
  public $age;
  public $class;

  public function exchangeArray($data) {

    $this->id = !empty($data['id']) ? $data['id'] : null;
    $this->sname = !empty($data['sname']) ? $data['sname'] : null;
    $this->age = !empty($data['age']) ? $data['age'] : null;
    $this->class = !empty($data['class']) ? $data['class'] : null;
  }

}
