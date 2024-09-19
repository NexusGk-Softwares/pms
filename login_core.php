<?php 
session_start();

include_once "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
if ( !$connection ) {
    echo mysqli_error( $connection );
    throw new Exception( "Database cannot Connect" );
}
$action = isset($_REQUEST['action'])?$_REQUEST['action']: '';

if ( 'login' == $action ) {
    $email = isset($_REQUEST['email']) ? $_REQUEST['email']:'';
    $password = isset($_REQUEST['password']) ?$_REQUEST['password']: '';
    $role = isset($_REQUEST['role']) ?$_REQUEST['role'] : '';

    if ( $email && $password && $role ) {
        $query = "SELECT * FROM {$role} WHERE email='{$email}' and password=md5('{$password}')";
        $result = mysqli_query( $connection, $query );

        if ( $data = mysqli_fetch_assoc( $result ) ) {
            $_passsword = isset($data['password'])?$data['password']: '';
            $_email = isset($data['email'])? $data['email']:'';
            $_id = isset($data['id'])?$data['id']: '';
            $_role = isset($data['role'])?$data['role']: '';

            // if ( password_verify($password, $_passsword ) ) {
                $_SESSION['role'] = $_role;
                $_SESSION['id'] = $_id;
                header( "location:index.php" );
                // die();
            // }
        } else {
            header( "location:login.php?error" );
        }

    }
}
