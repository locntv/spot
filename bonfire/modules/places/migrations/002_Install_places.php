<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_places extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'places_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'places_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'places_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'places_longtitude' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				
			),
			'places_latitude' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				
			),
			'places_image' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('places');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('places');

	}

	//--------------------------------------------------------------------

}