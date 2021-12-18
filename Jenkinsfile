pipeline {
  agent {
    docker {
      reuseNode 'true'
      image 'ecoding/php:8.0'
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
