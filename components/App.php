<?php

class App
{
    public function run()
	{
        $db = Database::getConnection();
		
		$result = $db->query('SELECT * FROM machines as t1 JOIN machines_options as t2 ON t1.id = t2.machine_id  ORDER BY t1.id DESC');
		
		$i = 0;
        while ($row = $result->fetch()) {
            $machinesList[$i]['id'] = $row['id'];
            $machinesList[$i]['serial'] = $row['serial'];
            $machinesList[$i]['firmware'] = $row['firmware'];
            $machinesList[$i]['connect_freq'] = $row['connect_freq'];
            $i++;
        }
		
		echo '<pre>';
		
		var_dump($machinesList);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'http://b2brocker-test/server.php');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($machinesList[0]));
			$out = curl_exec($curl);
			echo $out;
			curl_close($curl);
		
		
    }
}
