<?php
/*criação de um objeto PDO para conexão com o banco de dados.
o objeto pdo recebe como parâmetro de conexão o host, nome do banco, usuario e senha.*/
$pdo = new PDO('mysql:host=localhost;dbname=crud', 'root', '');

//Verifica se o id existe
if (isset($_GET['id'])) {
    //recebe o ID a ser editado
    $id = $_GET['id'];

    /*Aqui estamos pegando as informações que foramm inseridas através do método POST
    no formulário anterior e verificando se cada informação foi fornecida através do isset()
    caso as informações estejam presentes elas serão armazenadas nas variáveis name, email e access 
    que são ligadas ao banco de dados*/
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $access = isset($_POST['access']) ? $_POST['access'] : 'comum';

        /*Verifica se os campos name e email não estão vazios e caso não, executa o comando update
        para atualizar os dados no banco de dados*/
        if (!empty($name) && !empty($email)) {
            //executa a atualização no banco de dados
            $stmt = $pdo->prepare("UPDATE clientes SET name = ?, email = ?, access = ? WHERE id = ?");
            $stmt->execute([$name, $email, $access, $id]);

            //redireciona para a página inicial
            header("location:index.php");
            exit();
        }
    }

    //carrega os dados do registro a ser editado
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<form method="post">
    <input type="text" placeholder="USER NAME" name="name" value="<?php echo $client['name']; ?>">
    <input type="text" placeholder="USER EMAIL" name="email" value="<?php echo $client['email']; ?>">
    <select name="access" id="access">
        <option value="comum"<?php if ($client['access'] == 'comum') echo ' selected'; ?>>comum</option>
        <option value="administrator"<?php if ($client['access'] == 'administrator') echo ' selected'; ?>>administrator</option>
        <option value="moderator"<?php if ($client['access'] == 'moderator') echo ' selected'; ?>>moderator</option>
    </select>
    <input type="submit" value="Save Changes">
</form>

