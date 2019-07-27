<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use QL\QueryList;
use Spatie\DbDumper\Databases\MySql;
use Mail;

class ReptileCommand extends Command
{
    /** @var string */
    protected $signature = 'reptile:run';

    /** @var string */
    protected $description = '爬虫';

    public $filePath = '';
    public $http = 'https://www.szrm.com.cn';
    public $pageId = 0;

    public function handle()
    {
        $this->filePath = \Storage::disk('admin')->path('img');

        $this->line('开始备份爬去数据');
        //$this->file(['http://php.chenxi.com/uploads/image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg']);
        $news = [
            ['page' => 20,'num'=>2, 'url' => 'https://www.szrm.com.cn/dianping/list_33_%s.html'], //网友点评
            ['page' => 21,'num'=>3, 'url' => 'https://www.szrm.com.cn/xinwen/list_9_%s.html'], //公司新闻
            ['page' => 22,'num'=>15, 'url' => 'https://www.szrm.com.cn/dontai/list_10_%s.html'], //加盟动态
            ['page' => 23,'num'=>2, 'url' => 'https://www.szrm.com.cn/news/mifangcaipu/list_32_%s.html'] //秘方菜谱
        ];
        //$this->news($news);

        $products = [
            //['page' => 20,'num'=>1, 'url' => 'http://php.chenxi.com/products/6'], //宫廷御膳砂锅饭
            ['page' => 4,'num'=>1, 'url' => 'https://www.szrm.com.cn/guoting/'], //宫廷御膳砂锅饭
            ['page' => 5,'num'=>3, 'url' => 'https://www.szrm.com.cn/waguan/'], //原蛊现熬瓦罐汤
            ['page' => 6,'num'=>15, 'url' => 'https://www.szrm.com.cn/myl/'], //增强免疫力
            ['page' => 7,'num'=>2, 'url' => 'https://www.szrm.com.cn/xlz/'], //雪莲子篇
            ['page' => 8,'num'=>2, 'url' => 'https://www.szrm.com.cn/yc//'], //鱼翅篇
            ['page' => 9,'num'=>2, 'url' => 'https://www.szrm.com.cn/hs/'], //海参篇
            ['page' => 10,'num'=>2, 'url' => 'https://www.szrm.com.cn/yj/'], //鱼胶篇
            ['page' => 11,'num'=>2, 'url' => 'https://www.szrm.com.cn/by/'], //鲍鱼篇
            ['page' => 12,'num'=>2, 'url' => 'https://www.szrm.com.cn/ycb/'], //燕翅鲍篇
            ['page' => 13,'num'=>2, 'url' => 'https://www.szrm.com.cn/lb/'], //鹿鞭篇
            ['page' => 15,'num'=>2, 'url' => 'https://www.szrm.com.cn/ftq/'], //佛跳墙篇
            ['page' => 16,'num'=>2, 'url' => 'https://www.szrm.com.cn/zibu/'], //专注滋补23载
            ['page' => 17,'num'=>2, 'url' => 'https://www.szrm.com.cn/baozi/'], //鲍汁卤味
            ['page' => 18,'num'=>2, 'url' => 'https://www.szrm.com.cn/shishu/'], //烫时蔬
            ['page' => 19,'num'=>2, 'url' => 'https://www.szrm.com.cn/yinpin/'], //暖心饮品
        ];

        $this->products($products);
        $this->line('完成');

    }

