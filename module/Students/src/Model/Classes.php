<?php

namespace Students\Model;

class Classes
{
  public $cid;
  public $cname;

  public function exchangeArray($data)
  {
    $this->cid = !empty($data['cid']) ? $data['cid'] : null;
    $this->cname = !empty($data['cname']) ? $data['cname'] : null;
  }
}
