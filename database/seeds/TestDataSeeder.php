<?php

use Illuminate\Database\Seeder;
use App\Admin\Bls\Other\Model\FeedbackModel;
use App\Consts\Admin\Other\FeedbackTypeConst;
use App\User;
use App\Admin\Bls\Client\Model\NavModel;
use App\Admin\Bls\Client\NavBls;
use App\Admin\Bls\Client\Model\PageModel;
use App\Consts\Admin\Client\PageTemplateConst;
use App\Consts\Admin\Client\NavBindTypeConst;
use App\Consts\Admin\Client\NavCategoryConst;
use App\Admin\Bls\Client\Requests\NavRequests;
use App\Admin\Bls\Client\Model\NewsModel;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //反馈
        FeedbackModel::truncate();
        FeedbackModel::insert([
            [
                'users_id' => 1,
                'type' => FeedbackTypeConst::FEEDBACK,
                'created_at' => '2018-2-3 12:2:1',
                'extend' => '{"text1": "我是测试1","text2": "我是测试2"}',
                'contents' => '晨曦的古巷，清风徐徐，青石板路横斜阡陌。我和先生牵着手，漫步于这条静谧的宽窄巷子，恍惚走于千百年前的蜀国，幽深清静。前面梳着两个麻花辫，穿着白色蕾丝裙子蹦蹦跳跳的女儿，撒下一路欢笑。古色古香的木制老屋商铺沿着青石板路蜿蜒到看不见的路尽头，雕花的两边橱窗里摆着或精致，或可爱，或典雅的丝巾，蜀锦，发钗等商品，琳琅满目。那些透着青光的石板路诉说着古老的历史。我拿着把刺绣小扇，穿着一身柠檬黄丝绸裙，摩梭着脚下的石板，抬头看头顶的四方天，触摸着那些雕花的窗棱，沉浸在这一片安静里。“咔咔”，先生拿着手机拍下了我这沉思的一幕，我给了先生一个回眸一笑。古巷不算长，清晨时，游人或还在沉睡。没有夜晚时的游人如织，摩肩接踵。三两的游人，闲闲散散的缓步于古巷中，仿佛走在回家的路，悠闲自在。或许就是和我们一样，想探索古巷静谧美的人，不习惯那古巷的热闹。我和先生走走走停停，累了，随意街边找了家古茶店坐下，点了两杯菊花茶。先生坐于那端，我坐于这端。女儿隔着绿窗，朝着我们笑。我们时而低语，时而一起看下窗外的蓝天，对街的窗景，时而低头端起杯子喝茶。菊花，味淡而清香，在水里浮沉，在人心里涤荡......阳光渐渐穿过树梢，撒到了青石板路上，印出影影绰绰的树影。游人渐渐多了起来，有拖着行李箱就来的，有三五好友一起的，有一个人慢慢逛的，古巷苏醒了。我们一家，缓缓离开了古巷，留下一个渐行渐远的背影。',
            ]
        ]);

        User::truncate();
        User::insert([
            [
                'name' => '张三',
                'email' => 'admin@qq.com',
                'password' => '$2y$10$9vbGuAlD6rrpz5ULY7uqreZ0uclH.mh92Vfjvb6sbGTJ.Pk3vvs3W',
            ]
        ]);

        $this->client();
    }

    public function client()
    {
        $this->nav();
        $this->page();
        $this->news();
    }

    public function nav()
    {
        NavModel::truncate();
        $menuRequest = new NavRequests();

//关于晨曦
        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '关于晨曦',
            'bind_type' => NavBindTypeConst::JUMP,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 1,
            'url' => ''
        ]);
        $menu = NavBls::store($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '',
            'bind_type' => NavBindTypeConst::BIND_PAGE,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 1,
            'url' => ''
        ]);
        NavBls::store($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '',
            'bind_type' => NavBindTypeConst::BIND_PAGE,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 2,
            'url' => ''
        ]);
        NavBls::store($menuRequest);

//网友点评

        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '网友点评',
            'bind_type' => NavBindTypeConst::BIND_PAGE,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 3,
            'url' => ''
        ]);
        NavBls::store($menuRequest);
