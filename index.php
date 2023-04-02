<?php
$pdo = new PDO('mysql:host=localhost;dbname=crud', 'root', '');
//insert.
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$access = isset($_POST['access']) ? $_POST['access'] : 'comum';
if (!empty($name) && !empty($email)) {
    $stmt = $pdo->prepare("INSERT INTO clientes (name,email,access ) VALUES (?,?,?)");
    $stmt->execute(array($name, $email, $access));
    echo 'inserido com sucesso!';
}
//delete

//verifica se o ID foi fornecido
if (isset($_GET['id'])) {
    //recebe o ID a ser excluído
    $id = $_GET['id'];

    //prepara e executa a exclusão
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$id]);

    //redireciona a página 
    header("location:index.php");
    exit();
}

?>

<form method="post">
    <input type="text" placeholder="USER NAME" name="name">
    <input type="text" placeholder="USER EMAIL" name="email">
    <select name="access" id="access">
        <option value="comum">comum</option>
        <option value="administrator">administrator</option>
        <option value="moderator">moderator</option>
    </select>
    <input type="submit" value="Enviar">
</form>

<?php
//GET
$sql = $pdo->prepare("SELECT * FROM clientes");
$sql->execute();

$fetchUsers = $sql->fetchall();
//exibe a tabela
echo '<table style="width: 800px;">';
echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Access</th></tr>';
foreach ($fetchUsers as $key => $value) {
    echo '<tr style="width: 800px;">';
    echo  '<td>'.$value['id'].'</td>';
    echo  '<td>'.$value['name'].'</td>';
    echo  '<td>'.$value['email'].'</td>';
    echo  '<td>'.$value['access'].'</td>';
    echo '<td><a href="edit.php?id='.$value['id'].'">Editar</a> | <a href="'.$_SERVER['PHP_SELF'].'?delete_id='.$value['id'].'">Excluir</a></td>';
    echo '</tr>';

};


?>