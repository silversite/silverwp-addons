<?php

namespace SilverZF2\Db\Mapper;

use SilverZF2\Db\Entity\EntityPrototype;
use SilverZF2\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\ClassMethods;

abstract class AbstractDbMapper
{
    /**
     * @var Adapter
     */
    protected $dbAdapter;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @var object
     */
    protected $entityPrototype;

    /**
     * @var HydratingResultSet
     */
    protected $resultSetPrototype;

    /**
     * @var Select
     */
    protected $selectPrototype;

    /**
     * @var Sql
     */
    private $sql;

    /**
     * @var string
     */
    protected $tableName;

	/**
     * @var boolean
     */
    private $isInitialized = false;

	/**
	 * AbstractDbMapper constructor.
	 *
	 * @param Adapter         $dbAdapter
	 * @param EntityPrototype $entityPrototype
	 */
	public function __construct(Adapter $dbAdapter, EntityPrototype $entityPrototype) {
		$this->setDbAdapter($dbAdapter);
		$this->setEntityPrototype($entityPrototype);
	}

	/**
     * Performs some basic initialization setup and checks before running a query
     *
     * @return null
     * @throws \Exception
     */
    protected function initialize()
    {
        if ($this->isInitialized) {
            return;
        }

        if ( ! $this->dbAdapter instanceof Adapter) {
            throw new \Exception('No db adapter present');
        }

        if ( ! $this->hydrator instanceof HydratorInterface) {
            $this->hydrator = new ClassMethods;
        }

        if ( ! is_object($this->entityPrototype)) {
            throw new \Exception('No entity prototype set');
        }

        $this->isInitialized = true;
    }

	/**
	 * @param string|null $table
	 *
	 * @return Select
	 */
    protected function getSelect($table = null)
    {
        $this->initialize();

        return $this->getSql()->select($table ? : $this->getTableName());
    }

    /**
     * @param Select                 $select
     * @param object|null            $entityPrototype
     * @param HydratorInterface|null $hydrator
     *
     * @return HydratingResultSet
     */
    protected function select(
        Select $select, $entityPrototype = null, HydratorInterface $hydrator = null
    ) {
        $this->initialize();

        $stmt = $this->getSql()->prepareStatementForSqlObject($select);

        $resultSet = new HydratingResultSet(
            $hydrator ? : $this->getHydrator(),
            $entityPrototype ? : $this->getEntityPrototype()
        );

        $resultSet->initialize($stmt->execute());

        return $resultSet;
    }

    /**
     * @param object|array                $entity
     * @param string|TableIdentifier|null $tableName
     * @param HydratorInterface|null      $hydrator
     *
     * @return ResultInterface
     */
    protected function insert(
        $entity, $tableName = null, HydratorInterface $hydrator = null
    ) {
        $this->initialize();
        $tableName = $tableName ? : $this->getTableName();

        $sql    = $this->getSql()->setTable($tableName);
        $insert = $sql->insert();

        $rowData = $this->entityToArray($entity, $hydrator);
        $insert->values($rowData);

        $statement = $sql->prepareStatementForSqlObject($insert);

        return $statement->execute();
    }

    /**
     * @param object|array                $entity
     * @param string|array|closure        $where
     * @param string|TableIdentifier|null $tableName
     * @param HydratorInterface|null      $hydrator
     *
     * @return ResultInterface
     */
    protected function update(
        $entity, $where, $tableName = null, HydratorInterface $hydrator = null
    ) {
        $this->initialize();
        $tableName = $tableName ? : $this->getTableName();

        $sql    = $this->getSql()->setTable($tableName);
        $update = $sql->update();

        $rowData = $this->entityToArray($entity, $hydrator);
        $update->set($rowData)
            ->where($where);

        $statement = $sql->prepareStatementForSqlObject($update);

        return $statement->execute();
    }

    /**
     * @param string|array|closure        $where
     * @param string|TableIdentifier|null $tableName
     *
     * @return ResultInterface
     */
    protected function delete($where, $tableName = null)
    {
        $tableName = $tableName ? : $this->getTableName();

        $sql    = $this->getSql()->setTable($tableName);
        $delete = $sql->delete();

        $delete->where($where);

        $statement = $sql->prepareStatementForSqlObject($delete);

        return $statement->execute();
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return $this->getDbAdapter()->getTablePrefix() . $this->tableName;
    }

    /**
     * @return object
     */
    public function getEntityPrototype()
    {
        return $this->entityPrototype;
    }

	/**
	 * @param EntityPrototype $entityPrototype
	 *
	 * @return AbstractDbMapper
	 */
    public function setEntityPrototype(EntityPrototype $entityPrototype)
    {
        $this->entityPrototype    = $entityPrototype;
        $this->resultSetPrototype = null;

        return $this;
    }

    /**
     * @return Adapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    /**
     * @param Adapter $dbAdapter
     *
     * @return AbstractDbMapper
     */
    public function setDbAdapter(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;

        return $this;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator()
    {
        if ( ! $this->hydrator) {
            $this->hydrator = new ClassMethods(false);
        }

        return $this->hydrator;
    }

    /**
     * @param HydratorInterface $hydrator
     *
     * @return AbstractDbMapper
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator           = $hydrator;
        $this->resultSetPrototype = null;

        return $this;
    }

    /**
     * @return Sql
     */
    protected function getSql()
    {
        if ( ! $this->sql instanceof Sql) {
            $this->sql = new Sql($this->getDbAdapter());
        }

        return $this->sql;
    }

    /**
     * @param Sql $sql
     *
     * @return AbstractDbMapper
     * @internal param $Sql
     *
     */
    protected function setSql(Sql $sql)
    {
        $this->sql = $sql;

        return $this;
    }

    /**
     * Uses the hydrator to convert the entity to an array.
     *
     * Use this method to ensure that you're working with an array.
     *
     * @param object            $entity
     *
     * @param HydratorInterface $hydrator
     *
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    protected function entityToArray(
        $entity, HydratorInterface $hydrator = null
    ) {
        if (is_array($entity)) {
            return $entity; // cut down on duplicate code
        } elseif (is_object($entity)) {
            if ( ! $hydrator) {
                $hydrator = $this->getHydrator();
            }

            return $hydrator->extract($entity);
        }
        throw new Exception\InvalidArgumentException(
            'Entity passed to db mapper should be an array or object.'
        );
    }
}
