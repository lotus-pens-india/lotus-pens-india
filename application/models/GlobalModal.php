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
}
