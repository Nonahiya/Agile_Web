<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Users extends CI_Migration
{
    protected $tableName  = 'users';

    public function up()
    {
		$fields = array(
			'id'         => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'email'      => [
				'type'   => 'VARCHAR(255)',
				'unique' => TRUE,
			],
			'password'   => [
				'type' => 'VARCHAR(64)',
			],
			'name'  => [
				'type' => 'VARCHAR(64)',
			],
			'gender'  => [
				'type' 			=> 'ENUM("None","Male","Female")',
                'default' 		=> 'None',
			],
			'city'  => [
				'type' => 'VARCHAR(64)',
			],
            'birthdate' => [
                'type' => 'TIMESTAMP',
            ],
            'phone' => [
                'type' => 'VARCHAR(15)',
            ],
			'role'  => [
				'type' 			=> 'ENUM("Member","Leader")',
                'default' 		=> 'Member',
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
        $this->dbforge->create_table($this->tableName);
    }

    public function down()
    {
        $this->dbforge->drop_table($this->tableName);
    }
}


/* End of file 20230516154751_users.php and path \application\migrations\20230516154751_users.php */
