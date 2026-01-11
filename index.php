<?php
// Valores predeterminados
$numero_uno = '';
$numero_dos = '';
$operacion = 'sumar';
$resultado = null;
$msg_error = '';

function esunNumeroValido($in_numero) {
  // Permite el ingreso de numeros enteros, decimales y negativos
  $in_numero = trim((string)$in_numero);
  if ($in_numero === '') return false;
  return is_numeric($in_numero);
}
// obtengo los valores del motodo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $numero_uno = $_POST['numero_uno'] ?? '';
  $numero_dos = $_POST['numero_dos'] ?? '';
  $operacion = $_POST['operacion'] ?? 'sumar';

  // cALCULOS Y Validaciones
  if (!esunNumeroValido($numero_uno) || !esunNumeroValido($numero_dos)) {
    $msg_error = 'Ingresa números válidos en los campos.';
  } else {
    $x = (float)$numero_uno;
    $y = (float)$numero_dos;

    switch ($operacion) {
      case 'sumar':
        $resultado = $x + $y;
        break;
      case 'restar':
        $resultado = $x - $y;
        break;
      case 'multiplicar':
        $resultado = $x * $y;
        break;
      case 'dividir':
        if ($y == 0.0) {
          $msg_error = '¡ERROR! No se puede dividir para 0.';
        } else {
          $resultado = $x / $y;
        }
        break;
      default:
        $msg_error = '¡ERROR! Operación inválida.';
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Calculadora PHP</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="card">
    <h1>Calculadora</h1>
    <p class="subtitle">Semana 1 - Tarea 1</p>

    <form method="post" class="form" novalidate>
      <label>
        Número 1
        <input
          type="text"
          name="numero_uno"
          inputmode="decimal"
          placeholder="Ejemplo: 5.25"
          value="<?= htmlspecialchars((string)$numero_uno) ?>"
          required
        />
      </label>

      <label>
        Operación
        <select name="operacion">
          <option value="sumar" <?= $operacion === 'sumar' ? 'selected' : '' ?>>(+) Sumar</option>
          <option value="restar" <?= $operacion === 'restar' ? 'selected' : '' ?>>(−) Restar </option>
          <option value="multiplicar" <?= $operacion === 'multiplicar' ? 'selected' : '' ?>>(×) Multiplicar</option>
          <option value="dividir" <?= $operacion === 'dividir' ? 'selected' : '' ?>>(÷) Dividir</option>
        </select>
      </label>

      <label>
        Número 2
        <input
          type="text"
          name="numero_dos"
          inputmode="decimal"
          placeholder="Ejemplo: 2"
          value="<?= htmlspecialchars((string)$numero_dos) ?>"
          required
        />
      </label>

      <div class="actions">
        <button type="submit">Calcular</button>
        <a class="btn-secondary" href="index.php">Limpiar</a>
      </div>
    </form>

    <?php if ($msg_error): ?>
      <div class="alert error"><?= htmlspecialchars($msg_error) ?></div>
    <?php elseif ($resultado !== null): ?>
      <div class="alert ok">
        Resultado: <strong><?= rtrim(rtrim((string)$resultado)) ?></strong>
      </div>
    <?php else: ?>
      <div class="hint">Ingresa dos números y elige una operación.</div>
    <?php endif; ?>
  </main>
</body>
</html>
