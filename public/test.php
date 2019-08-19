<?php
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;
// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);
set_time_limit(0);
/**
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require __DIR__.'/../config/bootstrap.php';
final class HacKernel extends \App\Kernel
{
    /**
     * Recompiles the container without warming up the whole cache.
     *
     * Can be called upon docker container start to inject custom parameters.
     */
    public function exposeContainer()
    {
        // Initialize bundles to be able to parse configurations
        $this->initializeBundles();
        return $this->buildContainer();
    }
}
$input = new ArgvInput();
$env = $input->getParameterOption(['--env', '-e'], getenv('SYMFONY_ENV') ?: 'dev');
$debug = getenv('SYMFONY_DEBUG') !== '0' && !$input->hasParameterOption(['--no-debug', '']) && $env !== 'prod';
if ($debug) {
    Debug::enable();
}
$kernel = new HacKernel($env, $debug);
$container = $kernel->exposeContainer();
$container->compile();
$graphDumper = new \Symfony\Component\DependencyInjection\Dumper\GraphvizDumper($container);
echo $graphDumper->dump();