<?php
use yii\web\JsExpression;
use daixianceng\echarts\ECharts;
use yii\helpers\ArrayHelper;
ECharts::registerTheme('dark');
ECharts::$dist = ECharts::DIST_FULL;
ECharts::registerMap(['china', 'province/beijing']);

$this->title = '统计分析';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= ECharts::widget([
//    'theme' => 'dark',
    'responsive' => true,
    'options' => [
        'style' => 'height: 400px;'
    ],
    'pluginEvents' => [
        'click' => [
            new JsExpression('function (params) {console.log(params)}'),
            new JsExpression('function (params) {console.log("ok")}')
        ],
        'legendselectchanged' => new JsExpression('function (params) {console.log(params.selected)}')
    ],
    'pluginOptions' => [
        'option' => [
            'title' => [
                'text' => '成功案例分析'
            ],
            'tooltip' => [
                'trigger' => 'axis'
            ],
            'legend' => [
                'data' => ['浏览量', '点赞量', '评论量', '总量（以上三项之和）']
            ],
            'grid' => [
                'left' => '3%',
                'right' => '4%',
                'bottom' => '3%',
                'containLabel' => true
            ],
            'toolbox' => [
                'feature' => [
                    'saveAsImage' => []
                ]
            ],
            'xAxis' => [
                'name' => '产品id',
                'type' => 'category',
                'boundaryGap' => false,
                'data' => $data['successExampleId']             
                         //['产品1', '产品2', '产品3', '产品4', '产品5', '产品6', '产品7']
            ],
            'yAxis' => [
                'type' => 'value',
//                'max'=>600
            ],
            'series' => [
                [
                    'name' => '浏览量',
                    'type' => 'line',
//                    'stack' => '总量',
                    'data' => $data['successExamplePageView']
                ],
                [
                    'name' => '点赞量',
                    'type' => 'line',
//                    'stack' => '总量',
                    'data' => $data['successExampleGivelikeTotal']
                ],
                [
                    'name' => '评论量',
                    'type' => 'line',
//                    'stack' => '总量',
                    'data' => $data['successExampleCommentCount']
                ],
                [
                    'name' => '总量（以上三项之和）',
                    'type' => 'line',
//                    'stack' => '总量',
                    'data' => $data['successExampleAllTotal']
                ],

            ]
        ]
    ]
]); ?>
<?= ECharts::widget([
//    'theme' => 'dark',
    'responsive' => true,
    'options' => [
        'style' => 'height: 400px;'
    ],
    'pluginEvents' => [
        'click' => [
            new JsExpression('function (params) {console.log(params)}'),
            new JsExpression('function (params) {console.log("ok")}')
        ],
        'legendselectchanged' => new JsExpression('function (params) {console.log(params.selected)}')
    ],
    'pluginOptions' => [
        'option' => [
            'title' => [
                'text' => '产品中心分析'
            ],
            'tooltip' => [
                'trigger' => 'axis'
            ],
            'legend' => [
                'data' => ['浏览量', '点赞量', '评论量', '总量（以上三项之和）']
            ],
            'grid' => [
                'left' => '3%',
                'right' => '4%',
                'bottom' => '3%',
                'containLabel' => true
            ],
            'toolbox' => [
                'feature' => [
                    'saveAsImage' => []
                ]
            ],
            'xAxis' => [
                'name' => '产品id',
                'type' => 'category',
                'boundaryGap' => false,
                'data' => $data['dataManageId']             
            ],
            'yAxis' => [
                'type' => 'value'
            ],
            'series' => [
                [
                    'name' => '浏览量',
                    'type' => 'line',
                    'data' => $data['dataManagePageView']
                ],
                [
                    'name' => '点赞量',
                    'type' => 'line',
                    'data' => $data['dataManageGivelikeTotal']
                ],
                [
                    'name' => '评论量',
                    'type' => 'line',
                    'data' => $data['dataManageCommentCount']
                ],
                [
                    'name' => '总量（以上三项之和）',
                    'type' => 'line',
                    'data' => $data['dataManageAllTotal']
                ],

            ]
        ]
    ]
]); ?>