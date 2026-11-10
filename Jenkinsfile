pipeline {
    agent any
    stages {
        stage('Código en Git') {
            steps { checkout scm }
        }
        stage('Validar PHP y reglas de solicitud') {
            steps {
                script {
                    if (isUnix()) {
                        sh 'php ci/check.php'
                    } else {
                        bat 'if exist C:\\xampp\\php\\php.exe (C:\\xampp\\php\\php.exe ci\\check.php) else (php ci\\check.php)'
                    }
                }
            }
        }
    }
    options { skipDefaultCheckout() }
}
