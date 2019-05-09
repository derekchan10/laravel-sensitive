<?php
return [
    // 目前只支持数据库方式存储关键词
    'table' => 't_sensitive_words',
    // 关键词字段
    'field' => 'content',
    
    // 设置关键词缓存时间
    'cache' => 0,

    // 忽略的特殊字符
    'ignore' => ['&', '*', '@', ' ', '_', '-'],

    // 错误提示
    'error_message' => '內容包含敏感詞匯，請重新輸入！',
];