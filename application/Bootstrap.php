<?php

require_once 'Zend/Loader/Autoloader.php';
//require_once 'Zend/Loader.php';

class Bootstrap
{

    public static $frontController = null;

    public static $root = '';

    public static $registry = null;
	
	public static $front = null;

    public static function run()
    {
        self::prepare();
        $response = self::$frontController->dispatch();
        self::sendResponse($response);
    }

    public static function prepare()
    {
        self::setupEnvironment();
        //Zend_Loader::registerAutoload();
		
		Zend_Loader_Autoloader::getInstance()
			->setFallbackAutoloader(true);
        
        self::setupRegistry();
        self::setupConfiguration();
        self::setupFrontController();
        self::setupView();
        self::setupDatabase();
        self::setupCache();
       	self::setupAcl();
		self::setupTranslate();
		self::setupMail();
    }
	
	public static function setupEnvironment()
    {
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', true);
        date_default_timezone_set('Singapore');
        self::$root = dirname(dirname(__FILE__));
    }
	
	public static function setupFrontController()
    {
		self::$frontController = Zend_Controller_Front::getInstance();
        self::$frontController->addModuleDirectory(self::$root . '/application/modules');
		self::$frontController->setBaseUrl('/development/eAduan');   
		self::$frontController->registerPlugin(new TimeoutPatch());
		self::$frontController->throwExceptions(true);
        self::$frontController->returnResponse(true);
		
        // Add custom routes for detection and mapping
        $router = self::$frontController->getRouter();
		
        $router->addRoutes(self::_assembleRoutes());
        self::$frontController->setParam('registry', self::$registry);
		
		define('SYSTEM_CODE', 'JHEV');
		define('SYSTEM_SESSION', 'JHEV_SESSION');
		define('SYSTEM_HOST', 'http://127.0.0.1:88');
		define('SYSTEM_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
		define('SYSTEM_PATH', self::$root);
		define('DOCUMENT_PATH', './');
		define('IMAGES_PATH', SYSTEM_URL.'/public/images/');
		define('IMAGES_PATH2', DOCUMENT_PATH.'public/images/');
		define('CSS_PATH', SYSTEM_URL.'/public/css/');
		define('JS_PATH', SYSTEM_URL.'/public/js/');
		define('DB_PATH', DOCUMENT_PATH.'data/db_backups/');
		define('DB_URL', SYSTEM_URL.'/data/db_backups/');
		define('EDITOR_PATH', SYSTEM_URL.'/public/fckeditor/');
		define('UPLOAD_PATH', SYSTEM_PATH.'/data/upload/');
		define('UPLOAD_URL', SYSTEM_URL.'/data/upload/');
		
		define('SYSTEM_ORGANIZATION', 'Jabatan Hal Ehwal Veteran ATM');
		define('SYSTEM_NAME', 'Sistem Aduan JHEV - eAduan');
		
		/************** Session *******************/
		$defSession = new Zend_Session_Namespace(SYSTEM_SESSION, true);
		Zend_Registry::set('defSession', $defSession);
		
		$roleSession = new Zend_Session_Namespace('role', true);
		Zend_Registry::set('roleSession', $roleSession);
		
    }

    public static function setupView()
    {
        $defSession = Zend_Registry::get('defSession');
		//$breadcrumbs = new My_Breadcrumb;
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();
        $viewRenderer->view->doctype('XHTML1_STRICT');
        $viewRenderer->view->setEncoding('UTF-8');
        $viewRenderer->view->addHelperPath(
            self::$root . '/application/views/helpers',
            'ZFBlog_View_Helper_'
        );
		
        Zend_Layout::startMvc(
            array(
                'layoutPath' => self::$root . '/application/layouts',
                'layout' => 'adminx3'
            )
        );
        $view = new Zend_View;
		
		$viewRenderer->view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
        
    }

    public static function sendResponse(Zend_Controller_Response_Http $response)
    {
        $response->sendResponse();
    }

    public static function setupRegistry()
    {
        self::$registry = new Zend_Registry(array(), ArrayObject::ARRAY_AS_PROPS);
        Zend_Registry::setInstance(self::$registry);
    }

    public static function setupConfiguration()
    {
        $config = new Zend_Config_Ini(
            self::$root . '/config/config.ini',
            'general'
        );
        self::$registry->configuration = $config;
        
    }

    public static function setupDatabase()
    {
        $config = self::$registry->configuration;
        $db = Zend_Db::factory($config->db->adapter, $config->db->toArray());
        $db->query("SET NAMES 'utf8'");
        self::$registry->database = $db;
        Zend_Db_Table::setDefaultAdapter($db);
        Zend_Registry::set ( 'db', $db );
		
		$db2 = Zend_Db::factory($config->db2->adapter, $config->db2->toArray());
		Zend_Registry::set ( 'db2', $db2 );
    }
    
    public static function setupCache()
    {
    	$frontendOptions = array('lifetime' => 7200,'automatic_serialization' => true);
		$backendOptions = array('cache_dir' => self::$root . '/data/cache/');
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		Zend_Registry::set('cache',$cache);
    }

    public static function setupAcl()
    {
        
    	$auth = Zend_Auth::getInstance();
		$auth->setStorage(new Zend_Auth_Storage_Session(SYSTEM_CODE));
		
        $acl = new My_Acl($auth);
        self::$frontController->setParam('auth', $auth);
        self::$frontController->setParam('acl', $acl);
   		self::$frontController->registerPlugin(
            new My_Controller_Plugin_Auth($auth, $acl)
        );
    }

	protected static function _assembleRoutes()
    {
        $routes = array();
		/*
        $routes['entry']  = new Zend_Controller_Router_Route_Regex(
            '[0-9a-z\._!;,\+\-%]+-(\d+)', // all possible single entry URLs
            array(
                'module' => 'default',
                'controller' => 'index',
                'action'     => 'index'
            ),
            array(
                'id' => 1 // maps first subpattern "(\d+)" to "id" parameter
            )
        );
		*/
		$routes = new Zend_Controller_Router_Route(
			':language/:controller/:action/*',
				array(
					'language'   => 'en',
					'module'	 => 'default',
					'controller' => 'index',
					'action'	 => 'index'
				)
			);

        return $routes;
    }
	
	public static function setupTranslate()
    {
		$defSession = Zend_Registry::get('defSession');
		 
		$lang = 'ms';
		if (isset($defSession->lang))
		{
			$lang = $defSession->lang;
		}
		//echo $lang;
		$translate = new Zend_Translate('csv', SYSTEM_PATH.'/languages/'.$lang.'.csv', $lang, array('delimiter' => ','));
		Zend_Registry::set('translate', $translate);
	}
	
	public static function setupMail()
    {
		/* $config = array('auth' => 'login',
                'username' => 'yusri@unijaya.com',
                'password' => 'yusri');

		$tr = new Zend_Mail_Transport_Smtp('mail.unijaya.com', $config);
		Zend_Mail::setDefaultTransport($tr); */
		
		$config = array('auth' => 'login',
                'username' => 'jhevians@gmail.com',
                'password' => 'jhev2010',
				'port' => '587',
				'ssl' => 'tls'
				);

		$tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
		Zend_Mail::setDefaultTransport($tr); 
		
		// $config = array('auth' => 'login',
                // 'username' => 'linkslay',
                // 'password' => 'numbnut001'
				// );

		// $tr = new Zend_Mail_Transport_Smtp('mail.linkslay.com', $config);
		// Zend_Mail::setDefaultTransport($tr);
		
		/* $config = array('auth' => 'login',
                'username' => 'seepotsodot',
                'password' => '841208',
				'port' => '465',
				'ssl' => 'tls'
				);

		$tr = new Zend_Mail_Transport_Smtp('smtp.mail.yahoo.com', $config);
		Zend_Mail::setDefaultTransport($tr); */
	}
}
