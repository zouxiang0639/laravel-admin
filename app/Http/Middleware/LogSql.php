<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Log\Writer;
use Monolog\Logger;
use DB;

class LogSql
{

    private $enableLog = FALSE;

    public function __construct()
    {
        $enable_query_log = env("ENABLE_QUERY_LOG", 0);
        $this->enableLog = $enable_query_log == 1;
        if ($this->enableLog) {
            $connections_config = config("database.connections");
            foreach ($connections_config as $db_key => $connection_config) {
                DB::connection($db_key)->enableQueryLog();
            }
        }
    }

    public function handle($request, Closure $next)
    {
        // Perform action
        return $next($request);
    }

    private function getQuerys()
    {
        $connections = DB::getConnections();
        $info_data = [];
        foreach ($connections as $connection) {
            $querys = $connection->getQueryLog();
            if (empty($querys)) {
                continue;
            }
            $info_data[] = "DB:" . $connection->getDatabaseName();
            $query_str = "";

            foreach ($querys as $query) {
                foreach ($query as $qk => $qv) {
                    if (is_array($qv)) {
                        $query_str .= "$qk => ";
                        foreach ($qv as $qqk => $qqv) {
                            $query_str .= " [ $qqk = $qqv ]";
                        }
                        $query_str .= " \r\n";
                    } else {
                        $query_str .= "$qk => $qv \r\n";
                    }
                }
                $query_str .= "\r\n";
            }
            $info_data[] = $query_str;
        }
        return $info_data;
    }

    private function getServerParams(array $params)
    {
        $result_str = "";
        foreach ($params as $k => $v) {
            if (is_array($v)) {
                $result_str .= " [$k=" . json_encode($v) . "] ";
            } else {
                $result_str .= " [$k=$v] ";
            }
        }
        return $result_str;
    }

    public function terminate($request, $response)
    {
        if ($this->enableLog) {
            $sqlLogger = new Writer(new Logger('query_log'));
            $sqlLogger->useFiles(storage_path() . '/logs/sql/' . date('Y-m-d') . '.log');
            try {
                $info_data = $this->getQuerys();
                if (! empty($info_data)) {
                    $data[] = "method=" . $request->method() . "   url=" . $request->fullUrl() . "     ip=" . implode(",", $request->ips());
                    $data[] = "GET PARAMS=>" . $this->getServerParams($_GET);
                    $data[] = "POST PARAMS=>" . $this->getServerParams($_POST);
                    $data[] = "COOKIE PARAMS=>" . $this->getServerParams($_COOKIE);
                    $data[] = "\r\n";
                    $data[] = implode("\r\n", $info_data);
                    $data[] = "\r\n==============END===================\r\n";

                    $sqlLogger->info(implode("\r\n", $data));
                }
            } catch (\Exception $e) {
                $sqlLogger->error($e);
            }
        }
    }
}
