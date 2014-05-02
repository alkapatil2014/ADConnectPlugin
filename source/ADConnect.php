<?php
/*
 * Handling Active directory authentication Part 
 * This class contain methods for bind and connect to the AD 
 * 
 * 
 */


 class ADConnect
 {
 	
 	private $AD_server;
 	private $AD_User;
 	private $AD_Pass;
 	private $AD_Basedn;
 	private $conn;
 	private $ldapconn;
 	
 	function __construct()
 	{
 		
 		
 		include_once dirname(__FILE__).'/include/config.php';
 		$this->AD_server=$ADParams['AD_IP'];
 		$this->AD_User=$ADParams['AD_user'];
 		$this->AD_password=$ADParams['AD_password'];
 		$this->AD_Basedn=$ADParams['AD_Basedn'];
 		
 	
 		//echo "In construct";
 		
 	} 	

 	/*
 	 * 
 	 * Connect with the AD using application user.
 	 * 
 	*/
 	
 	function connect()
 	{
 		//include_once dirname(__FILE__).'/include/config.php';
 		//Connect to AD
 		
 		$this->ldapconn = ldap_connect($this->AD_server) or die("Could not connect to LDAP server.");
 		/*If successfully connected*/
 		if($this->ldapconn)
 		{
 		
 			ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
 			ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
	        //Binded with AD with the administrative credentials
 			$this->conn = ldap_bind($this->ldapconn, $this->AD_User, $this->AD_password) or die ("Error trying to bind: ".ldap_error($this->ldapconn));
 			
 			
 		}
  	}
 	
 	
 	/*
 	 *  Bind with the AD
 	 */
 	function bind($filter,$user,$password)
 	{
 
 		$this->connect();
 		$ldapbind=false;
 		$dn=null;
 		try {
		 		$read = ldap_search($this->ldapconn,"DC=adfs,DC=anis,DC=com", $filter,array('dn'));// or exit(">>Unable to search ldap server<<");
		 		$info = ldap_get_entries($this->ldapconn, $read);
		 		
		 	    if($info['count']!=0)
		 		$dn=$info[0]['dn'];
		 	  
		 		if($dn!=null)
		 		$ldapbind  = ldap_bind($this->ldapconn,$dn, $password);// or die ("Error trying to bind: ".ldap_error($this->ldapconn));
				else 
				{
					$ldapbind= false;
					return false;
				}
				ldap_close($this->ldapconn);
		 		
		 	    if($ldapbind)
		 	    {
		 	    
		 	    	return true;
		 	    }
		 	    else
		 	    {
		 	      
		 	        
		 	        
		 	    	return false;
		 	    }	
 		}
 		catch(Exception $e)
 		{
 		//	echo "Invalid password";
 			return false;
 		}
 	}
 	
 	
 	/*
 	 * Search for the provided filter
 	 */
 	
 	
 	function search($filter)
 	{
 		
 		$this->connect();
 		
 		$read = ldap_search($this->ldapconn,"DC=adfs,DC=anis,DC=com", $filter,array('dn')) or exit(">>Unable to search ldap server<<");
 		
 		$info = ldap_get_entries($this->ldapconn, $read);
 		print_r($info);
 		
 		
 	
 	}
 	
 	
 	
 	
 	 /*
 	 * Logged In using provided dn and Password
 	 */
 	function checkLogin($attr,$user,$password)
 	{
 		$filter="(|($attr=$user)(sAMAccountName=$user))";
 		
 		if($this->bind($filter,$user,$password)==true)
 		{
 			
 			return true;
 		}
 		else
 			return false;
 		
 		
 	}
 	
 	
 	/*
 	 * Logged In using is exist or not
 	 */
 	function isEmployeeExist($uid)
 	{
 			
 			
 			
 			
 	}
 	/*
 	 * Get USer
 	 */
 	
 	function getUser($gslab_id)
 	{
 		
 		$this->connect();
 		$filter="(uid=$gslab_id)";
 		$read = ldap_search($this->ldapconn,"DC=adfs,DC=anis,DC=com", $filter,array('*')) or exit(">>Unable to search ldap server<<");
 			
 		$info = ldap_get_entries($this->ldapconn, $read);
 		return array('dn'=>$info[0]['dn'],
 					 'cn'=>$info[0]['cn'][0],
 					 'sn'=>$info[0]['sn'][0],
 					 'mail'=>$info[0]['mail'][0]
 		);
 		
 	}
 	
 	
 	
 	
 }