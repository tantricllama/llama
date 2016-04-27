<?php
namespace Llama\Database;

use Llama\Database\Adapter\AdapterInterface;
use \PDOException;
use \RuntimeException;

/**
 * Exception class for Llama\Database.
 *
 * @category Llama
 * @package  Database
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Database\Adapter\AdapterInterface
 * @uses \PDOException
 * @uses \RuntimeException
 */
class PDOAdapter implements AdapterInterface
{

    /**
     * The adapter configuration.
     *
     * @access protected
     * @var    array
     */
    protected $config = array();

    /**
     * The PDO instance.
     *
     * @access protected
     * @var    \PDO
     */
    protected $connection;

    /**
     * The PDOStatement instance.
     *
     * @access protected
     * @var    \PDOStatement
     */
    protected $statement;

    /**
     * The default fetch mode.
     *
     * @access protected
     * @var    int
     */
    protected $fetchMode = \PDO::FETCH_ASSOC;

    /**
     * Constructor
     *
     * Setup the PDOAdapter object.
     *
     * @param string           $dsn           The Data Source Name.
     * @param string[optional] $username      The username for the DSN string.
     * @param string[optional] $password      The password for the DSN string.
     * @param array            $driverOptions A key => value array of driver
     *                                        specific connection options.
     *
     * @access public
     */
    public function __construct($dsn, $username = null, $password = null, array $driverOptions = array())
    {
        $this->config = compact('dsn', 'username', 'password', 'driverOptions');
    }

    /**
     * Return the PDOStatement instance.
     *
     * @access public
     * @throws \PDOException
     * @return \PDOStatement
     */
    public function getStatement()
    {
        if ($this->statement === null) {
            throw new \PDOException('There is no PDOStatement object for use.');
        }

        return $this->statement;
    }

