<?php

class loginService
{

    private $params;
    private $error;
    private $user;

    /*** GETTERS ET SETTERS **/

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }





    public function launchControls(){
        //$this->params['username'] represente ici un $_POST['username']
        if(empty($this->params['username'])){
            $this->error['username'] = 'Nom utilisateur manquant';
        }

        if(empty($this->params['password'])){
            $this->error['password'] = 'Mot de passe manquant';
        }
        if(empty($this->error)==false){
            return $this->error;
        }
        $this->user = $this->checkUsernamePassword();
        if(empty($this->user)){
            $this->error['identifiants'] = 'Le nom d\'utilisateur ou mot de passe incorrect';
            return $this->error;
        }else{
            return $this->user;
        }
    }


    /***
     * Il est évident que cette fonction ne va pas ici!!!!
     */
    public function checkUsernamePassword(){

        $username = $this->params['username'];
        $password = $this->params['password'];

        $connexion = new PDO('mysql:host=localhost;dbname=blog;charset=UTF8','root','');
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $object = $connexion->prepare('SELECT id,username FROM user WHERE username=:username AND password=:password');
        $object->execute(array(
            'password'=>md5($password),
            'username'=>$username
        ));
        $user = $object->fetchAll(PDO::FETCH_ASSOC);

        if(empty($user)==false){
            return $user;
        }
        return false;
    }


}