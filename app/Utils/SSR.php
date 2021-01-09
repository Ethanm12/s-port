<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class SSR 
{

    private function renderContent($url) {
        $delimiter_hash = base64_encode(md5(intval(microtime(true) * 1000).random_bytes(5), true));
        $context = [
            'url' => $url,
            'delimiter_hash' => $delimiter_hash,
            'domain_root' => asset('')
        ];
        $command = env('NODE_PATH')." ../storage/app/ssr/server-prod.js \"".str_replace('"', '\"', json_encode($context, JSON_UNESCAPED_SLASHES))."\"";

        if (method_exists(Process::class, 'fromShellCommandline')) {
            $process = Process::fromShellCommandline($command);
        } else {
            $process = new Process($command);
        }

        $data = explode("__SSR_OUTLET_META_DELIMETER_".$delimiter_hash."__", $process->mustRun()->getOutput());
        $error = $process->getErrorOutput();
        if ($error) {
            Log::error($error);
        }

        return [
            'head' => $data[0],
            'body' => $data[1]
        ];
    }

    public function getContent($url) {
        try {
            return $this->renderContent($url);
        } catch (Exception $e) {
            Log::error($e);
            return [
                'head' => '',
                'body' => '<script>console.error("SSR error occured, check server logs.");</script>'
            ];
        }
        
    }
}