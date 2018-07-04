<?php
namespace Students\Controller;

use Students\Model\StudentsTable;
use Students\Model\Students;
use Students\Model\ClassesTable;
use Students\Model\Classes;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JSONModel;

class StudentsController extends AbstractActionController
{
  private $table;
  private $table1;

  public function __construct(StudentsTable $table, ClassesTable $table1)
  {
      $this->table = $table;
      $this->table1 = $table1;
  }

  public function indexAction()
  {
    //$cid = $this->params()->fromRoute('cid');
    $cid = $_POST["cid"];
    $studentdetails= $this->table->fetchAll($cid);
    $request = $this->getRequest();
    if($request->isXmlHttpRequest())
    {
      $jsondata = [];
      $count=0;
      foreach ($studentdetails as $row) {
        $jsondata[$count]= array(
          'id' => $row->id,
          'sname' => $row->sname,
          'age' => $row->age,
          'class' => $row->class
        );
        $count++;
      }
      $finaldata = array(
        'jsondata' => $jsondata,
        'cid' => $cid
      );
      $senddata = new JsonModel($finaldata);
      $senddata->setTerminal(true);
      return $senddata;
      /*return [
        'studs' => $this->table->fetchAll($cid),
        'cid' => $cid
      ];*/
    }
    else
    {
      echo "welcome";
    }
  }

  public function addAction()
  {
    $cid = $this->params()->fromRoute('cid');
    $request = $this->getRequest();
    if (!$request->isXmlHttpRequest())
    {
      return ['cid' => $cid];
    }
    else {
      $id = 0;
      //$sname = $this->params()->fromRoute('cname');
      //$age = $this->params()->fromRoute('value');
      //$class = $this->params()->fromRoute('cid');
      $sname = $_POST["sname"];
      $age = $_POST["age"];
      $class = $_POST["cvar"];
      $data = [
        'id' => $id,
        'sname' => $sname,
        'age' => $age,
        'class' => $class
      ];
      $stud = new Students();
      $stud->exchangeArray($data);
      echo $stud->sname."<br/>";
      $this->table->saveStudents($stud);
      //$this->redirect()->toRoute('students');
    }
  }

  public function deleteAction()
  {
    //$cid = (int) $this->params()->fromRoute('cid', 0);
    $id = $_POST["id"];
    $this->table->deleteStudents($id);
    //return $this->redirect()->toRoute('students');
  }

  public function editAction()
  {
    $request = $this->getRequest();
    if($request->isXmlHttpRequest())
    {
      $id = $_POST["sid"];//$this->params()->fromRoute('cid');
      $sname = $_POST["sname"];//$this->params()->fromRoute('cname');
      $age = $_POST["age"];//$this->params()->fromRoute('value');
      $class = $_POST["cname"];//$this->params()->fromRoute('value1');
      $data = [
        'id' => $id,
        'sname' => $sname,
        'age' => $age,
        'class' => $class
      ];
      $stud= new Students();
      $stud->exchangeArray($data);
      $this->table->saveStudents($stud);
      //$this->redirect()->toRoute('students');
    }
  }

  public function cindexAction()
  {
    $classdata = $this->table1->fetchAll();
    $jsondata = [];
    $count=0;
    foreach ($classdata as $data)
    {
      $jsondata[$count] = array(
        'cid' => $data->cid,
        'cname' => $data->cname
      );
      $count++;
    }
    $senddata = new JsonModel($jsondata);
    $senddata->setTerminal(true);
    return $senddata;
  }

  public function caddAction()
  {
    $request = $this->getRequest();
    if ($request->isXmlHttpRequest())
    {
      $cid = 0;
      //$cname =$this->params()->fromRoute('cid');
      $cname = $_POST["cname"];
      $data = [
        'cid' => $cid,
        'cname' => $cname
      ];
      $clas = new Classes();
      $clas->exchangeArray($data);
      echo $clas->cname."<br/>";
      $this->table1->saveClasses($clas);
    }
  }

  public function ceditAction()
  {
    $request = $this->getRequest();
    if($request->isXmlHttpRequest()) {
      //$cid = $this->params()->fromRoute('cid');
      //$cname = $this->params()->fromRoute('cname');
      $cid = $_POST["cid"];
      $cname = $_POST["cname"];
      $data = [
        'cid' => $cid,
        'cname' => $cname,
      ];
      $clas = new Classes();
      $clas->exchangeArray($data);
      $this->table1->saveClasses($clas);
    }
    else
    {
      $cid1 = $this->params()->fromRoute('cid');
      $data=$this->table1->getClasses($cid1);
      return ['data' => $data];
    }
  }
  public function cdeleteAction()
  {
    //$cid = $this->params()->fromRoute('cid',0);
    $cid = $_POST["cid"];
    echo $cid;
    $this->table1->deleteClasses($cid);
    $this->redirect()->toRoute('students');
  }

  public function mainAction()
  {
  }
 }
