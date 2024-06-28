<?php
require 'connection.php';

$connection = new Connection();

$users = $connection->query("SELECT * FROM users");

session_start();

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    
    $connection->query("DELETE FROM users WHERE id=$id");

    header('location:index.php');

} if (isset($_POST['create'])) {

    $name = $_POST['name'];

    $email = $_POST['email'];

    $connection->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");

    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <table border=1>
        <tr>
            <th>ID</th>    
            <th>Nome</th>    
            <th>Email</th>
            <th>Ação</th>    
        </tr>
        <?php
            foreach($users as $user) {
                echo "
                    <tr>
                        <td>$user->id</td>
                        <td>$user->name</td>
                        <td>$user->email</td>
                        <td>
                            <a href='update.php?uid=".$user->id."'>Editar</a>
                            <a href='index.php?id=".$user->id."'>Excluir</a>
                        </td>
                    </tr>
                ";
            }
        ?>
    </table>

    <form method="post">
        <span>Nome</span>
        <input type="text" name="name" value="Fulano">
        <span>Email</span>
        <input type="text" name="email" value="testando@gmail.com">
        <button type="submit" name="create">Cadastrar</button>
    </form>
</body>
</html>