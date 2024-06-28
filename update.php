<?php
require_once 'connection.php';

$uid = $_GET['uid'];

$connection = new Connection();

$userData = $connection->query("SELECT * FROM users
    JOIN user_colors ON users.id = user_colors.user_id
    JOIN colors ON colors.color_id = user_colors.color_id
    WHERE users.id = $uid");

if (isset($_POST['colors'])) {

    try {

        $colors = $_POST['colors'];

        $connection->query("DELETE FROM user_colors WHERE user_id=$uid");

        foreach($colors as $color) {
            $connection->query("INSERT INTO user_colors (user_id, color_id) VALUES ($uid, $color)");
        }
        header("location:update.php?uid=$uid");

    } catch (\Throwable $th) {

        echo 'O usuário não existe';

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <form method='post' name='template'>

        <p>Selecione as cores que você deseja ter. para remover alguma cor, só é preciso não selecionar a cor desejada que ela não será incluida</p>

        <input type='checkbox' name='colors[]' value='1'>Blue<br>
        <input type='checkbox' name='colors[]' value='2'>Red<br>
        <input type='checkbox' name='colors[]' value='3'>Yellow<br>
        <input type='checkbox' name='colors[]' value='4'>Green<br>
        
        <br>

        <button type="submit">Atualizar</button>
    </form><br>

    <div>
        
        <p>Meu perfil</p>

        <table border=1>
            <tr>
                <th>ID</th>    
                <th>Nome</th>    
                <th>Email</th>
                <th>Cores</th>
            </tr>

            <?php
                foreach($userData as $data) {
                    echo "
                        <tr>
                            <td>$data->id</td>
                            <td>$data->name</td>
                            <td>$data->email</td>
                            <td>$data->color_name</td>
                        </tr>
                    ";
                }
            ?>
        </table>
    </div>

    <a href="index.php">Voltar</a>
</body>
</html>