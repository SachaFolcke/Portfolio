<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('pi@192.168.1.69:22')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/home/pi/web/portfolio')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:SachaFolcke/Portfolio.git')
            // the repository branch to deploy
            ->repositoryBranch('master')
            ->composerInstallFlags('--prefer-dist --no-interaction --no-dev')
            ->sharedFilesAndDirs(['public/img/', '.env.local', 'var/log'])
        ;
    }

    // run some local or remote commands before the deployment is started
    public function beforeStartingDeploy()
    {
        // $this->runLocal('./vendor/bin/simple-phpunit');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
        // $this->runRemote('{{ console_bin }} app:my-task-name');
        // $this->runLocal('say "The deployment has finished."');
    }
};
