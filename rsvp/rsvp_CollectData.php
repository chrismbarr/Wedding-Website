<?php

	class CollectData{
		
		private function getValue($dataArray, $requestParam){
			$value = "";
			if(isset($dataArray[$requestParam])) $value = trim($dataArray[$requestParam]);

			return $value;
		}

		public function GetData($requestData){

			$isChangeForm = (isset($requestData["change"]) &&  $requestData["change"] == "true");
			//echo $isChangeForm;

			if($isChangeForm){
				$name = 				$this->getValue($requestData, "change_name");
				$notes = 				$this->getValue($requestData, "change_notes");

				return array(
					"change_name"=>		$name,
					"change_notes"=>	$notes,
					"changeForm"=>		true
				);
			}else{
				$name = 				$this->getValue($requestData, "name");
				$address = 				$this->getValue($requestData, "address");
				$attendanceDetails =	$this->getValue($requestData, "attendance_details");
				$attendance = 			preg_match("/accept/i", $attendanceDetails);
				$plus_one = 			preg_match("/true/i", $this->getValue($requestData, "plus_one"));
				$verification = 		$this->getValue($requestData, "verification");
				$notes = 				$this->getValue($requestData, "notes");

				return array(
					"name"=>				$name,
					"address"=>				$address,
					"attendance_details"=>	$attendanceDetails,
					"attendance"=>			$attendance,
					"plus_one"=>			$plus_one,
					"verification"=>		$verification,
					"notes"=>				$notes,
					"changeForm"=>			false
				);
			}
		}
	}

?>