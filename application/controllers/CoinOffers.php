<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoinOffers extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('user') == NULL OR !$this->session->userdata('user')) {
			redirect('/admin/login');
		}
		$this->load->model("CoinOffer");
	}

	public function index($id)
	{
		$type = $this->check_admin_restaurant($id);

		$data['user'] = $this->session->userdata('user');
		$data['title'] = "Coin Offers";
		$data['coins'] = $this->CoinOffer->selectAll($id);
		$data['id'] = $id;
		$data['country'] = $this->db->get_where('countries', array('status' => 1))->result();
		$data['region'] = $this->db->get_where('regions', array('status' => 1))->result();


		$this->load->view('layouts/header.php', $data);
		$this->load->view('restaurants/coinOffers/index.php');
		$this->load->view('layouts/footer.php');
	}

	public function store($id)
	{
		$type = $this->check_admin_restaurant($id);

		$price = $this->input->post('price');
		$valid = $this->input->post('valid');
		$desc = $this->input->post('desc');
		$count = $this->input->post('count');
		$country = $this->input->post('country');
		$region = $this->input->post('region');

		$this->form_validation->set_rules('price', 'Price', 'required|trim');
		$this->form_validation->set_rules('valid', 'Valid Date', 'required|trim');
		$this->form_validation->set_rules('desc', 'Description', 'required|trim');
		$this->form_validation->set_rules('count', 'Offers Quantity', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$this->index($id);
			return;
		}

		if ($this->session->userdata('user')['role'] == 'admin') {
			$status = 2;
		}
		if ($this->session->userdata('user')['role'] == 'superAdmin') {
			$status = 1;
		}

		$data = array(
			"price" => $price,
			"valid_date" => strtotime($valid),
			"description" => $desc,
			"count" => $count,
			'restaurant_id' => $id,
			'country' => $country,
			'region' => $region,
			"status" => $status,
		);

		$this->db->insert("coin_offers", $data);

		redirect("admin/restaurants/coin-offers/$id");
	}

	public function edit($id)
	{
		$data['user'] = $this->session->userdata('user');
		$data['title'] = "Coin Offer Edit";
		$data['coins'] = $this->CoinOffer->select($id);
		$type = $this->check_admin_restaurant($data['coins']->restaurant_id);

		$data['country'] = $this->db->get_where('countries', array('status' => 1))->result();
		$data['region'] = $this->db->get_where('regions', array('status' => 1))->result();

		$this->load->view('layouts/header.php', $data);
		$this->load->view('restaurants/coinOffers/edit.php');
		$this->load->view('layouts/footer.php');
	}

	public function update($id)
	{
		$res = $this->CoinOffer->select($id)->restaurant_id;
		$type = $this->check_admin_restaurant($res);

		$price = $this->input->post('price');
		$date = $this->input->post('date');
		$desc = $this->input->post('desc');
		$count = $this->input->post('count');
		$country = $this->input->post('country');
		$region = $this->input->post('region');


		$this->form_validation->set_rules('price', 'Price', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('desc', 'Description', 'required');
		$this->form_validation->set_rules('count', 'Quantity ', 'required');
		$this->form_validation->set_rules('country', 'Country ', 'required');
		$this->form_validation->set_rules('region', 'Region ', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->edit($id);
			return;
		}

		if ($this->session->userdata('user')['role'] == 'admin') {
			$status = 2;
		}
		if ($this->session->userdata('user')['role'] == 'superAdmin') {
			$status = 1;
		}

		$this->CoinOffer->update($id, array("price" => $price, "valid_date" => strtotime($date), "description" => $desc, "count" => $count,
			'country' => $country, 'region' => $region,'status' => $status));
		$this->session->set_flashdata('success', 'You have change the offer successfully');
		redirect("admin/restaurants/coin-offers/$res");
	}

	public function change_status($id)
	{
		$data = $this->db->get_where('coin_offers', ["id" => $id])->row();
		if (null == $data) {
			return;
		}
		$type = $this->check_admin_restaurant($data->restaurant_id);
		$status = $data->status == 1 ? 0 : 1;
		$this->db->update('coin_offers', array("status" => $status), ['id' => $id]);
		redirect("admin/restaurants/coin-offers/$data->restaurant_id");
	}

//	coin approve-------------------------------------------------------------------------------------------------------
	public function approve_offer_index()
	{
		$data['user'] = $this->session->userdata('user');
		$data['coins'] = $this->CoinOffer->select_pending_offer();
		$data['featured'] = $this->CoinOffer->select_featured();
		$data['hour'] = $this->CoinOffer->select_hour();
		$data['title'] = "Approve Offers";

		$this->load->view('layouts/header.php', $data);
		$this->load->view('all_offers/coin_offer_approve.php');
		$this->load->view('layouts/footer.php');
	}

	public function approve($id)
	{
		$this->db->select('coin_offers.*, restaurants.admin_id');
		$this->db->join('restaurants', 'restaurants.id = coin_offers.restaurant_id');
		$offer = $this->db->get_where('coin_offers', array('coin_offers.id' => $id))->row();

		$data = array(
			'admin_id' => $offer->admin_id,
			'message' => "Super admin approve your Coin offer` '$offer->description' ",
			'date' => date("Y-m-d"),
		);

		$this->db->insert('approve_notification', $data);

		$this->CoinOffer->approve_coin($id);
		redirect('admin/coin-offers/approve');
	}

	public function approve_featured($id)
	{
		$this->db->select('featured_offers.*, restaurants.admin_id');
		$this->db->join('restaurants', 'restaurants.id = featured_offers.restaurant_id');
		$offer = $this->db->get_where('featured_offers', array('featured_offers.id' => $id))->row();

		$data = array(
			'admin_id' => $offer->admin_id,
			'message' => "Super admin approve your Featured offer` '$offer->text' ",
			'date' => date("Y-m-d"),
		);

		$this->db->insert('approve_notification', $data);

		$this->CoinOffer->approve_featured($id);
		redirect('admin/coin-offers/approve');
	}

	public function approve_hour($id)
	{
		$this->db->select('hour_offers.*, restaurants.admin_id');
		$this->db->join('restaurants', 'restaurants.id = hour_offers.restaurant_id');
		$offer = $this->db->get_where('hour_offers', array('hour_offers.id' => $id))->row();

		$data = array(
			'admin_id' => $offer->admin_id,
			'message' => "Super admin approve your Hour offer` '$offer->text' ",
			'date' => date("Y-m-d"),
		);

		$this->db->insert('approve_notification', $data);

		$this->CoinOffer->approve_hour($id);
		redirect('admin/coin-offers/approve');
	}

//	coin approve end --------------------------------------------------------------------------------------------------

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
