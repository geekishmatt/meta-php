# meta-php

## usage


```php
class User {
 
 use Meta;

 private $username;
 private $email;
 private $password;
 
 public function setUsername($username) {
  $this->username = (string)$username;
  return $this;
 }
 
 public function getUsername() {
  return $this->username;
 }
 
 public function setEmail($email) {
  $this->email = (string)$email;
  return $this;
 }
 
 public function getEmail() {
  return $this->email;
 }
 
 public function setPassword($password) {
  $this->password = (string)md5($password);
  return $this;
 }
 
 public function getPassword() {
  return $this->password;
 }
}
```

```php
$user = new User();
$user->setUsername('geekishmatt')->setEmail('geekishmatt@drunkencoder.de')->setPassword('test123');

$user->addAttribute('tableName');

$user->tableName = 'users';

$user->addMethod('save', function($self){
 $sql = 'INSERT INTO ' . $self->tableName . ' (';
 $values = 'VALUES (';
 
 $getMethods = preg_grep('(^get(.*?)$)', get_class_methods(get_class($self)));
 
 foreach($getMethods as $method) {
  $sql .= '\''.strtolower(substr($method,3)).'\''.',';
  $values .= '\''.$self->$method().'\''.',';
 };
 
 $statement = substr($sql,0,strlen($sql)-1).') '.substr($values,0,strlen($values)-1).');';

 return $statement;
});


// Output: INSERT INTO users ('username','email','password') VALUES ('geekishmatt','geekishmatt@drunkencoder.de','cc03e747a6afbbcbf8be7668acfebee5');
echo $user->save();
