# MySQL 兼容性问题解决方案

## 问题描述
错误 `#1273 - Unknown collation: 'utf8mb4_0900_ai_ci'` 表示您的服务器MySQL版本不支持这个排序规则。

## 版本说明
- `utf8mb4_0900_ai_ci` 是 MySQL 8.0+ 引入的排序规则
- MySQL 5.7 及更早版本不支持此排序规则
- 大多数共享主机使用 MySQL 5.7 或 MariaDB

## 解决方案

### 方案1：使用已修复的SQL文件
直接使用 `include/compatible_database.sql` 文件，该文件已经修复了所有兼容性问题。

### 方案2：使用自动修复工具
```bash
php fix_mysql_compatibility.php your_database.sql fixed_database.sql
```

### 方案3：手动修复
在您的SQL文件中替换以下内容：

**原始内容：**
```sql
CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
```

**修复后：**
```sql
CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
```

**其他需要修复的：**
- `utf8mb4_0900_as_ci` → `utf8mb4_general_ci`
- `utf8mb4_0900_bin` → `utf8mb4_bin`
- `ROW_FORMAT = Dynamic` → 删除此行
- `USING BTREE` → 删除此部分

## 排序规则说明

### 推荐使用的兼容排序规则：
- `utf8mb4_general_ci` - 通用，性能好，兼容性最佳
- `utf8mb4_unicode_ci` - 更准确的Unicode排序，稍慢
- `utf8mb4_bin` - 二进制排序，区分大小写

### 字符集选择：
- `utf8mb4` - 推荐，支持完整Unicode（包括emoji）
- `utf8` - 旧版本，不支持4字节字符

## 验证服务器版本

### 在phpMyAdmin中：
```sql
SELECT VERSION();
```

### 在命令行中：
```bash
mysql --version
```

## 导入修复后的SQL文件

1. 备份现有数据库
2. 使用修复后的SQL文件
3. 在phpMyAdmin中选择"导入"
4. 上传修复后的文件
5. 执行导入

## 注意事项

- 修复后的文件与MySQL 5.7+ 和 MySQL 8.0+ 都兼容
- 功能不会受到影响，只是排序规则更改
- 如果已有数据，建议先备份
- 某些高级Unicode功能可能略有差异，但对大多数应用无影响 