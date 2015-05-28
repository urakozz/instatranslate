<?php namespace App\Console\Commands;

use Aws\Common\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Illuminate\Console\Command;
use League\Flysystem\AwsS3v2\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class AssetsS3Publish extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'assets:s3publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $client = S3Client::factory([
            'key' => env('AWS_CLIENT_ID'),
            'secret' => env('AWS_CLIENT_SECRET'),
            'region' => env("AWS_REGION")
        ]);

        $this->filesystem = new Filesystem(new AwsS3Adapter($client, env('AWS_S3_BUCKET')));
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ("rollout" === $this->argument('rollout')) {
            return $this->rollout();
        }
        $this->upload();
    }

    protected function upload()
    {
        $fileNameLocal = $this->getManifestLocalPath();
        $fileNameS3    = $this->getManifestS3Path();
        $this->filesystem->has($fileNameS3) && $this->filesystem->delete($fileNameS3);
        $json = file_get_contents($fileNameLocal);
        $this->filesystem->write($fileNameS3, $json);

        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                dirname($fileNameLocal),
                \FilesystemIterator::SKIP_DOTS |
                \FilesystemIterator::CURRENT_AS_FILEINFO |
                \FilesystemIterator::KEY_AS_PATHNAME
            )
        );
        foreach ($it as $filePath => $fileInfo) {
            if (!$it->getDepth()) {
                continue;
            }

            $s3path = "assets/build" . mb_substr($fileInfo->getPathname(), mb_strlen(dirname($fileNameLocal)));

            if (!$this->filesystem->has($s3path)) {
                $this->filesystem->writeStream($s3path, fopen($fileInfo->getPathname(), 'r'), ['ACL' => 'public-read']);
            }
        }
        return true;
    }

    protected function rollout()
    {
        $fileNameS3 = $this->getManifestS3Path();
        $manifest   = $this->filesystem->read($fileNameS3);
        file_put_contents($this->getManifestLocalPath(), $manifest);

        return true;
    }

    protected function getManifestLocalPath()
    {
        return public_path() . "/build/rev-manifest.json";
    }

    protected function getManifestS3Path()
    {
        return implode("/", [
            "configs",
            $this->option('branch'),
            $this->option('commit'),
            "rev-manifest.json"
        ]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['rollout', InputArgument::OPTIONAL, 'Flag means you are performing roll out'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['branch', null, InputOption::VALUE_OPTIONAL, 'Branch', "master"],
            ['commit', null, InputOption::VALUE_REQUIRED, 'Commit id', null],
        ];
    }

}
