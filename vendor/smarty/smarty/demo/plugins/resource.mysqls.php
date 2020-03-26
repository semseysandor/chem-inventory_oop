<?php
/**
 +---------------------------------------------------------------------+
 | This file is part of chem-inventory.                                |
 |                                                                     |
 | Copyright (c) 2020 Sandor Semsey                                    |
 | All rights reserved.                                                |
 |                                                                     |
 | This work is published under the MIT License.                       |
 | https://choosealicense.com/licenses/mit/                            |
 |                                                                     |
 | It's a free software;)                                              |
 |                                                                     |
 | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 | SOFTWARE.                                                           |
 +---------------------------------------------------------------------+
 */

/**
 * MySQL Resource
 * Resource Implementation based on the Custom API to use
 * MySQL as the storage resource for Smarty's templates and configs.
 * Note that this MySQL implementation fetches the source and timestamps in
 * a single database query, instead of two separate like resource.mysql.php does.
 * Table definition:
 * <pre>CREATE TABLE IF NOT EXISTS `templates` (
 *   `name` varchar(100) NOT NULL,
 *   `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *   `source` text,
 *   PRIMARY KEY (`name`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;</pre>
 * Demo data:
 * <pre>INSERT INTO `templates` (`name`, `modified`, `source`) VALUES ('test.tpl', "2010-12-25 22:00:00", '{$x="hello
 * world"}{$x}');</pre>
 *
 *
 * @package Resource-examples
 * @author  Rodney Rehm
 */
class Smarty_Resource_Mysqls extends Smarty_Resource_Custom
{
    /**
     * PDO instance
     *
     * @var \PDO
     */
    protected $db;

    /**
     * prepared fetch() statement
     *
     * @var \PDOStatement
     */
    protected $fetch;

    /**
     * Smarty_Resource_Mysqls constructor.
     *
     * @throws \SmartyException
     */
    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:dbname=test;host=127.0.0.1", "smarty");
        } catch (PDOException $e) {
            throw new SmartyException('Mysql Resource failed: ' . $e->getMessage());
        }
        $this->fetch = $this->db->prepare('SELECT modified, source FROM templates WHERE name = :name');
    }

    /**
     * Fetch a template and its modification time from database
     *
     * @param string  $name   template name
     * @param string  $source template source
     * @param integer $mtime  template modification timestamp (epoch)
     *
     * @return void
     */
    protected function fetch($name, &$source, &$mtime)
    {
        $this->fetch->execute(array('name' => $name));
        $row = $this->fetch->fetch();
        $this->fetch->closeCursor();
        if ($row) {
            $source = $row[ 'source' ];
            $mtime = strtotime($row[ 'modified' ]);
        } else {
            $source = null;
            $mtime = null;
        }
    }
}
