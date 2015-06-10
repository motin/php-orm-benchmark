<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Controller_Orm_Doctrine extends Controller
{
    private $em;

    public function setup()
    {
        $entitiesPaths = [__DIR__];
        $isDevMode = false;
        $config = Setup::createAnnotationMetadataConfiguration(
            $entitiesPaths, $isDevMode
        );
        $dbParams = [
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'php_dev',
            'user'      => 'root',
            'password'  => 'root',
            'charset'   => 'utf8',
        ];
        $this->em = EntityManager::create($dbParams, $config);
    }

    public function action_get_one($id = 1)
    {
        $timeStart = microtime(true);
        $memoryStart = memory_get_usage();
        
        $this->setup();
        
        $post = $this->em->getRepository('Blog\Entity\Post')
                ->findOneBy(['id' => $id]);
        
        echo $post->getTitle() . '<br>' . "\n";
        echo $post->getComments()->first()->getBody() . '<br>' . "\n";
        
        echo microtime(true) - $timeStart . " secs<br>\n";
        echo (memory_get_usage() - $memoryStart)/1024 . " KB\n";
    }
}
