<?php

class GlobalModal extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function addData($tableName, $insertData)
	{
		try {
			$this->db->trans_start();
			$this->db->insert($tableName, $insertData);
			$isnertId = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");
				return array('id' => '', 'status' => 400, 'message' => 'data not inserted');
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				return array('id' => $isnertId, 'status' => 200, 'message' => 'data inserted');
				$result = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			return array('id' => '', 'status' => 400, 'message' => 'data not inserted');
		}
	}

	public function addDataBatch($tableName, $insertData)
	{
		try {
			$this->db->trans_start();
			print_r($insertData);
			exit();
			$this->db->insert_batch($tableName, $insertData);
			$result['user_id'] = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");

				$result['status'] = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				$result['status'] = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result['status'] = FALSE;
		}
		return $result;
	}

	public function addDataArray($tabelArray)

	{
		try {
			$this->db->trans_start();
			foreach ($tabelArray as $arrayData) {
				$this->db->insert($arrayData['tableName'], $arrayData['tableData']);
			}
			//			$this->db->insert($tableName, $insertData);
			$result['user_id'] = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");

				$result['status'] = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				$result['status'] = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result['status'] = FALSE;
		}
		return $result;
	}

	public function updateDataArrayOne($tabelArray)

	{
		try {
			$this->db->trans_start();
			foreach ($tabelArray as $arrayData) {
				//				var_dump($this->checkAlreadyexist($arrayData['tableName'],$arrayData['set_data']));
				if ($this->checkAlreadyexist($arrayData['tableName'], $arrayData['set_data'])) {
					unset($arrayData['tableData']['product_id']);
					$this->db->set($arrayData['tableData']);
					$this->db->where($arrayData['set_data']);
					$this->db->update($arrayData['tableName']);
				} else {
					$this->db->insert($arrayData['tableName'], $arrayData['tableData']);
					$result['user_id'] = $this->db->insert_id();
				}
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");

				$result['status'] = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				$result['status'] = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result['status'] = FALSE;
		}
		return $result;
	}

	public  function checkAlreadyexist($table, $where)
	{
		$data = $this->db->select(array('*'))->where($where)->get($table)->result_array();
		if (!empty($data)) {
			return  true;
		} else {
			return false;
		}
	}

	public function addMultipalTableData($tableArray)
	{

		try {
			foreach ($tableArray as $singleTable) {
				$tableName = $singleTable['table_name'];
				$insertData = $singleTable['table_data'];
				var_dump($tableName);
				var_dump($insertData);
				//				$this->db->trans_start();
				//				$this->db->insert($tableName, $insertData);
				$result['user_id'] = $this->db->insert_id();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "insert Data Transaction Rollback");

					$result['status'] = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "insert Data Transaction Commited");
					$result['status'] = TRUE;
				}
				$this->db->trans_complete();
			}
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result['status'] = FALSE;
		}
		return $result;
	}

	public function deleteData($tableName, $whereData)
	{
		try {
			$this->db->trans_start();
			$this->db->where($whereData);
			$this->db->delete($tableName);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");
				$result = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				$result = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result = FALSE;
		}
		return $result;
	}

	public function getDataArray($tableName, $selectArray, $whereArray, $order_by = '')
	{
		$this->db->select($selectArray);

		$this->db->where($whereArray);
		if ($order_by != '') {
			$this->db->order_by($order_by);
		}
		$data = $this->db->get($tableName)->result_array();
		if (count($data) == 0) {
			return false;
		} else {
			return $data;
		}
	}

	public function getDataArrayJoin($tableName, $selectArray, $whereArray, $joinArray, $order_by = array())
	{
		$this->db->select($selectArray);
		foreach ($joinArray as $new_join) {
			$this->db->join($new_join['table_name'], $new_join['column_names'], $new_join['join_type']);
		}
		$this->db->where($whereArray);
		if (!empty($order_by)) {
			$this->db->order_by($order_by['name'], $order_by['order']);
		}

		$data = $this->db->get($tableName)->result_array();
		if (count($data) == 0) {
			return false;
		} else {
			return $data;
		}
	}




	public function executeQuery($query)
	{
		$data = $this->db->query($query)->result_array();
		//		var_dump($this->db->last_query());
		if (count($data) == 0) {
			return false;
		} else {
			return $data;
		}
	}

	public function updateData($tableName, $setData, $whereData)
	{
		try {
			$this->db->trans_start();
			$this->db->where($whereData);
			$this->db->set($setData);
			$this->db->update($tableName);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");
				$result = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				$result = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result = FALSE;
		}
		return $result;
	}

	public function updateDataArray($tableArray)
	{
		try {
			$this->db->trans_start();
			foreach ($tableArray as $tableData) {
				$this->db->where($tableData['whereArray']);
				$this->db->set($tableData['setArray']);
				$this->db->update($tableData['table']);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert Data Transaction Rollback");
				$result = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert Data Transaction Commited");
				$result = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result = FALSE;
		}
		return $result;
	}

	public function generatedIds($tableName, $checkColumn, $idPreFix = '')
	{
		if ($idPreFix == '') {
			$return_id = rand(111111, 999999);
		} else {
			$return_id = $idPreFix . rand(11111111111111, 99999999999999);
		}

		$this->db->select($checkColumn);

		$this->db->where(array($checkColumn => $return_id));

		$data = $this->db->get($tableName)->result_array();
		if (count($data) == 0) {
			return $return_id;
		} else {
			return $this->generatedIds($tableName, $checkColumn, $idPreFix);
		}
	}

	function upload_multiple_file_new($upload_path, $inputname, $combination = "")
	{

		$combination = (explode(",", $combination));

		$check_file_exist = $this->check_file_exist($upload_path);

		if ($_FILES[$inputname]['error'][0] != 4) {

			$files = $_FILES;
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = '*';
			//            $config['max_size'] = '20000000';    //limit 10000=1 mb
			$config['remove_spaces'] = true;
			$config['overwrite'] = false;

			$this->load->library('upload', $config);

			if (is_array($_FILES[$inputname]['name'])) {
				$count = count($_FILES[$inputname]['name']); // count element
				$files = $_FILES[$inputname];
				$images = array();
				$dataInfo = array();

				if (in_array("1", $combination)) {
					for ($j = 0; $j < $count; $j++) {
						$fileName = $files['name'][$j];
						if (in_array($fileName, $check_file_exist)) {
							$response['status'] = 201;
							$response['body'] = $fileName . " Already exist";
							return $response;
						}
					}
				}
				$inputname = $inputname . "[]";
				for ($i = 0; $i < $count; $i++) {
					$_FILES[$inputname]['name'] = $files['name'][$i];
					$_FILES[$inputname]['type'] = $files['type'][$i];
					$_FILES[$inputname]['tmp_name'] = $files['tmp_name'][$i];
					$_FILES[$inputname]['error'] = $files['error'][$i];
					$_FILES[$inputname]['size'] = $files['size'][$i];
					$fileName = $files['name'][$i];
					//get system generated File name CONCATE datetime string to Filename
					if (in_array("2", $combination)) {
						$date = date('Y-m-d H:i:s');
						$randomdata = strtotime($date);
						$fileName = $randomdata . $fileName;
					}
					$images[] = $fileName;

					$config['file_name'] = $fileName;

					$this->upload->initialize($config);
					$up = $this->upload->do_upload($inputname);
					// var_dump($up);
					$dataInfo[] = $this->upload->data();
				}

				$file_with_path = array();
				foreach ($dataInfo as $row) {
					$raw_name = $row['raw_name'];
					$file_ext = $row['file_ext'];
					$file_name = $raw_name . $file_ext;
					if ($row['file_name'] != '') {
						$file_with_path[] = $upload_path . "/" . $row['file_name'];
					} else {
						$file_with_path[] = '';
					}
				}

				$response['status'] = 200;
				$response['body'] = $file_with_path;
				return $response;
			}
		} else {
			$response['status'] = 201;
			$response['body'] = array();
			return $response;
		}
	}

	function check_file_exist($upload_path)
	{
		$filesnames = array();

		foreach (glob('./' . $upload_path . '/.') as $file_NAMEEXISTS) {
			$file_NAMEEXISTS;
			$filesnames[] = str_replace("./" . $upload_path . "/", "", $file_NAMEEXISTS);
		}
		return $filesnames;
	}

	function getJoinArray($tableName, $selectData, $joinArrat)
	{
	}

	public function sendSms($mobile_no, $message = '')
	{
		$number = $mobile_no;
		$from = "EXBSKT";
		$url = "http://43.242.214.11/mobicomm/submitsms.jsp?user=ARTHAM&key=f82fc90804XX&mobile=$mobile_no&message=$message&senderid=abcdef&accusage=1";
		try {
			$ch = curl_init();

			// Check if initialization had gone wrong*
			if ($ch === false) {
				throw new Exception('failed to initialize');
			}

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//			curl_setopt(/* ... */);

			$content = curl_exec($ch);

			// Check the return value of curl_exec(), too
			if ($content === false) {
				throw new Exception(curl_error($ch), curl_errno($ch));
			}


			/* Process $content here */

			// Close curl handle


			curl_close($ch);
		} catch (Exception $e) {

			trigger_error(
				sprintf(
					'Curl failed with error #%d: %s',
					$e->getCode(),
					$e->getMessage()
				),
				E_USER_ERROR
			);
		}
	}

	public function sendMail($to, $subject, $body)
	{

		$from_email =  'info@arthamandir.in';

		//Load email library

		$this->load->library('email');
		$this->email->from($from_email, 'Arthmandir Nidhi Ltd');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->set_mailtype("html");
		$this->email->message($body);
		//Send mail
		if ($this->email->send()) {
			return true;
		} else {
			return false;
		}
	}

	public  function  createPostArray($data = array())
	{
		$parameter_list = $_POST;
		if (!empty($parameter_list)) {
			$return_array = array();
			foreach ($parameter_list as $keys => $values) {
				$return_array[$keys] = $values == '' ? '' : $values;
			}
			return array_merge($return_array, $data);
		} else {
			return false;
		}
	}

	public function CheckIsUser($user_name, $password)
	{
		$this->db->select('user_id');
		$password = $this->encrypt->decode($password);
		var_dump($password);
		$this->db->where(array('username' => $user_name, 'password' => $password));

		$data = $this->db->get('admin_login')->result_array();


		if (count($data) == 0) {
			return false;
		} else {
			return true;
		}
	}

	function allposts_count()
	{
		$query = $this
			->db
			->get('user');

		return $query->num_rows();
	}

	function allposts($limit, $start, $col, $dir)
	{
		$query = $this
			->db
			->limit($limit, $start)
			->order_by($col, $dir)
			->get('user');

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	function posts_search($limit, $start, $search, $col, $dir)
	{
		$query = $this
			->db
			->like('id', $search)
			->or_like('unic_code', $search)
			->limit($limit, $start)
			->order_by($col, $dir)
			->get('user');


		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	function posts_search_count($search)
	{
		$query = $this
			->db
			->like('id', $search)
			->or_like('unic_code', $search)
			->get('user');

		return $query->num_rows();
	}

	public function generateOrderConfirmMailUi($orderDetails, $productDetails, $customerInfo, $cartSummaryAmt)
	{

		$shippingDetails = json_decode($orderDetails['deliver_address']);
		$shipCustName = $shippingDetails->firstname . " " . $shippingDetails->lastname;
		$shipCompany = $shippingDetails->company;
		$shipPostCode = $shippingDetails->post_code;
		$shipAdd1 = $shippingDetails->add_1;
		$shipAdd2 = $shippingDetails->add_2;
		$shipCity = $shippingDetails->city;
		$shipCountry = $shippingDetails->country;
		$shipState = $shippingDetails->state;
		// var_dump($shippingDetails);

		$shipDetailsUi = '<p>' . $shipCustName . '<br>' . $shipAdd1;
		if ($shipAdd2 != '') {
			$shipDetailsUi .= '<br>' . $shipAdd2;
		}
		$shipDetailsUi .= '<br>' . $shipCity . ',' . $shipState;
		$shipDetailsUi .= '<br>' . $shipCountry . ',' . $shipPostCode;
		$shipDetailsUi .= '</p>';


		if (count($productDetails) > 0) {
			$productTableUi = '';
			foreach ($productDetails as $productData) {


				$productItemsData = $productData['tableData'];
				$productNameSectionU = '<p>' . $productItemsData['product_name'] . ',' . $productItemsData['clip_option'];
				if (isset($productItemsData['material']) && $productItemsData['material'] != '') {
					$productNameSectionU .= '<br>' . $productItemsData['material'];
				}
				$productNameSectionU .= '<br>' . $productItemsData['clip_and_ring'];
				$productTableUi .= '<tr width="100%">
				<td
				  width="30%"
				  style="
					text-align: left;
					vertical-align: middle;
					border-left: 1px solid #eee;
					border-bottom: 1px solid #eee;
					border-right: 0;
					border-top: 0;
					word-wrap: break-word;
				  "
				>
				  ' . $productNameSectionU . '
				</td>
				<td
				  width="15%"
				  style="
					text-align: right;
					vertical-align: middle;
					border-left: 1px solid #eee;
					border-bottom: 1px solid #eee;
					border-right: 0;
					border-top: 0;
				  "
				>
				' . $productItemsData['qty'] . '
				</td>
				<td
				  width="20%"
				  style="
					text-align: right;
					vertical-align: middle;
					border-left: 1px solid #eee;
					border-bottom: 1px solid #eee;
					border-right: 1px solid #eee;
					border-top: 0;
				  "
				>
				  <span>' . $this->session->userdata('currency_symbol') . ' ' . $productItemsData['total'] . '</span>
				</td>
			  </tr>';
			}
		}
		$html = '<html>
		<head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
	  
		<body>
		  <table
			border="0"
			align="center"
			cellpadding="0"
			cellspacing="0"
			width="100%"
			style="max-width: 100%; background: #e9e9e9; padding: 50px 0px"
		  >
			<tr>
			  <td>
				<table
				  border="0"
				  align="center"
				  cellpadding="0"
				  cellspacing="0"
				  width="100%"
				  style="max-width: 600px; background: #ffffff; padding: 0px 25px"
				>
				  <tbody>
					<tr>
					  <td style="margin: 0; padding: 0">
						<table
						  border="0"
						  cellpadding="20"
						  cellspacing="0"
						  width="100%"
						  style="background:#ffffff;color:#1a1a1a;line-height:150%;text-align:center;border-bottom:1px solid #e9e9e9;font-family:300 14px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif"
						>
						  <tbody>
							<tr>
							  <td
								valign="top"
								align="center"
								width="50"
								style="
								  background-color: #ffffff;
								  text-align-last: start;
								  padding: 5px;
								"
							  >
								<img
								  alt="Swiggy"
								  style=""
								  src="https://www.lotuspens.com/image/catalog/logo.jpg"
								/>
							  </td>
							  <td
								valign="top"
								align="center"
								width="50"
								style="
								  background-color: #ffffff;
								  text-align-last: end;
								  padding: 5px;
								"
							  >
								<table
								  border="0"
								  cellpadding="20"
								  cellspacing="0"
								  width="100%"
								  style="color:#000000;line-height:150%;text-align:left;font:300 16px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif"
								>
								  <tbody>
									<tr>
									  <td
										valign="top"
										style="font-size: 15px; padding: 5px"
									  >
										<span><strong>Order No: </strong>#' . $orderDetails['order_generate_id'] . '</span>
									  </td>
									</tr>
									<tr>
									  <td
										valign="top"
										style="font-size: 15px; padding: 5px"
									  >
										<span><strong>Order Date: </strong>' . $orderDetails['order_date'] . '</span>
									  </td>
									</tr>
								  </tbody>
								</table>
							  </td>
							</tr>
						  </tbody>
						</table>
	  
						<br />
	  
						<table
						  border="0"
						  cellpadding=""
						  cellspacing="0"
						  width="100%"
						  style="background:#ffffff;color:#000000;line-height:150%;text-align:center;font:300 16px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif"
						>
						  <tbody>
							<tr>
							  <td
								valign="top"
								width="100"
								style="text-align: justify"
							  >
								<h5></h5>
								<p>
								  <strong>Dear ' . $customerInfo[0]['full_name'] . ',</strong> <br />
								  We hope this email finds you well. We are delighted
								  to inform you that we have received your recent
								  order on our website and would like to express our
								  gratitude for choosing Lotus Writing Instruments for
								  your fountain pen.
								</p>
							  </td>
							</tr>
						  </tbody>
						</table>
						<br />
						<hr />
						<table
						  border="0"
						  cellpadding="20"
						  cellspacing="0"
						  width="100%"
						  style="color:#000000;line-height:150%;text-align:left;font:300 14px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif"
						>
						  <tbody>
							<tr>
							  <td valign="top" style="padding: 5px">
								<h4
								  style="
									font-size: 20px;
									margin: 0;
									padding: 0;
									margin-bottom: 5px;
								  "
								>
								  Shipping Details
								</h4>
								' . $shipDetailsUi . '
							  </td>
							</tr>
						  </tbody>
						</table>
						<hr />
						<table
						  align="center"
						  cellspacing="0"
						  cellpadding="6"
						  width="100%"
						  style="border:0;color:#000000;line-height:150%;text-align:left;font:300 14px/30px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif;"
						  border=".5px"
						>
						  <thead>
							<tr style="background: #efefef">
							  <th
								scope="col"
								width="30%"
								style="text-align: left; border: 1px solid #eee"
							  >
								Product
							  </th>
							  <th
								scope="col"
								width="15%"
								style="text-align: right; border: 1px solid #eee"
							  >
								Quantity
							  </th>
							  <th
								scope="col"
								width="20%"
								style="text-align: right; border: 1px solid #eee"
							  >
								Price
							  </th>
							</tr>
						  </thead>
						  <tbody>' . $productTableUi . '</tbody>
						  <tfoot>
							
	  
							<tr>
							  <th
								scope="row"
								colspan="2"
								style="
								  text-align: right;
								  background: #efefef;
								  text-align: right;
								  border-left: 1px solid #eee;
								  border-bottom: 1px solid #eee;
								  border-right: 0;
								  border-top: 0;
								"
							  >
								Order Total
							  </th>
							  <td
								style="
								  background: #efefef;
								  text-align: right;
								  vertical-align: middle;
								  border-left: 1px solid #eee;
								  border-bottom: 1px solid #eee;
								  border-right: 1px solid #eee;
								  border-top: 0;
								  color: #7db701;
								  font-weight: bold;
								"
							  >
								<span>' . $this->session->userdata('currency_symbol') . ' ' . $cartSummaryAmt . '</span>
							  </td>
							</tr>
						  </tfoot>
						</table>
						<br />
						<table
						  cellspacing="0"
						  cellpadding="6"
						  width="100%"
						  style="color:#000000;line-height:150%;text-align:left;font:300 16px &#39;Helvetica Neue&#39;,Helvetica,Arial,sans-serif"
						  border="0"
						>
						  <tbody>
							<tr>
							  <td valign="top" style="text-transform: capitalize">
								<p style="font-size: 12px; line-height: 130%">
								  We want to assure you that our team is already hard
								  at work, preparing your order for shipment. We
								  understand how important it is for you to receive
								  your items promptly and in excellent condition and
								  shall take about 3 to 4 weeks as each pen is made to
								  order. Rest assured, we are committed to ensuring a
								  smooth and timely delivery process.
								</p>
								<p>
								  If you have any questions or require further
								  assistance regarding your order, please do not
								  hesitate to us. We are here to assist you.
								</p>
								<p>
								  Thank you once again for choosing Lotus Writing
								  Instruments. We value your trust and are committed
								  to providing you with a seamless shopping
								  experience.
								</p>
								<br />
								<br />
								<strong>Warm Regards,</strong>
								<p style="margin: 0px; margin-top: 5px">Team Lotus</p>
							  </td>
							</tr>
						  </tbody>
						</table>
						<br />
	  
						<br />
						<table
						  width="100%"
						  cellpadding="0"
						  cellspacing="0"
						  border="0"
						  align="center"
						  style="
							border-top: 1px solid #e9e9e9;
							border-bottom: 1px solid #e9e9e9;
							font-family: Arial, Helvetica, sans-serif;
							font-size: 12px;
							padding: 0px;
						  "
						>
						  <tbody>
							<tr>
							  <td align="left" width="33%">
								<table
								  border="0"
								  cellspacing="0"
								  cellpadding="0"
								  style="
									font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
								  "
								>
								  <tbody>
									<tr>
									  <td width="60%">
										<a
										target="_blank"
										href="https://www.lotuspens.com/orders"
										  style="
											background-color: #B4557D;
											color: #fff;
											padding: 10px 20px;
											border: none;
											box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
											cursor: pointer;
											border-radius: 10px;
											text-decoration: none;
										  "
										>
										  View Order Details
									  </a>
									  </td>
									  <td width="5%"></td>
									  <td width="15%"></td>
									  <td width="5%"></td>
									  <td width="15%"></td>
									</tr>
								  </tbody>
								</table>
							  </td>
	  
							  <td align="right" width="20%">
								<table
								  border="0"
								  cellspacing="0"
								  cellpadding="0"
								  height="50"
								  style="
									font-family: Arial, Helvetica, sans-serif;
									font-size: 12px;
								  "
								>
								  <tbody>
									<tr>
									  <td width="5%"></td>
									  <td width="20%">
										<a
										  href="https://www.facebook.com/lotus_pens"
										  target="_blank"
										>
										  <img
											style="max-height: 20px; width: auto"
											src="https://res.cloudinary.com/swiggy/image/upload/v1447855170/Facebook_ezoqwy.png"
											alt="Swiggy Facebook"
											style="display: block"
											border="0"
										/></a>
									  </td>
									  <td width="5%"></td>
									  <td width="20%">
										<a
										  href="https://twitter.com/lotus_pens"
										  target="_blank"
										>
										  <img
											style="max-height: 20px; width: auto"
											src="https://res.cloudinary.com/swiggy/image/upload/v1447855171/Twitter_stmvbr.png"
											alt="Swiggy Twitter"
											style="display: block"
											border="0"
										/></a>
									  </td>
									  <td width="5%"></td>
									  <td width="20%">
										<a
										  href="https://www.pinterest.com/lotus_pens/"
										  target="_blank"
										>
										  <img
											style="max-height: 20px; width: auto"
											src="https://res.cloudinary.com/swiggy/image/upload/v1447855171/Pinterest_dd2nv9.png"
											alt="Swiggy pinterest"
											style="display: block"
											border="0"
										/></a>
									  </td>
									  <td width="5%"></td>
									  <td width="20%">
										<a
										  href="https://instagram.com/lotus_pens/"
										  target="_blank"
										>
										  <img
											style="max-height: 20px; width: auto"
											src="https://res.cloudinary.com/swiggy/image/upload/v1447855170/Instagram_okx3pg.png"
											alt="Swiggy instagram"
											style="display: block"
											border="0"
										/></a>
									  </td>
									</tr>
								  </tbody>
								</table>
							  </td>
							</tr>
						  </tbody>
						</table>
						<br />
					  </td>
					</tr>
				  </tbody>
				</table>
			  </td>
			</tr>
		  </table>
		</body>
	  </html>
	  ';
		return $html;
	}
	public function sendOrderPlaceMail($orderDetails, $productDetails, $customerInfo, $cartSummaryAmt)
	{
		$mailContent = $this->generateOrderConfirmMailUi($orderDetails, $productDetails, $customerInfo, $cartSummaryAmt);
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.lotuspens.com',
			'smtp_port' => 465,
			'smtp_crypto' => 'ssl',
			'smtp_user' => 'admin@lotuspens.com',
			'smtp_pass' => 'u3j?4NIltjEP',
			'mailtype' => 'html',
			'validate' => true,
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
		$toEmail = $customerInfo[0]['email_id'];
		$this->email->initialize($config);
		$this->email->from('admin@lotuspens.com', 'Lotus Pens');
		$this->email->to($toEmail);
		$this->email->subject('Your Order Confirmation - Dispatch Coming Soon!');
		$this->email->message($mailContent);

		if ($this->email->send()) {
			return true;
		} else {
			return false;
			// echo $this->email->print_debugger();
		}
	}
}
