<?php
	
	class Email{

		//Public vars
		public $status = false;
		public $message = "The RSVP could not be made, please try again later!";

		private $data = null;

		function __construct($dataObject){
			$this->data = $dataObject;
		}
		//=======================================================

		private function BooleanToHtml($dataParam){
			$boolHtml="";
			if($this->data[$dataParam]){
				$boolHtml = "<strong style='color:green;'>YES!</strong>";
			}else{
				$boolHtml = "<strong style='color:red;'>NO :(</strong>";
			}

			return $boolHtml;
		}

		private function getRsvpEmailBody(){
			$html="<html><body>";
			$html.="<h2>Someone has filled out an RSVP form on chrisandkirstin.com - yay!</h2>";
			$html.="<ul>";
			$html.="  <li><strong>Attendance:</strong> " . $this->BooleanToHtml("attendance") . " (" . $this->data["attendance_details"] . ")</li>";
			$html.="  <li><strong>Name:</strong> " . $this->data["name"] . "</li>";
			$html.="  <li><strong>Address:</strong>  <br/>" . nl2br($this->data["address"]) . "</li>";
			if($this->data["attendance"]){
				$html.="  <li><strong>Plus One:</strong> " . $this->BooleanToHtml("plus_one") . "</li>";
			}

			$notes = $this->data["notes"];
			if($notes !==""){
				$html.="  <li><strong>Notes:</strong>  <br/>" . nl2br($notes) . "</li>";
			}
			$html.="</ul><hr />View all RSVP entries to date at: <a href='http://chrisandkirstin.com/results'>http://chrisandkirstin.com/results</a>";
			$html.="<body></html>";

			return $html;
		}

		private function getChangeEmailBody(){
			$html="<html><body>";
			$html.="<h2>Someone has requested a CHANGE to their RSVP information on chrisandkirstin.com!</h2>";
			$html.="<ul>";
			$html.="  <li><strong>Name:</strong> " . $this->data["change_name"] . "</li>";
			$html.="  <li><strong>What changed:</strong> <br/>" . nl2br($this->data["change_notes"]) . "</li>";
			$html.="</ul>";
			$html.="<body></html>";

			return $html;
		}
		
		public function Send(){
			$isChangeForm = $this->data["changeForm"];

			$to = 'Person 1 <example1@gmail.com>, Person 2 <example2@yahoo.com>';

			if($isChangeForm){
				$subject = 'Wedding RSVP - Change request!';
			}else{
				$subject = 'Wedding RSVP - '.($this->data["attendance"] ? 'YES': 'NO').$this->data["name"];
			}
			
			$body = $isChangeForm ? $this->getChangeEmailBody() : $this->getRsvpEmailBody();

			$headers = "From: RSVP Mailer<RSVP@chrisandkirstin.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			//Send it!
			$mailSent = mail($to, $subject, $body, $headers);
			//echo $body;

			if($mailSent){
				$this->status = true;
				$this->message = ""; //No message needed
			}else{
				$this->status = false;
				$this->message = "The RSVP could not be made, please try again later!";
			}
		}

	}

?>