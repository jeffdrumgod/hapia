<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(FCPATH.'vendors/Doctrine2Codeigniter/autoload.php');

use Doctrine\Common\ClassLoader,
	Doctrine\Common\Cache\ArrayCache,
	Doctrine\Common\Annotations\AnnotationReader,
	Doctrine\Common\Annotations\AnnotationRegistry,
	Doctrine\ORM\Tools\Setup,
	Doctrine\ORM\Configuration,
	Doctrine\ORM\EntityManager,
	Doctrine\ORM\Mapping\Driver\DatabaseDriver,
	Doctrine\ORM\Mapping\Driver\AnnotationDriver,
	Doctrine\ORM\Tools\DisconnectedClassMetadataFactory,
	Doctrine\ORM\Tools\EntityGenerator,
	Doctrine\DBAL\Logging\EchoSQLLogger;

class Doctrine {
	/**
	* @var EntityManager $em
	*/
	public $em = null;

	/**
	* constructor
	*/
	public function __construct()
	{
		// load database configuration from CodeIgniter
		require APPPATH.'config/database.php';

		$doctrineClassLoader = new ClassLoader('Doctrine',  FCPATH.'vendors');
		$doctrineClassLoader->register();
		$symfonyClassLoader = new ClassLoader('Symfony',  FCPATH.'vendors/Doctrine');
		$symfonyClassLoader->register();
		$entityClassLoader = new ClassLoader('Entity', APPPATH.'models');
		$entityClassLoader->register();

		$config = Doctrine\ORM\Tools\Setup::createConfiguration(ENVIRONMENT !== 'production');
		$driverImpl = new AnnotationDriver(new AnnotationReader(), [APPPATH.'models']);
		AnnotationRegistry::registerLoader('class_exists');
		$config->setMetadataDriverImpl($driverImpl);

		// Proxy configuration
		$config->setProxyDir(APPPATH . 'models/Proxies');
		$config->setProxyNamespace('Proxies');


		if(ENVIRONMENT === 'production'){
			// Set up caches
			$cache = new ArrayCache;
			$config->setMetadataCacheImpl($cache);
			$config->setQueryCacheImpl($cache);
		}else {
			// Set up logger
			// $logger = new EchoSQLLogger;
			// $config->setSQLLogger($logger);

			$config->setAutoGenerateProxyClasses( TRUE );
		}

		// Database connection information
		$connectionOptions = array(
			'driver' => $db[$active_group]['dbdriver'],
			// 'driver' => 'pdo_mysql',
			'user' => $db[$active_group]['username'],
			'password' => $db[$active_group]['password'],
			'host' => $db[$active_group]['hostname'],
			'port'  => $db[$active_group]['port'],
			'dbname' => $db[$active_group]['database'],
			'charset' => $db[$active_group]['char_set'],
			'collation' => $db[$active_group]['dbcollat']
		);

		// Create EntityManager
		$this->em = EntityManager::create($connectionOptions, $config);

	}

	/**
	* generate entity objects automatically from mysql db tables
	* @return none
	*/
	// function generate_classes(){
	// 	$driver = new DatabaseDriver(
	// 		$this->em->getConnection()->getSchemaManager()
	// 	);
	// 	$driver->setNamespace('Entities\\');

	// 	$this->em->getConfiguration()
	// 				->setMetadataDriverImpl(
	// 					$driver
	// 				);

	// 	$cmf = new DisconnectedClassMetadataFactory();
	// 	$cmf->setEntityManager($this->em);
	// 	$metadata = $cmf->getAllMetadata();
	// 	$generator = new EntityGenerator();

	// 	$generator->setUpdateEntityIfExists(true);
	// 	$generator->setGenerateStubMethods(true);
	// 	$generator->setGenerateAnnotations(true);
	// 	$generator->generate($metadata, APPPATH."models/");
	// }
}