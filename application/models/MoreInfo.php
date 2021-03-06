<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MoreInfo extends CI_Model
{
	private $table = 'more_infos';

	function __construct()
	{
		parent:: __construct();
	}

	public function selectAll($id)
	{
		return $this->db->get_where($this->table, array('restaurant_id' => $id))->result();
	}

	public function select($id)
	{
		return $this->db->get_where($this->table, array('id' => $id))->row();
	}

	public function update($id, $data)
	{
		$this->db->update($this->table, $data, ["id" => $id]);
	}


}