    /**
     * Open a connection to the database, if the connection has not already been
     * estanblished.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::connect()
     *
     * @access public
     * @throws \RuntimeException
     * @return void
     */
    public function connect()
    {

        //if there is a PDO object already, return early
        if ($this->connection) {
            return;
        }

        try {
            $this->connection = new \PDO(
                $this->config['dsn'],
                $this->config['username'],
                $this->config['password'],
                $this->config['driverOptions']
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * Close the database connection.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::disconnect()
     *
     * @access public
     * @return void
     */
    public function disconnect()
    {
        $this->connection = null;
    }

    /**
     * Prepare an SQL statement for execution.
     *
     * @param string[optional] $sql     SQL query string.
     * @param array[optional]  $options A key => value array of driver specific
     *                                  connection options.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::prepare()
     *
     * @access public
     * @throws \RuntimeException
     * @return \Llama\Database\PDOAdapter
     */
    public function prepare($sql, array $options = array())
    {
        $this->connect();

        try {
            $this->statement = $this->connection->prepare($sql, $options);

            return $this;
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * Execute an SQL statement.
     *
     * @param array[optional] $parameters An array of values to be bound to
     *                                    parameters in the query.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::execute()
     *
     * @access public
     * @throws \RuntimeException
     * @return \Llama\Database\PDOAdapter
     */
    public function execute(array $parameters = array())
    {
        try {
            $this->statement->execute($parameters);

            return $this;
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * Return the number of rows affected by an SQL query.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::getAffectedRows()
     *
     * @access public
     * @throws \RuntimeException
     * @return int
     */
    public function getAffectedRows()
    {
        try {
            return $this->statement->rowCount();
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * Return the last auto increment value.
     *
     * @param string $name Name of the sequence object from which the ID should
     *                     be returned.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::getLastInsertId()
     *
     * @access public
     * @throws \RuntimeException
     * @return int
     */
    public function getLastInsertId($name = null)
    {
        $this->connect();

        return $this->connection->lastInsertId($name);
    }

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
     * @see \Llama\Database\Adapter\AdapterInterface::fetch()
     *
     * @access public
     * @throws \RuntimeException
     * @return mixed
     */
    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null)
    {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }

        try {
            return $this->statement->fetch($fetchStyle, $cursorOrientation, $cursorOffset);
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * Fetch the entire record set from the executed statement.
     *
     * @param int[optional] $fetchStyle Controls how the record set will  be
     *                                  returned to the caller.
     * @param int[optional] $column     Specifies which column will be returned
     *                                  in the record set.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::fetchAll()
     *
     * @access public
     * @throws \RuntimeException
     * @return array
     */
    public function fetchAll($fetchStyle = null, $column = 0)
    {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }

        try {
            if ($fetchStyle === \PDO::FETCH_COLUMN) {
                return $this->statement->fetchAll($fetchStyle, $column);
            } else {
                return $this->statement->fetchAll($fetchStyle);
            }
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * Execute an SQL select statement.
     *
     * @param string           $table        The name of the table to select from.
     * @param array[optional]  $bind         An array of values to be bound to
     *                                       parameters in the query.
     * @param string[optional] $orderBy      The order by clause (e.g., 'name DESC').
     * @param mixed[optional]  $limit        The limit clause. This can be an
     *                                       integer, representing an upper limit;
     *                                       an array representing the offset and
     *                                       upper limit.
     * @param string[optional] $boolOperator The where clause operator.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::select()
     *
     * @access public
     * @return \Llama\Database\PDOAdapter
     */
    public function select($table, array $bind = array(), $orderBy = null, $limit = null, $boolOperator = 'AND')
    {
        if ($bind) {
            $where = array();

            foreach ($bind as $col => $value) {
                unset($bind[$col]);

                $bind[':' . $col] = $value;

                $where[] = $col . ' = :' . $col;
            }
        }

        $sql = 'SELECT * FROM `' . $table . '`' ;

        if ($bind) {
            $sql .= ' WHERE ' . implode(' ' . $boolOperator . ' ', $where);
        } else {
            ' ';
        }

        if (!is_null($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }

        if (!is_null($limit)) {
            if (is_array($limit)) {
                $sql .= " LIMIT {$limit[0]}, {$limit[1]}";
            } else {
                $sql .= " LIMIT $limit";
            }
        }

        $this->prepare($sql)->execute($bind);

        return $this;
    }

    /**
     * Execute an SQL insert statement and return the auto increment value.
     *
     * @param string $table The name of the table to insert into.
     * @param array  $bind  An array of values to be bound to  parameters in the
     *                      query.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::insert()
     *
     * @access public
     * @return int
     */
    public function insert($table, array $bind)
    {
        $cols = implode(', ', array_keys($bind));
        $values = implode(', :', array_keys($bind));

        foreach ($bind as $col => $value) {
            unset($bind[$col]);

            $bind[':' . $col] = $value;
        }

        $sql = 'INSERT INTO `' . $table . '` (' . $cols . ')  VALUES (:' . $values . ')';

        return (int) $this->prepare($sql)->execute($bind)->getLastInsertId();
    }

    /**
     * Execute an SQL update statement and return the number of records affected.
     *
     * @param string           $table The name of the table to update.
     * @param array            $bind  An array of values to be bound to
     *                                parameters in the query.
     * @param string[optional] $where The where conditions for the update query.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::update()
     *
     * @access public
     * @return int
     */
    public function update($table, array $bind, $where = '')
    {
        $set = array();

        foreach ($bind as $col => $value) {
            unset($bind[$col]);

            $bind[':' . $col] = $value;

            $set[] = $col . ' = :' . $col;
        }

        $sql = 'UPDATE `' . $table . '` SET ' . implode(', ', $set) . (($where) ? ' WHERE ' . $where : ' ');

        return $this->prepare($sql)->execute($bind)->getAffectedRows();
    }

    /**
     * Execute an SQL delete statement and return the number of records affected.
     *
     * @param string           $table The name of the table to delete from.
     * @param string[optional] $where The where conditions for the delete query.
     *
     * @see \Llama\Database\Adapter\AdapterInterface::delete()
     *
     * @access public
     * @return int
     */
    public function delete($table, $where = '')
    {
        $sql = 'DELETE FROM `' . $table . '`' . (($where) ? ' WHERE ' . $where : ' ');

        return $this->prepare($sql)->execute()->getAffectedRows();
    }
}

