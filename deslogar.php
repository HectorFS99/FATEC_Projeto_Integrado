<?php
session_start();
session_destroy();
echo "
<script>
    alert('Usuario foi desconectado com sucesso.');
    window.location.href = 'pagina-inicial.php';
</script>
";
exit();
?>
