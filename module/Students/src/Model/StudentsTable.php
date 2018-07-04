<?php
namespace Students\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class StudentsTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
      $this->tableGateway = $tableGateway;
    }

    public function fetchAll($cid)
    {
      return $this->tableGateway->select(['class' => $cid]);
    }

    public function getStudents($id)
    {
      $id = (int) $id;
      $rowset = $this->tableGateway->select(['id' => $id]);
      $row = $rowset->current();
      if (! $row)
      {
        throw new RuntimeException(sprintf('Could not find row with identifier %d',$id));
      }
      return $row;
    }

    public function saveStudents(Students $studs)
    {
      $data = [
        'sname' => $studs->sname,
        'age'  => $studs->age,
        'class'  => $studs->class
      ];
      $id = (int) $studs->id;
      if ($id === 0)
      {
        $this->tableGateway->insert($data);
        return;
      }
      if (!$this->getStudents($id))
      {
        throw new RuntimeException(sprintf('Cannot update album with identifier %d; does not exist',$id));
      }
      $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteStudents($id)
    {
      $this->tableGateway->delete(['id' => (int) $id]);
    }
}
