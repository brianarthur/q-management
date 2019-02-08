<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

<?php
  $current = ($_SERVER['PHP_SELF']);
  if ($current == '/q-management/index.php') {
    echo '<script src="index_js.js"></script>';
  }
  elseif ($current == '/q-management/login/index.php') {

  }
?>

</body>
</html>
