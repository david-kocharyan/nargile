<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');

class Rate_Api extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Simple register method.
	 * @return Response
	 */
	public function index_post()
	{
		$res = $this->verify_get_request();
		if (gettype($res) != 'string') {
			$data = array(
				"success" => false,
				"data" => array(),
				"msg" => $res['msg']
			);
			$this->response($data, $res['status']);
			return;
		}

		$rate = array(
			"user_id" => $res,
			"restaurant_id" => $this->input->post("id"),
			"overall" => $this->input->post("overall"),
			"taste" => $this->input->post("taste"),
			"charcoal" => $this->input->post("charcoal"),
			"cleanliness" => $this->input->post("cleanliness"),
			"staff" => $this->input->post("staff"),
			"value_for_money" => $this->input->post("value_for_money"),
		);

		$review = $this->input->post("review");
		$this->db->insert('rates', $rate);

		$user = $this->db->get_where("users", array("id" => $res))->row();

		if (NULL != $review){
			$this->db->trans_start();

			$this->db->insert('reviews', array("user_id" => $res, "restaurant_id" => $this->input->post("id"), "review" => $review));

			$this->db->set('coins', $user->coins + 3);
			$this->db->where('id', $user->id);
			$this->db->update('users');

			$this->db->trans_complete();
		}

//		calculate total rate
		$this->db->select("overall");
		$res_rate = $this->db->get_where("rates", array("restaurant_id" => $this->input->post("id")))->result();
		$counter = 0;
		$total = 0;
		foreach ($res_rate as $row) {
			$counter++;
			$total += $row->overall;
		}
		$total_rate = $total / $counter;

		$user = $this->db->get_where("users", array("id" => $res))->row();

		$this->db->trans_start();

		$this->db->set('rate', $total_rate);
		$this->db->where('id', $this->input->post("id"));
		$this->db->update('restaurants');

		$this->db->set('coins', $user->coins + 1);
		$this->db->where('id', $user->id);
		$this->db->update('users');

		$this->db->trans_complete();

//		response
		$data = array(
			"success" => true,
			"data" => array(),
			"msg" => "Rate successfully saved",
		);
		$this->response($data, REST_Controller::HTTP_OK);
	}
}
