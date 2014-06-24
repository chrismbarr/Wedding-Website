<?php
	class ValidateField{
		private $data = null;
		public $allValid = true;

		function __construct($dataObject){
			$this->data = $dataObject;
		}

		private function MakeReturnObject($param, $isValid, $msg){
			return array(
				"field" => $param,
				"valid" => $isValid,
				"msg" => $msg
			);
		}
		
		public function Name($isChangeForm){
			$param = $isChangeForm ? "change_name" : "name";
			$value = $this->data[$param];
			$isValid = true;
			$msg = "";

			if($value == ""){
				$isValid = false;
				$msg = "You must provide a name!";
			}elseif (strpos($value," ") <= 0) {
				$isValid = false;
				$msg = "Be sure to include both a first and last name!";
			}elseif (strlen($value) <= 5) {
				$isValid = false;
				$msg = "Is this really your name? it's very short!";
			}

			//Set the master valid flag if this is invalid
			if(!$isValid) $this->allValid = false;

			return $this->MakeReturnObject($param, $isValid, $msg);
		}

		public function Address(){
			$param = "address";
			$value = $this->data[$param];
			$isValid = true;
			$msg = "";

			if($value == ""){
				$isValid = false;
				$msg = "You must provide your mailing address!";
			}elseif (!preg_match("/[0-9]+/", $value)) {
				$isValid = false;
				$msg = "This doesn't look like a correct mailing address!";
			}

			//Set the master valid flag if this is invalid
			if(!$isValid) $this->allValid = false;

			return $this->MakeReturnObject($param, $isValid, $msg);
		}

		public function Attendance(){
			$param = "attendance_details";
			$value = $this->data[$param];
			$isValid = true;
			$msg = "";

			if($value == ""){
				$isValid = false;
				$msg = "You must let us know if you are attending or not!";
			}

			//Set the master valid flag if this is invalid
			if(!$isValid) $this->allValid = false;

			return $this->MakeReturnObject($param, $isValid, $msg);
		}
		
		public function Verification(){
			$param = "verification";
			$value = $this->data[$param];
			$isValid = true;
			$msg = "";

			if($value == ""){
				$isValid = false;
				$msg = "Please check the FRONT of the invitation and enter the FIFTH word from the top!";
			}elseif(!preg_match("/^encouraged$/i", $value)){
				$isValid = false;
				if(preg_match("/^enc/i", $value)){
					$msg = "Check the spelling! This doesn't look right...";
				}else{
					$msg = "This is not the correct verification word!";
				}
			}

			//Set the master valid flag if this is invalid
			if(!$isValid) $this->allValid = false;

			return $this->MakeReturnObject($param, $isValid, $msg);
		}

		public function ChangeNotes(){
			$param = "change_notes";
			$value = $this->data[$param];
			$isValid = true;
			$msg = "";

			if($value == ""){
				$isValid = false;
				$msg = "You need to tell us what changed!";
			}

			//Set the master valid flag if this is invalid
			if(!$isValid) $this->allValid = false;

			return $this->MakeReturnObject($param, $isValid, $msg);
		}
	}
?>