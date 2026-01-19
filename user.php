<?php 
class User{
    private ?int $userid;
    private string $name;
    private string $lastname;
    private string $tel;
    private ?string $username;
    private ?string $password;

    public function __construct(?int $userid, string $name, string $lastname, string $tel, ?string $username, ?string $password)
    {
        $this->userid = $userid;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->tel = $tel;
        $this->username = $username;
        $this->password = $password;
    }
    public function getUserId()
    {
        return $this->userid;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getLastName()
    {
        return $this->lastname;
    }
    public function getTel()
    {
        return $this->tel;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
   public function setName($name){
       $this->name=$name;

   }
    public function setLastName($lastname){
         $this->lastname=$lastname;
    
    }
    public function setTel($tel){
         $this->tel=$tel;
    
    }
    public function setUsername($username){
         $this->username=$username;
    
    }
    public function setPassword($password){
         $this->password=$password;
    
    }
    


}


?>