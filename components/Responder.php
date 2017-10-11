<?php

class Responder 
{
	public function validate($request) 
	{
		if(isset($request['serial']) && isset($request['time'])){
			if(strlen($request['serial']) < 15)
				return false;
		} else 
			return false;
	}
	
	public function receive($request)
	{
		$db = Database::getConnection();
		
		if(!$this->validate($request))
			return false;
		
		$sql = 'SELECT * FROM machines_options_set WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $request['id'], PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $result = $result->fetch();
		
		if(count($result>0)){
			$sql = 'UPDATE machines_options SET `connect_freq`=:freq WHERE `machine_id`=:id';
		
			$result = $db->prepare($sql);
			$result->bindValue(':freq', $request['sets']['connect_freq'], PDO::PARAM_STR);
			$result->bindValue(':id', $request['id'], PDO::PARAM_INT);
			
			if ($result->execute()) {
				$this->deleteSets($request['id']);
				return $db->lastInsertId();
			} 
			return 0;
        
		}
			
		if($request['sets'])
			$this->setParametes($request);
		else
			return true;
	}
	
	public function deleteSets($id)
	{
		$sql = 'DELETE FROM machines_options WHERE`machine_id`=:id';
		
		$result = $db->prepare($sql);
		$result->bindValue(':id', $request['id'], PDO::PARAM_INT);
		$result->execute();
	}
	
	public function setParametes($request)
	{
		$db = Database::getConnection();
		$sql = 'UPDATE `machines_options_set` SET `connect_freq`=:freq WHERE `machine_id`=:id';
		$result = $db->prepare($sql);
		$result->bindValue(':freq', $request['sets']['connect_freq'], PDO::PARAM_STR);
		$result->bindValue(':id', $request['id'], PDO::PARAM_INT);
		
		if ($result->execute()) {
           return $db->lastInsertId();
        } 
         return 0;
	}
	
	public function response($response)
	{
		echo $response;
		$db = Database::getConnection();
		return 1;
	}
	
}