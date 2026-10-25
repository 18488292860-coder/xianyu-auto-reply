<?php
/**
 * MySQL 兼容性修复工具
 * 将 MySQL 8.0 的 SQL 文件转换为 MySQL 5.7 兼容格式
 */

if ($argc < 2) {
    echo "用法: php fix_mysql_compatibility.php <input_sql_file> [output_sql_file]\n";
    echo "示例: php fix_mysql_compatibility.php database.sql database_fixed.sql\n";
    exit(1);
}

$inputFile = $argv[1];
$outputFile = isset($argv[2]) ? $argv[2] : str_replace('.sql', '_fixed.sql', $inputFile);

if (!file_exists($inputFile)) {
    echo "错误: 输入文件 '$inputFile' 不存在\n";
    exit(1);
}

echo "开始修复 MySQL 兼容性问题...\n";
echo "输入文件: $inputFile\n";
echo "输出文件: $outputFile\n";

// 读取SQL文件内容
$sqlContent = file_get_contents($inputFile);

if ($sqlContent === false) {
    echo "错误: 无法读取文件 '$inputFile'\n";
    exit(1);
}

// 定义需要替换的排序规则映射
$collationMap = [
    'utf8mb4_0900_ai_ci' => 'utf8mb4_general_ci',
    'utf8mb4_0900_as_ci' => 'utf8mb4_general_ci',
    'utf8mb4_0900_as_cs' => 'utf8mb4_bin',
    'utf8mb4_0900_bin' => 'utf8mb4_bin',
    'utf8_0900_ai_ci' => 'utf8_general_ci',
    'utf8_0900_as_ci' => 'utf8_general_ci',
    'utf8_0900_as_cs' => 'utf8_bin',
    'utf8_0900_bin' => 'utf8_bin'
];

// 修复计数
$fixCount = 0;

// 执行替换
foreach ($collationMap as $oldCollation => $newCollation) {
    $count = 0;
    $sqlContent = str_replace($oldCollation, $newCollation, $sqlContent, $count);
    $fixCount += $count;
    
    if ($count > 0) {
        echo "已替换 $count 个 '$oldCollation' 为 '$newCollation'\n";
    }
}

// 修复其他MySQL 8.0特性
$fixes = [
    // 移除 ROW_FORMAT = Dynamic（在某些版本可能不支持）
    '/ROW_FORMAT\s*=\s*Dynamic/i' => '',
    
    // 修复索引语法 USING BTREE（移除冗余部分）
    '/\s+USING BTREE/' => '',
    
    // 修复 NULL DEFAULT 语法
    '/\s+NULL\s+DEFAULT\s+NULL/' => ' DEFAULT NULL',
    
    // 确保 COMMENT 在正确位置
    '/,\s*COMMENT\s*=/' => ' COMMENT =',
];

foreach ($fixes as $pattern => $replacement) {
    $count = 0;
    $sqlContent = preg_replace($pattern, $replacement, $sqlContent, -1, $count);
    if ($count > 0) {
        echo "应用了语法修复: $count 处\n";
        $fixCount += $count;
    }
}

// 写入修复后的文件
if (file_put_contents($outputFile, $sqlContent) === false) {
    echo "错误: 无法写入文件 '$outputFile'\n";
    exit(1);
}

echo "\n修复完成!\n";
echo "总共修复了 $fixCount 处问题\n";
echo "修复后的文件保存为: $outputFile\n";
echo "\n现在您可以将修复后的SQL文件导入到MySQL 5.7+服务器\n";
?> 