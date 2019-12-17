# 用户中心

基于Hyperf框架的用户中心,《PHP微服务练兵》系列教程源码 <https://blog.csdn.net/donjan/article/details/103005084>

## 安装

### 已有环境
```
git clone https://github.com/donjan-deng/la-user-center.git
cd la-user-center
composer install

复制.env.example为.env,并编辑好配置

# 运行数据库迁移
php bin/hyperf.php migrate

# 运行数据填充
php bin/hyperf.php db:seed --path=seeders/user_table_seeder.php
php bin/hyperf.php db:seed --path=seeders/permission_table_seeder.php
# 启动
php bin/hyperf.php start
默认管理员账号admin,密码123456
```
### Docker安装

```
docker run -d --name user-center \
  --restart=always \
  -p 9501:9501 -p 9504:9504 \
  -it --entrypoint /bin/sh \
  donjan/la-user-center

docker exec -it user-center bash

cd /opt/www

复制.env.example为.env,并编辑好配置

# 运行数据库迁移
php bin/hyperf.php migrate

# 运行数据填充
php bin/hyperf.php db:seed --path=seeders/user_table_seeder.php
php bin/hyperf.php db:seed --path=seeders/permission_table_seeder.php

```