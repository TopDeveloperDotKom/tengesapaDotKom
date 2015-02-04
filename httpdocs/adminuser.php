<?php
error_reporting(E_ALL | E_STRICT);
$mageFilename = 'app/Mage.php';
require_once $mageFilename;
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
 
umask(0);
Mage::app('default');//if you changed the code for the default store view change it here also
Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
$username = 'admin';//desired username
$firstname = "Ngoda";//desired firstname
$lastname = "Nehoreka";//desired lastname
$email = "chamboko@chibamu.org";//desired email
$pass = 'password123123';//desired password
$user = Mage::getModel('admin/user')->load($username, 'username');
if ($user->getId()){
 echo "User {$username} already exists";
 exit;
}
$user->setUsername($username)
  ->setFirstname($firstname)
  ->setLastname($lastname)
  ->setEmail($email)
  ->setPassword($pass)
  ;
$result = $user->validate();
if (is_array($result)){
 foreach ($result as $res){
  echo $res."\n";
 }
 exit;
}
try{
 $user->setForceNewPassword(true);
 $user->save();
 $user->setRoleIds(array(1))->saveRelations();
 echo "User {$username} was created";
 exit;
}
catch (Exception $e){
 echo $e->getMessage();
}