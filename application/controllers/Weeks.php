<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weeks extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (($this->session->userdata('user') == NULL OR !$this->session->userdata('user'))) {
			redirect('/admin/login');
		}
		$this->load->model("Week");
	}

	public function index($id)
	{
		$type = $this->check_admin_restaurant($id);

		$data['user'] = $this->session->userdata('user');
		$data['title'] = "Weeks";
		$data['week'] = $this->Week->selectAll($id);
		$data['id'] = $id;

		$this->load->view('layouts/header.php', $data);
		$this->load->view('restaurants/weeks/index.php');
		$this->load->view('layouts/footer.php');
	}

	public function store($id)
	{
		$type = $this->check_admin_restaurant($id);

		$day = $this->input->post('day');
		$open = $this->input->post('open');
		$close = $this->input->post('close');
		$type = $this->input->post('type');

		for ($i = 0; $i < count($day); $i++) {
			if ($type[$i] == 1) {
				if (trim($day[$i]) != '' && trim($open[$i]) != '' && trim($close[$i]) != '') {
					$this->db->insert("restaurant_weeks", array("day" => $day[$i], "type" => 1, "open" => $open[$i], "close" => $close[$i], 'restaurant_id' => $id));
				}
			} elseif ($type[$i] == 0) {
				$this->db->insert("restaurant_weeks", array("day" => $day[$i], "type" => 0, "open" => "", "close" => "", 'restaurant_id' => $id));
			} else {
				redirect('404_override');
				return;
			}
		}
		redirect("admin/restaurants/weeks/$id");
	}

	public function edit($id)
	{
		$data['user'] = $this->session->userdata('user');
		$data['title'] = "More Info Edit";
		$data['weeks'] = $this->Week->select($id);
		$type = $this->check_admin_restaurant($data['weeks']->restaurant_id);

		$this->load->view('layouts/header.php', $data);
		$this->load->view('restaurants/weeks/edit.php');
		$this->load->view('layouts/footer.php');
	}

	public function update($id)
	{
		$type = $this->check_admin_restaurant($this->Week->select($id)->restaurant_id);

		$open = $this->input->post('open');
		$close = $this->input->post('close');
		$type = $this->input->post('type');

		if ($type == 1) {
			$this->form_validation->set_rules('open', 'Open', 'required');
			$this->form_validation->set_rules('close', 'Close', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->edit($id);
				return;
			}
			$this->Week->update($id, array("open" => $open, "close" => $close, 'type' => $type));

		}
		else{
			$this->Week->update($id, array("open" => "", "close" => "", 'type' => $type));
		}

		$this->session->set_flashdata('success', 'You have change the working hour successfully');
		redirect("admin/restaurants/weeks/edit/$id");
	}

	public function change_status($id)
	{
		$data = $this->db->get_where('restaurant_weeks', ["id" => $id])->row();
		if (null == $data) {
			redirect('404_override');
			return;
		}
		$type = $this->check_admin_restaurant($data->restaurant_id);
		$status = $data->status == 1 ? 0 : 1;
		$this->db->update('restaurant_weeks', array("status" => $status), ['id' => $id]);
		redirect("admin/restaurants/weeks/$data->restaurant_id");
	}

	//	check admin type
	private function check_admin_restaurant($res_id)
	{
		$admin_id = $this->session->userdata('user')['user_id'];

		$type = $this->check_admin();
		if ($type == 2) {
			$res_admin_id = $this->db->get_where('restaurants', array('id' => $res_id))->row()->admin_id;
			if ($res_admin_id != $admin_id) {
				redirect('404_override');
			}
		}
	}

	private function check_admin()
	{
		$admin_role = $this->session->userdata('user')['role'];

		if ($admin_role == 'superAdmin') {
			return 1;
		} elseif ($admin_role == 'admin') {
			return 2;
		} else {
			redirect('404_override');
			return;
		}
	}
}
