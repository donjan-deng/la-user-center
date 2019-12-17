<?php

return [
    // 是否开启配置中心的接入流程，为 true 时会自动启动一个 ConfigFetcherProcess 进程用于更新配置
    'enable' => env('ALIYUN_ACM_ENABLE', false),
    // 配置更新间隔（秒）
    'interval' => env('ALIYUN_ACM_INTERVAL', 5),
    // 阿里云 ACM 断点地址，取决于您的可用区
    'endpoint' => env('ALIYUN_ACM_ENDPOINT', 'acm.aliyun.com'),
    // 当前应用需要接入的 Namespace
    'namespace' => env('ALIYUN_ACM_NAMESPACE', 'ef3948fa-d0d5-4119-bc75-33a5b76126fe'),
    // 您的配置对应的 Data ID
    'data_id' => env('ALIYUN_ACM_DATA_ID', 'hyperf.env'),
    // 您的配置对应的 Group
    'group' => env('ALIYUN_ACM_GROUP', 'USER_CENTER'),
    // 您的阿里云账号的 Access Key
    'access_key' => env('ALIYUN_ACM_AK', ''),
    // 您的阿里云账号的 Secret Key
    'secret_key' => env('ALIYUN_ACM_SK', ''),
];