    public function news($array)
    {
        foreach ($array as $item) {
            $this->pageId = $item['page'];
            for ($i = 1; $i <= $item['num']; $i++) {
                    $url = sprintf($item['url'], $i);
                    $this->line($url);
                    $client = new \GuzzleHttp\Client();
                    $res = $client->request('GET', $url, [
                        'wd' => 'QueryList'
                    ]);
                    $html = (string)$res->getBody();

                    $data = QueryList::html($html)
                        ->rules([
                            'title' => ['.met-page-ajax li .media-heading a', 'text'],
                            'comment' => ['.met-page-ajax li .des', 'text'],
                            'picture' => ['.met-page-ajax li .media-left img', 'src'],
                            'link' => ['.met-page-ajax li .media-body a', 'href']
                        ])->query()->getData(function ($item) {
                            dump($item);

                            if ($item['picture']) {
                                $this->file([$item['picture']]);
                            }

                            $this->line($this->http.$item['link']);

                            $client = new \GuzzleHttp\Client();
                            $res = $client->request('GET', $this->http.$item['link'], [
                                'wd' => 'QueryList'
                            ]);
                            $html = (string)$res->getBody();

                            $data = QueryList::html($html)
                                ->rules([
                                    'contents' => ['.clearfix', 'text'],
                                    'created_at' => ['.met-shownews-header .info span:eq(0)', 'text'],
                                    'updated_at' => ['.met-shownews-header .info span:eq(0)', 'text'],
                                ])->query()->getData(function ($item) {

                                    $res = preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i', $item['contents'], $matchs);
                                    if ($res) {
                                        $this->file($matchs[1]);
                                    }
                                    return $item;
                                });
                            $item['page_id'] = $this->pageId;
                            $item['status'] = 1;
                            unset($item['link']);
                            return array_merge($item, $data[0]);
                        });

                    if($data->isEmpty()) {
                        break;
                    }

                    DB::table('admin_news')->insert($data->toArray());
                    sleep(3);



            }


        }


    }

    public function products($array)
    {
        foreach ($array as $item) {
            $this->pageId = $item['page'];
                $this->line($item['url']);
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $item['url']);
                $html = (string)$res->getBody();

                $data = QueryList::html($html)
                    ->rules([
                        'title' => ['.widget-shadow .widget-title a', 'text'],
                        'picture' => ['.widget-shadow .cover-image', 'src'],
                        'link' => ['.widget-shadow  .widget-header a', 'href']
                    ])->query()->getData(function ($item) {

                        if ($item['picture']) {
                            $this->file([$item['picture']]);
                        }

                        $this->line($this->http.$item['link']);

                        $client = new \GuzzleHttp\Client();
                        $res = $client->request('GET', $this->http.$item['link']);
                        $html = (string)$res->getBody();

                        $data = QueryList::html($html)
                            ->rules([
                                'contents' => ['.clearfix', 'html'],
                                'comment' => ['.description', 'text'],
                                'industry' => ['.para .row .blue-grey-500:eq(1)', 'text'], //所属行业
                                'mode' => ['.para .row .blue-grey-500:eq(2)', 'text'], //创业方式
                                'money' => ['.para .row .blue-grey-500:eq(3)', 'text'],//投资金额
                            ])->query()->getData(function ($item) {

                                $res = preg_match_all('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i', $item['contents'], $matchs);
                                if ($res) {
                                    $this->file($matchs[1]);
                                }
                                return $item;
                            });

                        $item['page_id'] = $this->pageId;
                        $item['created_at'] = '2019-07-26 09:46:10';
                        $item['updated_at'] = '2019-07-26 09:46:10';
                        $item['status'] = 1;
                        unset($item['link']);
                        return array_merge($item, $data[0]);
                    });

                if($data->isEmpty()) {
                    break;
                }

                DB::table('admin_product')->insert($data->toArray());
                sleep(3);

        }
    }

    function downloadRemoteFileWithCurl($fileUrl, $saveTo, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_URL, $fileUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        $fileContent = curl_exec($ch);
        if (empty($fileContent)) {
            return false;
        }
        curl_close($ch);

        $downloadedFile = fopen($saveTo, 'w');
        fwrite($downloadedFile, $fileContent);
        fclose($downloadedFile);
        return true;
    }

    function file($data)
    {
        foreach ($data as $item) {

            $a = explode('/', $item);

            $name = end($a);
            if ($name) {

               // dd(strtr($item, $name, ''));
                $file = str_replace($name, "", $item);
                if (!file_exists($this->filePath.$file)) {

                    mkdir($this->filePath . $file, 0777, true);
                }
            }

            $this->downloadRemoteFileWithCurl($this->http . $item, $this->filePath . $item);

        }
    }
}

