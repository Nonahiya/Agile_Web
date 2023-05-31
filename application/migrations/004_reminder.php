<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Reminder extends CI_Migration
{
    protected $tableName  = 'reminder';

    public function up()
    {
        
		$fields = array(
			'id'         => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'leader_id'         => [
				'type'           => 'INT(11)',
			],
			'content'      => [
				'type'   => 'VARCHAR(64)',
			],
			'date' => [
				'type' => 'TIMESTAMP',
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
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (leader_id) REFERENCES user(id)');
        $this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->tableName);
    }
}


/* End of file 20230530203200_reminder.php and path \application\migrations\20230530203200_reminder.php */
