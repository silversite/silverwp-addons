<?php

namespace SilverZF2\Db\Mapper;

use SilverWp\Debug;
use SilverZF2\Db\Adapter\Adapter;
use SilverZF2\Db\Entity\EntityPrototypeAwareTrait;
use SilverZF2\Db\Entity\EntityPrototypeInterface;
use SilverZF2\Db\Exception\Mapper\InvalidArgumentException;
use SilverZF2\Db\Table\TableAwareTrait;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Hydrator\HydratorAwareTrait;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\ClassMethods;

/**
 *
 * Abstract mapper base class
 *
 * @category    Zend Framework 2
 * @package     SilverZF2\Db
 * @subpackage  Mapper
 * @author      Michal Kalkowski <michal.kalkowski at autentika.pl>
 * @copyright   SilverSite.pl (c) 2015
 * @version     1.0
 * @abstract
 */
abstract class AbstractDbMapper
{
	use HydratorAwareTrait;
	use TableAwareTrait;
	use EntityPrototypeAwareTrait;

    /**
     * @var Select
     */
    protected $selectPrototype;

    /**
     * @var Sql
     */
    private $sql;

    /**
     * @var boolean
     */
    private $isInitialized = false;

	protected $virtualKeys;
	/**
	 * AbstractDbMapper constructor.
	 *
	 * @param Adapter|null                  $dbAdapter
	 * @param EntityPrototypeInterface|null $entityPrototype
	 */
	public function __construct(Adapter $dbAdapter = null, EntityPrototypeInterface $entityPrototype = null) {
		if ( ! is_null($dbAdapter)) {
			$this->setDbAdapter($dbAdapter);
		}

		if ( ! is_null($entityPrototype)) {
			$this->setEntityPrototype( $entityPrototype );
		}
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

        if ( ! $this->adapter instanceof Adapter) {
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
     * @return HydratorInterface
     */
    public function getHydrator()
    {
        if ( ! $this->hydrator || is_null($this->hydrator)) {
            $this->hydrator = new ClassMethods(false);
        }

        return $this->hydrator;
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
	 * @param $id
	 *
	 * @return object
	 */
	public function find($id)
	{
		$select = $this->getSelect();
		$select->where(array('id = ?' => $id));

		$stmt   = $this->getSql()->prepareStatementForSqlObject($select);
		$result = $stmt->execute();

		if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
			return $this->getHydrator()->hydrate($result->current(), $this->getEntityPrototype());
		}

		throw new \InvalidArgumentException("Record with given ID:{$id} not found.");
	}

	/**
	 *
	 * @return ResultSet
	 */
	public function findAll()
	{
		$select = $this->getSelect();
		$stmt   = $this->getSql()->prepareStatementForSqlObject($select);
		$result = $stmt->execute();

		if ($result instanceof ResultInterface && $result->isQueryResult()) {
			$resultSet = new HydratingResultSet($this->getHydrator(), $this->getEntityPrototype());

			return $resultSet->initialize($result);
		}

		return [];
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
     * @throws InvalidArgumentException
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
        throw new InvalidArgumentException(
            'Entity passed to db mapper should be an array or object.'
        );
    }

	/**
	 * Display current sql query string
	 *
	 * @param Select $select
	 *
	 * @return string
	 * @access protected
	 */
	protected function getSqlQuery(Select $select)
	{
		return $select->getSqlString($this->getDbAdapter()->getPlatform());
	}

	/**
	 * Convert object to string
	 *
	 * @access public
	 * @magic
	 */
	public function __toString() {
		Debug::dump($this->getSqlQuery($this->getSelect()));
	}
}
