<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Materials extends CI_Migration
{
    protected $tableName  = 'materials';

    public function up()
    {
        
		$fields = array(
			'id'         => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'user_id'         => [
				'type'           => 'INT(11)',
			],
			'title'      => [
				'type'   => 'VARCHAR(64)',
			],
			'content'   => [
				'type' => 'LONGTEXT',
			],
			'created_at' => [
				'type' => 'TIMESTAMP',
			],
			'updated_at' => [
				'type' => 'TIMESTAMP',
			],
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES user(id)');
        $this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->tableName);
    }
}


/* End of file 20230530202250_materials.php and path \application\migrations\20230530202250_materials.php */