//晨曦炖品资讯

        $menuRequest->merge([
            'parent_id' => 0,
            'title' => '晨曦炖品资讯',
            'bind_type' => NavBindTypeConst::JUMP,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 4,
            'url' => ''
        ]);
        $menu = NavBls::store($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '',
            'bind_type' => NavBindTypeConst::BIND_PAGE,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 5,
            'url' => ''
        ]);
        NavBls::store($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '',
            'bind_type' => NavBindTypeConst::BIND_PAGE,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 6,
            'url' => ''
        ]);
        NavBls::store($menuRequest);

        $menuRequest->merge([
            'parent_id' => $menu->getKey(),
            'title' => '',
            'bind_type' => NavBindTypeConst::BIND_PAGE,
            'category' => NavCategoryConst::HEADER,
            'page_id' => 7,
            'url' => ''
        ]);
        NavBls::store($menuRequest);

    }

    public function page()
    {
        PageModel::truncate();
        PageModel::insert([
            //关于晨曦
            [
                'title' => '晨曦炖品介绍',
                'template' => PageTemplateConst::PAGE,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => <<<EOT
<div> <p>
	中华饮食文化，源远流长，食补养生炖品更是其中的精髓。1996年，晨曦率先将“食补养生概念”引入温州市场，受到了广大消费者的喜爱，并快速发展到浙江，安徽，上海，江苏，广东等地，晨曦食品也先后获得中国食品工业协会颁发的“国家质量卫生安全全面达标食品”称号，并通过国家质量技术监督部门的QS食品认证。晨曦门店曾被消费日报、健康生活杂志授予“媒体联合向读者推荐的优秀健康休闲场所”等多项荣誉。主营高档海参、鲍鱼、鱼翅、冬虫夏草、蛤士蟆、鹿鞭等70余款养生炖品，货真价实，口味纯正，营养丰富。</p>
<p>
	&nbsp;</p>
<center>
	<img alt="晨曦炖品" src="http://www.chenxidunpin.com/uploads/allimg/181129/1-1Q1291SJ4P3.jpg" width="868" height="611"></center>
<p>
	&nbsp;</p>
<p>
	<strong>企业介绍</strong></p>
<p>
	晨曦滋补网隶属晨曦(香港)发展有限公司(以下简称“晨曦“)，是晨曦开辟网络销售的领头军。晨曦是一家集海洋食品生产、滋补品销售、餐饮娱乐于一体的综合性企业，它将中国传统滋补品推入了新境界并深得当今食补界最好的赞誉!</p>
<p>
	公司旗下的“晨曦虫草燕窝专卖店”是浙江虫草燕窝滋补行业中最为专业，最具规模的代理经营企业。在同行中赢得”种类齐全、选品上乘、质高价优、包装精美“的认可口碑和良好的企业形象;同时受过专业的服务人员，让消费者充分了解到最方便、最有效的进食滋补品的相关知识。</p>
<p>
	公司旗下的“晨曦食补养生炖品阁”主要经营高档燕翅鲍，冬虫夏草、蛤士蟆、鹿鞭等70余款养生炖品。采用中华传统食补配方，选用名贵原材料，货真价实、口味纯正、营养丰富，让消费者在享受美味的同时亦达到养生悼的，同时炖品阁提供24小时统一送餐服务。</p>
<p>
	<strong>补品类产品展示</strong></p>
<p>
	1：冬虫夏草——产自西藏那曲，A5000虫草，每根虫草都经过多重共序，深度加工，清洁度达到A5000</p>
<p>
	2：淡干刺参——产自大连，，每头独立包装，锡纸密封无糖淡干，营养丰富。</p>
<p>
	3：印尼进口燕窝——进口燕窝，产自印尼，颜色呈微黄色，盏型大，发头大，天然无添加。</p>
<p>
	4：即食莽撞胶——产自北海深海的鱼胶，即食产品，丰富的胶原蛋白。</p>
<p>
	5：红枣鱼胶——即食红枣鱼胶，孕妇滋补品，高蛋白，低脂肪，Q爽弹牙，胶原慢慢。</p>
<p>
	<strong>炖品类产品展示</strong></p>
<p>
	1：惊喜鲍汁捞饭——招牌捞饭，鲜香醇厚的鲍汁，辅以鸡肉，北极贝裙边，香菇丝等，妙不可言。</p>
<p>
	2：王者荣耀鱼翅捞饭——晶莹剔透的鱼翅，配以浓郁鲍鱼，无时无刻不在挑逗你的味蕾。</p>
<p>
	3：海参扣鹅掌鲍汁捞饭——精心挑选的海参和肥厚的鹅掌在鲜淳的鲍汁中起舞，三种口感，同时享受。</p>
<p>
	4：鲍鱼扣鹅掌鲍汁捞饭——完美展现广东粤菜的精髓，鲍鱼的弹嫩，鹅掌的肥厚，鲍汁的鲜美，层层逼近。</p>
<p>
	5：佛跳墙——8小时尽精熬制，辅以鲍鱼，鱼翅，鱼胶，海参，干贝，花菇，满满的幸福感。</p>
<p>
	6：燕窝芒果羹——精选燕窝，炖盅加盖，文火隔水炖，保留燕窝的原汁原味以及营养。</p>
<p>
	7：现熬原盅碗仔翅——碗仔翅的汤底采用新鲜食材和鸡汤精心熬制3个小时才成，入口香甜味美，回味悠长。</p>
<p>
	晨曦注重食补养生，旗下产品对高速度压力生活的现代人，具有很好的保健滋补功效。健康，滋补，注重人与人之间情感的交流及中高档的产品，成为有一定经济实力人士最喜爱的消费选择。如今，为了更方便的为新老客户服务，晨曦开辟了网络销售渠道，让客户足不出户就可以轻松享受到晨曦所带来的健康养生生活，让食补养生变得更加简单便捷!</p>
</div>'
EOT
            ],
            [
                'title' => '品牌故事',
                'template' => PageTemplateConst::PAGE,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => <<<EOT
<div> <div>
	<p>
		中华饮食文化，源远流长，食补养生炖品更是其中的精髓。1996年，晨曦率先将“食补养生概念”引入温州市场，受到了广大消费者的喜爱，并快速发展到浙江，安徽，上海，江苏，广东等地，晨曦食品也先后获得中国食品工业协会颁发的“国家质量卫生安全全面达标食品”称号，并通过国家质量技术监督部门的QS食品认证。晨曦门店曾被消费日报、健康生活杂志授予“媒体联合向读者推荐的优秀健康休闲场所”等多项荣誉。主营高档海参、鲍鱼、鱼翅、冬虫夏草、蛤士蟆、鹿鞭等70余款养生炖品，货真价实，口味纯正，营养丰富。</p>
</div>
<br>
</div>
EOT
            ],
            [
                'title' => '品牌荣誉',
                'template' => PageTemplateConst::PAGE,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => <<<EOT
<div> <div>
	<p>
		温州市晨曦海洋食品有限公司晨曦(香港)发展有限公司是一家食品生产、滋补品销售、餐饮娱乐于一体的综合性企业。公司始终秉承“品质优先、薄利多销”的经验理念，十年如一日的诚信经营，获得了广大消费者的一致信赖与支持。十年创业的努力壮大，晨曦不断扩大规模，汇聚了行业工作十余年的专家队伍，不仅在生产技术研究方面倾尽全力，更努力在食品工艺方面不断探索，励志生产出市场领先的优质食品。晨曦员工将“质量—效率—创新”落实到工作的每一环节。在不断发展中追求更高的质量，更好的信誉，更佳的服务。产值、规模等连年成倍增长，赢得了社会一致的好评于关注。公司生产线吸收国外先进技术研制、开发并生产食品，其技术性能和质量标准均达到同类产品的先进水平。该生产线从配料、加工、成型、调味直至成品可一次性完成。公司旗下的“晨曦虫草燕窝专卖店”是温州虫草燕窝滋补行业中第一家最为专业，最具规模的连锁经营企业。在同行中赢得“种类齐全、选品上乘、质高价优、包装精美”的认可口碑和良好的企业形象;同时受过专业培训的服务人员，让消费者充分了解到最方便、最有效的进食滋补品的相关知识。 “晨曦食补生炖品阁”主要经营高档燕翅鲍，冬虫夏草、蛤士蟆、鹿鞭等70余款养生炖品。货真价实、口味纯正、营养丰富，同时提供24小时全市统一上门送餐服务。公司重视人才培养，追求卓越，锐意进取。迅猛发展的晨曦诚邀有志于海洋食品事业并认同我们企业文化的杰出人士加盟，共同开拓公司的美好未来。</p>
</div>
<br>
</div>
EOT
            ],
//网友点评

            [
                'title' => '网友点评',
                'template' => PageTemplateConst::NEWS,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => ''
            ],

//晨曦炖品资讯
            [
                'title' => '公司新闻',
                'template' => PageTemplateConst::NEWS,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => ''
            ],
            [
                'title' => '加盟动态',
                'template' => PageTemplateConst::NEWS,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => ''
            ],
            [
                'title' => '秘方菜谱',
                'template' => PageTemplateConst::NEWS,
                'extend' => '[]',
                'created_at' => '2018-02-03 12:02:01',
                'updated_at' => '2018-02-03 12:02:01',
                'contents' => ''
            ],
        ]);
    }

    public function news()
    {
        NewsModel::truncate();
        NewsModel::insert([
            [
                'title' => '晨曦炖优势4大支持',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => '晨曦qweq优势4大支持',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => '晨曦炖a萨达优势4大支持',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => '阿萨SDK',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => '奥斯卡绝地枪王',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => '阿萨德静安寺',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => 'as多亏了千万',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ],
            [
                'title' => '阿斯利康到千万',
                'page_id' => '5',
                'picture' => 'image/201907/25/97fca48d037b6aec262c8062e3cf76ea.jpg',
                'status' => 1,
                'created_at' => '2019-07-25 5:02:41',
                'comment' => '晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...',
                'contents' => 'asdas晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...晨曦炖品鲍鱼饭打破了人们对传统快餐的印象，将营养美味的餐点提供给广大消费者，对于消费者而言，多、快、好、省便是就餐的较高境界，恰恰能够让消费者吃得饱、吃得好，同时...das',
            ]

        ]);

    }

}
