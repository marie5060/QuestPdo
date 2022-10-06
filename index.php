<?php

require 'connect.php';

 $pdo= new Pdo("mysql:host=$servername;dbname=$dbname" , $username, $password);
  
 //function test champs
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //initialise errors 
  $errors = [];

   // je recupere ma liste de friends puis je boucle dans un ul
    $query = "SELECT * FROM friend";
    $statement = $pdo->query($query);
    $friends = $statement->fetchAll(PDO::FETCH_ASSOC);?>


<ul>
    <?php foreach($friends as $friend) : ?>
    <li><?php echo $friend['firstname'] . ' ' . $friend['lastname'] . "<br>"; ?></li>
    <?php endforeach;?>
</ul>
<?php

// get the data from a form
// si je fais un post 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

//si mon champ lastname est vide je renvoi une erreur
if (empty($_POST["lastname"])){
echo "lastname is required";}

//si mon champ firstname est vide je renvoi une erreur
else if (empty($_POST["firstname"])){
echo "firstname is required";}

//sinon je poste
else { 
    
    if (isset($_POST['firstname'], $_POST['lastname'])) {
$firstname = test_input($_POST['firstname']);
$lastname = test_input($_POST['lastname']);

//je prepare ma query
$query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
$statement = $pdo->prepare($query);

$statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
$statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

$statement->execute(['firstname'=>$_POST['firstname'], 'lastname'=>$_POST['lastname']]);

header('Location: index.php');
}}}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quete PDO</title>
</head>

<body>
    <form method=post>
        <div>
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname">

        </div>
        <div>
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname">
        </div>
        <div>
            <button type="submit">Submit</button>
    </form>
</body>

</html>