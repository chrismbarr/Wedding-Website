<?php
	try {
		require 'rsvp_CollectData.php';
		require 'rsvp_ValidateFields.php';
		require 'rsvp_SendEmail.php';
		require 'rsvp_Database.php';

		//Pass in all the request data, and get back only the relevant and trimmed items
		$Collect = new CollectData;
		$data = $Collect->GetData($_REQUEST);
		$isChangeForm = $data["changeForm"];

		//Pass the data into teh validator
		$validator = new ValidateField($data);

		//Build up an array of all the error information by validating each field
		if($isChangeForm){
			$errorArr = array(
				$validator->Name(true),
				$validator->ChangeNotes(),
			);
		}else{
			$errorArr = array(
				$validator->Name(false),
				$validator->Address(),
				$validator->Attendance(),
				$validator->Verification()
			);
		}

		//Create an array of info about the email that will be sent
		$rsvpArr = array(
			"sent" => false,
			"msg" => ""
		);

		if(!$isChangeForm){
			$rsvpArr["saved"]= false;
		}

		//If it's all valid, send an email
		if($validator->allValid){

			if(!$isChangeForm){
				//Save the data to the database as well!
				$DB = new Database;
				$DB->Save($data);

				//Record the status
				$rsvpArr["saved"] = $DB->status;
				$rsvpArr["msg"] = $DB->message;
			}

			//If it's been saved in the database, send an email
			if($isChangeForm || (!$isChangeForm && $DB->status)){
				//New email object takes all of the request data - we will parse it in that class
				$email = new Email($data);
				//Send the email off
				$email->Send();

				//Record the status
				$rsvpArr["sent"] = $email->status;
				$rsvpArr["msg"] = $email->message;
			}
			
		}

		//Make our final JSON object we will return to the browser
		$jsonResult = array(
			"allValid" => $validator->allValid,
			"validation" => $errorArr,
			"rsvp" => $rsvpArr//,
			//"data" => $data
		);

		//Convert the array of objects to a JSON object
		$jsonObject = json_encode($jsonResult, JSON_PRETTY_PRINT);

		//Render out the JSON object
		echo $jsonObject;

	} catch (Exception $e) {
	    echo json_encode(array(
	        'error' => array(
	            'msg' => $e->getMessage(),
	            'code' => $e->getCode(),
	        )));
	}
?>