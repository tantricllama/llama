<?php
namespace Llama\Database\Adapter;

/**
 * Adapter Interface class for use in Llama\Database\Adapter.
 *
 * @category   Llama
 * @package    Database
 * @subpackage Adapter
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 */
interface AdapterInterface
{

    /**
     * Open a connection to the data storage.
     *
     * @access public
     * @return void
     */
    public function connect();

    /**
     * Close the data storage connection.
     *
     * @access public
     * @return void
     */
    public function disconnect();

    /**
     * Prepare an statement for execution.
     *
     * @param string[optional] $sql     Query string.
     * @param array[optional]  $options A key => value array of driver specific
     *                                  connection options.
     *
     * @access public
     * @return mixed
     */
    public function prepare($sql, array $options = array());

    /**
     * Execute an statement.
     *
     * @param array[optional] $parameters An array of values to be bound to
     *                                    parameters in the query.
     *
     * @access public
     * @return mixed
     */
    public function execute(array $parameters = array());

    /**
     * Fetch a record from the executed statement.
     *
     * @param int[optional] $fetchStyle        Controls how the record will be
     *                                         returned to the caller.
     * @param int[optional] $cursorOrientation Specifies which record will be
     *                                         returned to the caller.
     * @param int[optional] $cursorOffset      Specifies the absolute record in
     *                                         the result set to be returned to
     *                                         the caller.
     *
     * @access public
     * @return mixed
     */
    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null);

    /**
     * Fetch the entire record set from the executed statement.
     *
     * @param int[optional] $fetchStyle Controls how the record set will  be
     *                                  returned to the caller.
     * @param int[optional] $column     Specifies which column will be returned
     *                                  in the record set.
     *
     * @access public
     * @return array
     */
    public function fetchAll($fetchStyle = null, $column = 0);

    /**
     * Execute an select statement.
     *
     * @param string           $table        The name of the table to select from.
     * @param array[optional]  $bind         An array of values to be bound to
     *                                       parameters in the query.
     * @param string[optional] $orderBy      The order by clause.
     * @param mixed[optional]  $limit        The limit clause. This can be an
     *                                       integer, representing an upper limit;
     *                                       an array representing the offset and
     *                                       upper limit.
     * @param string[optional] $boolOperator The where clause operator.
     *
     * @access public
     * @return mixed
     */
    public function select($table, array $bind = array(), $orderBy = null, $limit = null, $boolOperator = 'AND');

    /**
     * Execute an insert statement and return the auto increment value.
     *
     * @param string $table The name of the table to insert into.
     * @param array  $bind  An array of values to be bound to  parameters in the
     *                      query.
     *
     * @access public
     * @return int
     */
    public function insert($table, array $bind);

    /**
     * Execute an update statement and return the number of records affected.
     *
     * @param string           $table The name of the table to update.
     * @param array            $bind  An array of values to be bound to
     *                                parameters in the query.
     * @param string[optional] $where The where conditions for the update query.
     *
     * @access public
     * @return int
     */
    public function update($table, array $bind, $where = '');

    /**
     * Execute an delete statement and return the number of records affected.
     *
     * @param string           $table The name of the table to delete from.
     * @param string[optional] $where The where conditions for the delete query.
     *
     * @access public
     * @return int
     */
    public function delete($table, $where = '');
}

