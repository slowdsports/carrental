<?php
// Autenticación de admin (antes de cualquier salida HTML para poder hacer redirect)
$csLoginError = '';
if (isset($_POST['cs_login'])) {
    $csUser = trim($_POST['cs_username'] ?? '');
    $csPass = md5(trim($_POST['cs_password'] ?? ''));

    $csQuery = $dbh->prepare(
        "SELECT a.id, a.UserName FROM admin a WHERE a.UserName=:u AND a.Password=:p"
    );
    $csAdmin = false;
    if ($csQuery) {
        $csQuery->bindParam(':u', $csUser, PDO::PARAM_STR);
        $csQuery->bindParam(':p', $csPass, PDO::PARAM_STR);
        $csQuery->execute();
        $csAdmin = $csQuery->fetch(PDO::FETCH_OBJ);
    }

    if ($csAdmin) {
        $_SESSION['alogin']   = $csAdmin->UserName;
        $_SESSION['aadminid'] = $csAdmin->id;
        // Construir la URL raíz del sitio (funciona en local /carrental/ y en producción /)
        $csBase = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        header('Location: ' . ($csBase ? $csBase . '/' : '/'));
        exit;
    } else {
        $csLoginError = 'Credenciales inválidas';
    }
}
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Próximamente — Destiny Rent a Car</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #07101f;
            color: #dde3ef;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            position: relative;
        }

        /* Gradient blob background */
        body::before {
            content: '';
            position: fixed;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 800px;
            background: radial-gradient(ellipse at center, rgba(0, 74, 173, 0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .cs-logo {
            margin-bottom: 52px;
        }
        .cs-logo img {
            height: 52px;
            width: auto;
            filter: brightness(1.1);
        }

        .cs-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #3a7bd5;
            margin-bottom: 20px;
            text-align: center;
        }

        .cs-title {
            font-size: clamp(48px, 10vw, 88px);
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1;
            color: #ffffff;
            text-align: center;
            margin-bottom: 8px;
        }
        .cs-title span { color: #3a7bd5; }

        .cs-divider {
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, #004aad, #3a7bd5);
            border-radius: 2px;
            margin: 32px auto 32px;
        }

        .cs-subtitle {
            font-size: 16px;
            font-weight: 300;
            color: #7a8eaa;
            max-width: 420px;
            text-align: center;
            line-height: 1.7;
        }

        /* Admin trigger — esquina inferior derecha */
        .cs-admin-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 7px;
            color: #4a5a72;
            font-family: inherit;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }
        .cs-admin-btn:hover {
            background: rgba(0, 74, 173, 0.15);
            border-color: rgba(0, 74, 173, 0.35);
            color: #a0b4cc;
        }
        .cs-admin-btn svg { flex-shrink: 0; }

        /* Modal overlay */
        .cs-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 5, 15, 0.75);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .cs-overlay.open { display: flex; }

        .cs-modal {
            background: #0f1929;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 40px 36px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.7);
            position: relative;
        }

        .cs-modal-lock {
            width: 44px;
            height: 44px;
            background: rgba(0, 74, 173, 0.15);
            border: 1px solid rgba(0, 74, 173, 0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .cs-modal h2 {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }
        .cs-modal p.sub {
            font-size: 13px;
            color: #6a7d95;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .cs-field {
            margin-bottom: 14px;
        }
        .cs-field label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #7a8eaa;
            margin-bottom: 7px;
        }
        .cs-field input {
            width: 100%;
            padding: 10px 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: #dde3ef;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }
        .cs-field input::placeholder { color: #3a4d63; }
        .cs-field input:focus {
            border-color: #004aad;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.2);
        }

        .cs-error {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(229, 72, 77, 0.1);
            border: 1px solid rgba(229, 72, 77, 0.25);
            color: #e5484d;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .cs-submit {
            width: 100%;
            margin-top: 8px;
            padding: 11px;
            background: #004aad;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.18s, transform 0.1s;
        }
        .cs-submit:hover { background: #0058cc; }
        .cs-submit:active { transform: scale(0.98); }

        .cs-cancel {
            display: block;
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
            color: #4a5a72;
            cursor: pointer;
            transition: color 0.18s;
        }
        .cs-cancel:hover { color: #dde3ef; }
    </style>
</head>
<body>

    <div class="cs-logo">
        <img src="assets/images/logob.png" alt="Destiny Rent a Car">
    </div>

    <p class="cs-eyebrow">San Pedro Sula, Honduras</p>

    <h1 class="cs-title">Próxima<span>mente</span></h1>

    <div class="cs-divider"></div>

    <p class="cs-subtitle">
        Estamos preparando algo especial para ti.<br>
        Renta tu vehículo ideal en San Pedro Sula — flota moderna, kilómetros ilimitados y retiro en aeropuerto.
    </p>

    <!-- Botón admin (esquina inferior derecha) -->
    <button class="cs-admin-btn" onclick="document.getElementById('csOverlay').classList.add('open')">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        Admin
    </button>

    <!-- Modal de login -->
    <div class="cs-overlay<?= $csLoginError ? ' open' : ''; ?>" id="csOverlay">
        <div class="cs-modal">

            <div class="cs-modal-lock">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3a7bd5" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>

            <h2>Acceso administrativo</h2>
            <p class="sub">Inicia sesión con tu cuenta de admin para ver el sitio en desarrollo.</p>

            <?php if ($csLoginError): ?>
            <div class="cs-error">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <?= htmlentities($csLoginError); ?>
            </div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="cs_login" value="1">
                <div class="cs-field">
                    <label for="cs_username">Usuario</label>
                    <input type="text" id="cs_username" name="cs_username" autocomplete="username" required autofocus>
                </div>
                <div class="cs-field">
                    <label for="cs_password">Contraseña</label>
                    <input type="password" id="cs_password" name="cs_password" autocomplete="current-password" required>
                </div>
                <button type="submit" class="cs-submit">Iniciar sesión</button>
            </form>

            <span class="cs-cancel" onclick="document.getElementById('csOverlay').classList.remove('open')">Cancelar</span>
        </div>
    </div>

</body>
</html>
