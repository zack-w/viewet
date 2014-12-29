<?php	if( !defined( "IN_VIEWIT" ) )	{		die("Access deined!");	}
	class db {
	
		private $conn = null;
		private $error = 0;
		private $DatabaseInfo = array(
			"Host" 			=> "",
			"User" 			=> "",
			"Password" 		=> "",
			"Database" 		=> "",
		);	
		
		function db()
		{
			$this->conn = @mysql_connect($this->DatabaseInfo["Host"], $this->DatabaseInfo["User"], $this->DatabaseInfo["Password"]);
			
			if( !$this->conn )
			{
				$this->error = 1;
			}else{				mysql_select_db( $this->DatabaseInfo["Database"] );			}
		}
	
		public function wasError() { return $this->error; }
		public function query( $str ) { return mysql_query( $str ); }
		public function get_arr( $query ) { return mysql_fetch_array( $query ); }
		public function escape( $str ) { return mysql_real_escape_string( $str ); }
		public function row_cnt( $query ) { return @mysql_num_rows( $query ); }		public function num_rows( $query ) { return $this->row_cnt( $query ); }		public function last_id() { return mysql_insert_id(); }
	
	}
?>