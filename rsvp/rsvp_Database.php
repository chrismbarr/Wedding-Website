<?php
	class Database{

		private $connection = null;
		private $db_name = "RSVP";

		//Public vars
		public $status = false;
		public $message = "The RSVP could not be made, please try again later!";
		
		function __construct(){
			$whitelist = array('127.0.0.1', '::1', 'localhost');
			if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
				$db_user = "root";
				$db_pass = "root";
				$db_server = "localhost";
				$db_database = "db-name";
			}else{
				$db_user = "LOLOLOLOL";
				$db_pass = "LOLOLOLOL";
				$db_server = "localhost";
				$db_database = "db-name";
			}
			
			$this->connection = new mysqli($db_server, $db_user, $db_pass, $db_database);

			if ($this->connection->connect_errno) {
				echo "Failed to connect to MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error;
			}
		}

		public function Save($data){
			//Write out some vars to avoid too many quoted strings in the SQL query
			$ip = $_SERVER['REMOTE_ADDR'];
			if($ip=="::1") $ip="localhost";

			$name = $this->connection->real_escape_string($data['name']);
			$address = $this->connection->real_escape_string($data['address']);
			$attendance_details = $this->connection->real_escape_string($data['attendance_details']);
			$attendance = $this->connection->real_escape_string($data['attendance']);
			$plus_one = $this->connection->real_escape_string($data['plus_one']);
			$notes = $this->connection->real_escape_string($data['notes']);


			//Look for items in DB that match exactly
			$getQuery = "SELECT * FROM $this->db_name WHERE 
				ipaddress=			'$ip' AND
				name=				'$name' AND
				address=			'$address' AND
				attendance_details=	'$attendance_details' AND
				attendance=			'$attendance' AND
				plus_one=			'$plus_one' AND
				notes=				'$notes'
			";
			$getResults = mysqli_query($this->connection, $getQuery);

			if($getResults->num_rows == 0){
				//If we have no matches, then proceed.
				$query = "INSERT INTO $this->db_name SET 
					date=				now(),
					ipaddress=			'$ip',
					name=				'$name',
					address=			'$address',
					attendance_details=	'$attendance_details',
					attendance=			'$attendance',
					plus_one=			'$plus_one',
					notes=				'$notes'
				";

				//Prevent MYSQL injection
				$stmt = $this->connection->prepare($query);
				//Run the query
				$stmt->execute();

				//Make sure one row was affected
				$result = $stmt->affected_rows == 1;

				//Update the status
				$this->status = $result;
				if($result) $this->message = "";
			}else{
				$this->message = "It looks like you have already RSVP'd previously!";
			}

			//Close the database connection
			mysqli_close($this->connection);
		}

		public function GetResults(){
			$query = "SELECT * FROM $this->db_name ORDER BY id DESC";
			$results = mysqli_query($this->connection, $query);
			
			//Close the database connection
			mysqli_close($this->connection);

			return $results;
		}
	}
?>