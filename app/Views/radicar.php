<div class="cabecera-pagina">
    <div>
        <p class="sobrelinea">Ventanilla</p>
        <h1>Radicar solicitud</h1>
        <p>Punto de atención · Comuna <?= e($usuario['punto']) ?></p>
    </div>
</div>
<?php if ($radicada): ?><p class="exito" role="status">Solicitud #<?= e($radicada) ?> registrada.</p><?php endif; ?>
<?php if ($errores): ?>
    <ul class="error" role="alert">
        <?php foreach ($errores as $campo => $error): ?>
            <li><a href="#<?= e($campo) ?>"><?= e($error) ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form method="post" class="panel">
    <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
    <h2>Datos de la solicitud</h2>
    <div class="campos">
        <?php foreach (['nombres' => 'Nombres', 'apellidos' => 'Apellidos', 'celular' => 'Celular', 'direccion' => 'Dirección'] as $campo => $etiqueta): ?>
            <label><?= e($etiqueta) ?>
                <input id="<?= e($campo) ?>" name="<?= e($campo) ?>" value="<?= e($datos[$campo] ?? '') ?>" required>
            </label>
        <?php endforeach; ?>
        <label>Zona
            <select name="zona" id="zona">
                <option value="urbana">Urbana</option>
                <option value="rural" <?= ($datos['zona'] ?? '') === 'rural' ? 'selected' : '' ?>>Rural</option>
            </select>
        </label>
        <label>Comuna
            <select name="comuna" id="comuna">
                <option value="">Selecciona</option>
                <?php for ($n = 1; $n <= 22; $n++): ?>
                    <option value="<?= $n ?>" <?= (string) ($datos['comuna'] ?? '') === (string) $n ? 'selected' : '' ?>>Comuna <?= $n ?></option>
                <?php endfor; ?>
            </select>
        </label>
        <label>Barrio
            <select id="barrio" name="barrio">
                <option value="">Selecciona</option>
                <?php foreach (territorio()['barrios'] as $comuna => $barrios): ?>
                    <optgroup label="Comuna <?= e($comuna) ?>" data-comuna="<?= e($comuna) ?>">
                        <?php foreach ($barrios as $barrio): ?>
                            <option value="<?= e($barrio) ?>" <?= ($datos['comuna'] ?? '') === (string) $comuna && ($datos['barrio'] ?? '') === $barrio ? 'selected' : '' ?>><?= e($barrio) ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Corregimiento
            <select name="corregimiento" id="corregimiento">
                <option value="">Selecciona</option>
                <?php foreach (territorio()['corregimientos'] as $corregimiento): ?>
                    <option <?= ($datos['corregimiento'] ?? '') === $corregimiento ? 'selected' : '' ?>><?= e($corregimiento) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <h2>Ubicación de la visita</h2>
    <p>Marca el sitio en el mapa o escribe las coordenadas.</p>
    <div id="mapa" aria-label="Mapa de Cali"></div>
    <div class="campos">
        <label>Latitud <input id="latitud" name="latitud" inputmode="decimal" value="<?= e($datos['latitud'] ?? '') ?>" required></label>
        <label>Longitud <input id="longitud" name="longitud" inputmode="decimal" value="<?= e($datos['longitud'] ?? '') ?>" required></label>
    </div>
    <button name="accion" value="radicar">Guardar solicitud</button>
</form>
