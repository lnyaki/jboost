pipeline {
  agent any
  stages {
    stage('Test stage 1') {
      steps {
        powershell(script: 'testScript.sh', returnStatus: true, returnStdout: true)
      }
    }
  }
}