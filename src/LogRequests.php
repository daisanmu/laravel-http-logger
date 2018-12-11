<?php

namespace Daisanmu\HttpLogger;

use Illuminate\Http\Request;

class LogRequests implements LogProfile
{
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['get','post', 'put', 'patch', 'delete']);
    }

    /**
     * 输出一行内容
     *
     * @param string $string 输出的内同
     * @param boolean $withTime 是否加时间前缀
     */
    public function outputLine($string, $withTime = true)
    {
        $output = '';

        if ($withTime) {
            $now = date('Y-m-d H:i:s');
            $output .= "[{$now}] ";
        }

        $output .= $string;

        try {
            $outputFile = $this->createFiles();
            file_put_contents($outputFile, $output . "\n", FILE_APPEND);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($output);
        }
    }

    /**
     * 创建文件
     *
     * @return bool|string
     * @throws \Exception
     */
    protected function createFiles()
    {
        $outputFile = $this->getOutputFilePath();

        if (!file_exists($outputFile)) {
            $directory = dirname($outputFile);

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            if (!file_exists($directory)) {
                throw new \Exception('命令日志文件存放目录创建失败：' . $directory);
                return false;
            }

            touch($outputFile);

            if (!file_exists($outputFile)) {
                throw new \Exception('命令日志文件创建失败：' . $outputFile);
                return false;
            }

            return $outputFile;
        }

        return $outputFile;
    }

    /**
     * 根据任务JOB名获取对应的日志文件路径
     *
     * @return string
     */
    protected function getOutputFilePath()
    {
        $storagePath = storage_path();

        return $storagePath . '/logs/request_' . date('Y-m-d') . '.log';
    }
}
