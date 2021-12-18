pipeline {
  agent {
    docker {
      reuseNode 'true'
      registryUrl 'https://coding-public-docker.pkg.coding.net'
      image 'public/docker/php:8.0'
      args '-v /var/run/docker.sock:/var/run/docker.sock -v /usr/bin/docker:/usr/bin/docker -v /root/.cache:/root/.cache'
    }
  }
  stages {
    stage('检出') {
      steps {
        checkout([
          $class: 'GitSCM',
          branches: [[name: GIT_BUILD_REF]],
          userRemoteConfigs: [[
            url: GIT_REPO_URL,
            credentialsId: CREDENTIALS_ID
          ]]
        ])
      }
    }
    stage('安装依赖') {
      steps {
        sh 'curl https://mirrors.cloud.tencent.com/composer/composer.phar -o /usr/local/bin/composer && chmod +x /usr/local/bin/composer'
        sh 'composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/'
        sh 'find /etc/apt/ -name "*.list" -print0 | xargs -0 sed -i -E "s/[a-z]+.debian.org/mirrors.cloud.tencent.com/g"'
        sh 'apt-get update && apt-get install -y libzip-dev unzip zip zlib1g-dev'
        sh 'docker-php-ext-install zip'
        sh 'composer install --no-dev'
        sh 'composer install'
      }
    }
    stage('验收测试') {
      steps {
        sh 'XDEBUG_MODE=coverage ./vendor/bin/phpunit --log-junit junit.xml --coverage-clover coverage.xml --coverage-filter src/ tests/Acceptance'
        junit 'junit.xml'
      }
    }
  }
}
