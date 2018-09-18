pipeline {
  agent any
  stages {
    stage('Test stage 1') {
      steps {
        sh '''echo "*********************"
echo "from :"
pwd
./testScript.sh
echo "*********************"'''
      }
    }
  }
}