<?php

namespace Geekhub\AssetsBundle\Command;

use Symfony\Bundle\AsseticBundle\Command\DumpCommand as BaseDumpCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends BaseDumpCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $copyDirs = array('img', 'fonts');

        //get dir with image files
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $assetsDir = $rootDir . '/Resources/public/';
        $webDir = $rootDir . '/../web/';

        foreach ($copyDirs as $dir) {
            if (file_exists($assetsDir . $dir)) {
                $this->createDirIfNotExist($webDir . $dir, $output);
                $this->recurseCopyFiles($assetsDir . $dir, $webDir . $dir, $output);
            }
        }

        parent::execute($input, $output);
    }

    private function createDirIfNotExist($dir, $output)
    {
        if (!file_exists($dir)) {
            $output->writeln(sprintf(
                '<comment>%s</comment> <info>[dir+]</info> %s',
                date('H:i:s'),
                $dir
            ));
            if (false === @mkdir($dir, 0777, true)) {
                throw new \RuntimeException('Unable to create directory '.$dir);
            }
        }
    }

    private function recurseCopyFiles($src, $dst, $output) {
        $srcDir = opendir($src);
        while(false !== ( $file = readdir($srcDir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurseCopyFiles($src . '/' . $file, $dst . '/' . $file, $output);
                }
                else {
                    $output->writeln(sprintf(
                        '<comment>%s</comment> <info>[file+]</info> %s',
                        date('H:i:s'),
                        $dst . '/' . $file
                    ));
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($srcDir);
    }
}