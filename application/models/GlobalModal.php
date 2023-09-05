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

	public function deleteData($tableName, $whereData)
	{
		try {
			$this->db->trans_start();
			$this->db->where($tableName);
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

	public function getDataArray($tableName, $selectArray, $whereArray)
	{

		$this->db->select($selectArray);
		$this->db->where($whereArray);
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

	public function genratedIds($tableName, $checkColumn, $idPreFix)
	{
		$return_id = $idPreFix . rand(100, 100000000);
		$this->db->select($checkColumn);
		$this->db->from($tableName);
		$this->db->where($checkColumn, $return_id);
		$this->db->get();
		if ($this->db->affected_rows() > 0) {
			return $this->generate_user_id();
		} else {
			return $return_id;
		}
	}

	public function getDataArrayJoin($tableName, $selectArray, $whereArray, $joinArray)
	{
		$this->db->select($selectArray);
		$this->db->where($whereArray);
		foreach ($joinArray as $index => $tableData) {
			$join_type=$tableData['join_' . $index . '_table_1']['join_type'];
			$table_name_one = $tableData['join_' . $index . '_table_1']['table_name'];
			$table_name_two = $tableData['join_' . $index . '_table_2']['table_name'];
			$table_col_one = $tableData['join_' . $index . '_table_1']['table_column'];
			$table_col_two = $tableData['join_' . $index . '_table_2']['table_column'];
			$this->db->join($table_name_two, $table_name_one . '.' . $table_col_one . '=' . $table_name_two . '.' . $table_col_two,$join_type);
		}
		$data=$this->db->get($tableName)->result_array();
//		echo $this->db->last_query();
		if(count($data)==0){
			return false;
		}else{
			return $data;
		}


	}

}

?>
