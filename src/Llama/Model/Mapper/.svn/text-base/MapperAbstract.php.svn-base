<?php
namespace Llama\Model\Mapper;

use Llama\Model\CollectionAbstract;

use Llama\Database\Adapter\AdapterInterface;

/**
 * Abstract Mapper class for use in Llama\Model.
 *
 * @category   Llama
 * @package    Model
 * @subpackage Mapper
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 * @abstract
 *
 * @uses \Llama\Database\Adapter\AdapterInterface
 */
abstract class MapperAbstract
{

    /**
     * The data adapter.
     *
     * @access protected
     * @var    \Llama\Database\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * The name of the entities table.
     *
     * @access protected
     * @var    string
     */
    protected $entityTable;

    /**
     * The namespace of the entity's collection class.
     *
     * @access protected
     * @var    string
     */
    protected $collectionNamespace;

    /**
     * Constructor
     *
     * Setup the mapper.
     *
     * @param \Llama\Database\Adapter\AdapterInterface $adapter The data adapter.
     *
     * @access public
     */
    public function __construct(AdapterInterface $adapter = null)
    {
        $this->adapter = $adapter;
    }

    /**
     * Return the data adapter.
     *
     * @access public
     * @return \Llama\Database\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Find an entity using it's primary key.
     *
     * @param int $id The primary key of the entity.
     *
     * @access public
     * @return \Llama\Model\ModelAbstract
     */
    public function findById($id)
    {
        $this->adapter->select($this->entityTable, array('id' => $id));

        if (!$row = $this->adapter->fetch()) {
            $row = null;
        }

        return $this->createEntity($row);
    }

    /**
     * Find all entities where the primary key is present in the specified list.
     *
     * @param array[optional] $list A list of primary keys.
     *
     * @access public
     * @return \Llama\Model\CollectionAbstract
     */
    public function findIn(array $list = array())
    {
        if (empty($list)) {
            return new $this->collectionNamespace($this);
        }

        $sql = "SELECT * FROM `{$this->entityTable}` WHERE id IN ("
             . implode(',', array_fill(0, sizeof($list), '?'))
             . ')';

        return new $this->collectionNamespace($this, $this->adapter->prepare($sql)->execute($list)->getStatement());
    }

    /**
     * Find all entities using an array of conditions each entity must meet.
     *
     * @param array[optional]  $conditions An array of conditions entities must
     *                                     meet before they are returned.
     * @param string[optional] $orderBy    The field and direction by which to
     *                                     order the entities.
     * @param array[optional]  $limit      The maximum number of entities to return.
     *
     * @access public
     * @return \Llama\Model\CollectionAbstract
     */
    public function findAll(array $conditions = array(), $orderBy = 'id ASC', $limit = null)
    {
        return new $this->collectionNamespace(
            $this,
            $this->adapter->select(
                $this->entityTable,
                $conditions,
                $orderBy,
                $limit
            )->getStatement()
        );
    }

    /**
     * Instantiate and return an instance of the model using the record data.
     *
     * @param array[optional] $row The record data retrieved from the data source.
     *
     * @abstract
     * @access   protected
     * @return   \Llama\Model\ModelAbstract
     */
    abstract protected function createEntity(array $row = null);
}

