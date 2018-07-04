<?php
namespace Students\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ClassesTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
      $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
      return $this->tableGateway->select();
    }

    public function getClasses($cid)
    {
      $cid = (int) $cid;
      $rowset = $this->tableGateway->select(['cid' => $cid]);
      $row = $rowset->current();
      if (! $row)
      {
        throw new RuntimeException(sprintf('Could not find row with identifier %d',$cid));
      }
      return $row;
    }

    public function saveClasses(Classes $clas)
    {
      $data = [
        'cname' => $clas->cname,
      ];
      $cid = (int) $clas->cid;
      if ($cid === 0)
      {
        $this->tableGateway->insert($data);
        return;
      }
      if (!$this->getClasses($cid))
      {
        throw new RuntimeException(sprintf('Cannot update album with identifier %d; does not exist',$cid));
      }
      $this->tableGateway->update($data, ['cid' => $cid]);
    }

    public function deleteClasses($cid)
    {
        $this->tableGateway->delete(['cid' => (int) $cid]);
    }
}
