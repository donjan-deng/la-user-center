pipeline {
    agent none
       stages {
        stage('Build') { //这是一个标准的流水线，由于PHP不需要编译，其实不需要构建阶段
            steps {
                echo "${env.BRANCH_NAME}"
                echo "${env.GIT_COMMIT}"
            }
        }
        stage('Test') { //执行测试
            agent { dockerfile true }
            steps {
                // sh '/opt/www/vendor/bin/co-phpunit -c /opt/www/phpunit.xml --colors=always'
                echo 'test'
            }
        }
        stage('Deploy') { //发布到仓库
            agent {
                docker { 
                    image 'docker:latest'
                }
            }
            steps {
                script{
                  docker.withRegistry('https://registry.cn-chengdu.aliyuncs.com','aliyun'){ //这个aliyun是我们全局凭据的ID
                      def customImage = docker.build("donjan/user-center:${env.BRANCH_NAME}-${env.GIT_COMMIT}")
                      customImage.push() //推送镜像
                      customImage.push('latest') //推送一个latest的镜像
                  }
                }
            }
        }
    }
}