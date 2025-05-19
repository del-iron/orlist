<?php
$senha_digitada = '123456';
$senha_hash = '$2y$10$hHwc83.8AGSrNcG0BzTsDeVt431oRRTdO8/9WxdQw2k8Jv0dQoxyi'; // troque aqui se necessário

if (password_verify($senha_digitada, $senha_hash)) {
    echo "Senha válida!";
} else {
    echo "Senha inválida!";
}
