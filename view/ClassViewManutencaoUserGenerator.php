<?php
    namespace view;

    use lib\estClassFactory;

    require_once '../autoload.php';

    class ClassViewManutencaoUserGenerator {
      
      
      public function getConsultaPessoa() {
        estClassFactory::loadView('view\ClassViewManutencaoPessoa');
      }


      public function getConsultaCidade() {
        estClassFactory::loadView('view\ClassViewManutencaoCidade');
      }

    }

    $teste = new ClassViewManutencaoUserGenerator;
    $teste->getConsultaPessoa();
    $teste->getConsultaCidade();
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random User Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../lib/styles/styleEstClassViewManutencao.css">
</head>
<body>
  <div>

  </div>
</body>
</html>