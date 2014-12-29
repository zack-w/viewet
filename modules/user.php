<?php

	if( !defined( "IN_VIEWIT" ) )
	{
		die("Access deined!");
	}

	class User {
	
		static $hashPassword, $generateCookieStr, $getCookieInfo, $getUserInfo;
		
		private $boolAuthed = false;
		private $queryTable = null;
		private $showMessage = null;
		
		public function getMessage()
		{
			return $this->showMessage;
		}
		
		public function voteForVideo( $videoid, $like )
		{
			global $DB;
			
			$VID = $DB->escape( $videoid );
			$Like = $DB->escape( $like );
			$Plus = ($Like == "1")?("+ 1"):("- 1");
			
			$DB->query("INSERT INTO votes (`UserID`,`VideoID`,`Type`)VALUES(".($this->getUserID()).", ".$VID.", ".$Like.");");
			$DB->query("UPDATE videos SET Rating = Rating ".$Plus." WHERE ID = ".$VID.";");
		}
		
		public function setMessage($msg, $type = 1, $link = "")
		{
			$this->showMessage = array($type, $msg, $link);
		}
		
		public function isGuest()
		{
			return ($this->boolAuthed)?(0):(1);
		}
		
		public function getData( $key )
		{
			return $this->queryTable[ $key ];
		}
		
		public function getUserID()
		{
			return $this->queryTable[0];
		}
		
		public function logoutUser()
		{
			setcookie( "VIEWET_USER", "", time()-3600 );
			
			$this->boolAuthed = false;
			$this->queryTable = null;
		}
		
		private function cookieAuth( $cookieStr )
		{
			$UserInf = User::getCookieInfo( $cookieStr );
			
			if( $UserInf == 0 )
			{
				$this->showMessage = array(1, "Unable to automaticlly log you in..", "?area=login");
				
				return false;
			}else{
				$this->queryTable = $UserInf;
				$this->boolAuthed = true;
			}
			
			return true;
		}
		
		public function loginUser($username, $unhashed_password = "NA")
		{
			if( $unhashed_password == "NA" ){ $this->cookieAuth( $username ); return; }
			
			global $DB;
		
			$password = User::hashPassword( $username, $unhashed_password );
			
			$password = $DB->escape( $password );
			$username = $DB->escape( $username );
			
			$queryRes = $DB->query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."';");
			$queryTbl = $DB->get_arr( $queryRes );
			
			if( $DB->row_cnt( $queryRes ) > 0 )
			{
				$this->queryTable = $queryTbl;
				$this->boolAuthed = true;
				
				$cookieStr = User::generateCookieStr();
				$userID = $this->getUserID();
				
				$DB->query("UPDATE users SET CookieStr = '".$cookieStr."' WHERE ID = ".($userID).";");
				setcookie( "VIEWET_USER", $cookieStr );
				
				return true;
			}else{
				return false;
			}
		}
		
		public function checkCookieAuth()
		{
			$cookieStr = $_COOKIE["VIEWET_USER"];
			
			if( !empty( $cookieStr ) ){ $this->loginUser($cookieStr); }
		}
		
		public function registerUser($username, $password)
		{
			global $DB, $User;
			
			$IP = $DB->escape( $_SERVER['REMOTE_ADDR'] );
			$hashed_password = User::hashPassword($username, $password);
			
			$username = $DB->escape( $username );
			$hashed_password = $DB->escape( $hashed_password );
			
			$DB->query("INSERT INTO users (`username`,`password`,`IP`,`DateRegistered`,`LastActive`)VALUES('".$username."', '".$hashed_password."', '".$IP."', ".time().", ".time().");");
			$User->loginUser($username, $password);
		}
		
		public function updateEmail( $email )
		{
			global $DB;
			
			$DB->query("UPDATE users SET email = '".$email."' WHERE ID = ". ($this->getUserID()) .";");
		}
		
		public function updatePassword( $password )
		{
			global $DB;
			
			$Hashed = User::hashPassword( $this->getData( "username" ), $password );
			$DB->query("UPDATE users SET password = '". ($Hashed) ."' WHERE ID = ". ($this->getUserID()) .";");
		}
		
		public function isAdmin()
		{
			$info = $this->getData("Usergroup");
			return ( $info == "2" );
		}
		
		///////////////////////////////////////
		// Begin of static functions //////////
		///////////////////////////////////////
		
		public static function hashPassword($user, $pass)
		{
			return md5( $pass . "!^_^!" . $user );
		}
		
		private static function generateCookieStr()
		{
			$key = md5( rand() ) . md5( rand() );
			
			return $key;
		}
		
		private static function getCookieInfo( $cookieStr = "" )
		{
			global $DB;
			
			$cookieStr = $DB->escape($cookieStr);
			
			$queryRes = $DB->query("SELECT * FROM users WHERE CookieStr = '".$cookieStr."';");
			$numRows = $DB->row_cnt( $queryRes );
			
			if( $numRows == 1 ){
				$queryTable = $DB->get_arr( $queryRes );
				return $queryTable;
			}elseif( $numRows > 1 ){
				$DB->query("UPDATE users SET CookieStr = 'NA' WHERE CookieStr = '".$cookieStr."';");
			}
			
			return -1;
		}
		
		public static function getUserInfo( $Username )
		{
			global $DB;
			
			$query = $DB->query("SELECT * FROM users WHERE username = '".$Username."';");
			$query = $DB->get_arr( $query );
			
			return $query;
		}
		
	}

?>