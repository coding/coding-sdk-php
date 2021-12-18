pipeline {
  agent any
  environment{
    DOCKER_CACHE_EXISTS = fileExists '/root/.cache/docker/php-8.0.tar'
  }
  stages {
    stage('加载缓存') {
      when { expression { DOCKER_CACHE_EXISTS == 'true' } }
      steps {
        sh 'docker load -i /root/.cache/docker/php-8.0.tar'
      }
    }
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
    stage('验收测试') {
      agent {
        docker {
          reuseNode 'true'
          image 'ecoding/php:8.0'
          args '-v /var/run/docker.sock:/var/run/docker.sock -v /usr/bin/docker:/usr/bin/docker -v /root/.cache:/root/.cache'
        }
      }
      steps {
        sh 'composer install'
        sh 'XDEBUG_MODE=coverage ./vendor/bin/phpunit --log-junit junit.xml --coverage-clover coverage.xml --coverage-filter src/ tests/Acceptance'
        junit 'junit.xml'
      }
    }
    stage('生成缓存') {
      when { expression { DOCKER_CACHE_EXISTS == 'false' } }
      steps {
        sh 'mkdir -p /root/.cache/docker/'
        sh 'docker save -o /root/.cache/docker/php-8.0.tar ecoding/php:8.0'
      }
    }
  }
}
