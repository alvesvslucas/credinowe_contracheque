<?php
$senha_digitada = "123456"; // Substitua pela senha que está tentando usar no login
$hash_no_banco = '$2y$10$9/5KJXz92Ldxagfhmidni.y6WLrf4IyW0flWrMsFumbKjvfPuHpjK'; // Substitua pelo hash armazenado no banco

if (password_verify($senha_digitada, $hash_no_banco)) {
    echo "Senha válida!";
} else {
    echo "Senha inválida!";
}
?>

<?php
echo password_hash("123456", PASSWORD_DEFAULT);
?>
