<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
	public function authenticate(){
		$criteria = new CDbCriteria;
        $criteria->select = 'password,person_id';        
        $userFromDb=  Person::model()->findByAttributes(array('username'=>$this->username),$criteria);
        if(!is_object($userFromDb) && !isset($userFromDb->username)){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else{
            if(!password_verify($this->password, $userFromDb->password)){
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else{
            	$this->_id= $userFromDb->person_id;
                
                $this->errorCode=self::ERROR_NONE;
                // $modelPerson=  Person::model()->findByPk($userFromDb->id_person);
                // $modelRole=  Role::model()->findByPk($userFromDb->id_role);
                // Yii::app()->user->setState('nombrePerson',$modelPerson->person_name." ".$modelPerson->person_lastname);
                // Yii::app()->user->setState('nombreUsuario',$this->username);
                // Yii::app()->user->setState('nombreRole',$modelRole->role_name);
            }
        }               
        return !$this->errorCode;
	}
	public function getId(){
		return $this->_id;
	}
}