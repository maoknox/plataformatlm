<?php

class SiteController extends Controller{
     /**
    * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
    * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
    */
    public function filterEnforcelogin($filterChain){
        if(Yii::app()->user->isGuest){
            if(isset($_POST) && !empty($_POST)){
                $response["status"]="nosession";
                echo CJSON::encode($response);
                exit();
            }
            else{
                Yii::app()->user->returnUrl = array("site/login");                                                          
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        else{
            if(!isset($_POST)){
                Yii::app()->user->returnUrl = array("site/index");          
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $filterChain->run();
    }
    /**
     * @return array action filters
     */
    public function filters(){
        return array(
                'enforcelogin -login -logout -contact ',                      
        );
    }
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex(){
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
            $userRole=Euser::getRole();
            $userId=Yii::app()->user->getId();            
            $entityUser= EntityUser::model()->findByAttributes(array("euser_id"=>$userId));
            if($userRole->role_name=='super_usuario'){
                $serviceEntity= ServiceEntity::model()->findAllByAttributes(array("entity_id"=>$entityUser->entity_id));
                $this->render('index',array("userRole"=>$userRole,'entityUser'=>$entityUser,"serviceEntity"=>$serviceEntity));
            }
            elseif($userRole->role_name=='usuario_cliente'){
                $servicesEntity= ServiceEntity::model()->findAllByAttributes(array("entity_id"=>$entityUser->entity_id));
                $this->render('index_services',array("userRole"=>$userRole,'entityUser'=>$entityUser,"servicesEntity"=>$servicesEntity));
            }
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
                            Yii::app()->user->returnUrl = array("site/index");                                                          
                            $this->redirect(Yii::app()->user->returnUrl);
		}
//		 display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        public function actionRemoveAnchorage(){
            $response=array();
            $response["status"]="success";
            $response["msg"]="Elemento removido con éxito";
            $viewName=Yii::app()->request->getPost("anchorName");
            $modelAnchorage= Anchorage::model()->findByAttributes(array("anchorage_name"=>$viewName));
            if(!$modelAnchorage){
                $response["status"]="warning";
                $response["msg"]="El elemento no existe, no puede ser removido";
            }
            else{
                if(!$modelAnchorage->delete()){
                    $response["status"]="danger";
                    $response["msg"]="El elemento no fue removido";
                }
            }
            echo json_encode($response);
        }
        
        public function actionAnchorageAtStart(){
            $response=array();
            $response["status"]="success";
            $response["msg"]="Elemento anclado al inicio";
            $controllerName=Yii::app()->request->getPost("controllerName");
            $viewName=Yii::app()->request->getPost("viewName");
            $nameAnchor=Yii::app()->request->getPost("nameAnchor");
            $serviceEntityId=Yii::app()->request->getPost("serviceEntityId");
            $params=Yii::app()->request->getPost("params");
            $modelAnchorage= Anchorage::model()->findByAttributes(array("service_entity_id"=>$serviceEntityId,"anchorage_name"=>$nameAnchor));
            if($modelAnchorage){
                $response["status"]="warning";
                $response["msg"]="El elemento ya había sido anclado al inicio";
            }
            else{
                $newModelAnchorage=new Anchorage();
                $newModelAnchorage->service_entity_id=$serviceEntityId;
                $newModelAnchorage->anchorage_controller=$controllerName;
                $newModelAnchorage->anchorage_view=$viewName;
                $newModelAnchorage->anchorage_params= json_encode($params);
                $newModelAnchorage->anchorage_name=$nameAnchor;
                if(!$newModelAnchorage->save()){
                    $response["status"]="danger";
                    $response["msg"]="No se ha podido anclar el elemento";
                }
            }
            echo json_encode($response);
        }
        
       
}