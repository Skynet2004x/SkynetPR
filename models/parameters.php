<?php

class Parameters extends Model{

	public function getConfig() {				 
		$sql = "SELECT * FROM config";
		return $this->db->query($sql);
	}
	
	public function setConfig($data) {
		$adsperpage = $this->db->escape($data['adsperpage']);
		$sitename = $this->db->escape($data['sitename']);
		$sendemail = $this->db->escape($data['sendemail']);		
		$sql = "UPDATE config
				set adsperpage = '{$adsperpage}',
					sitename = '{$sitename}',
					sendemail  = '{$sendemail}'					
				WHERE id = 0";
		return $this->db->query($sql);
	}	

}
