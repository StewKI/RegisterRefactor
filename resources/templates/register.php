<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register</title>
    <style>
        :root{
            --bg:#f3f6fb;
            --card:#ffffff;
            --accent:#2563eb;
            --muted:#6b7280;
            --radius:12px;
            --maxw:420px;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        *{box-sizing:border-box}
        html,body{height:100%}
        body{
            margin:0;
            background:linear-gradient(180deg,var(--bg),#eef4ff);
            display:flex;
            align-items:center;
            justify-content:center;
            padding:32px;
            color:#111827;
        }

        .card{
            background:var(--card);
            width:100%;
            max-width:var(--maxw);
            border-radius:var(--radius);
            box-shadow:0 8px 24px rgba(16,24,40,0.08);
            padding:28px;
        }

        h1{
            margin:0 0 22px 0;
            font-size:20px;
            font-weight:600;
        }
        p{
            margin:0 0 18px 0;
            color:var(--muted);
            font-size:13px;
        }

        form {
            display:grid;
            gap:12px;
        }

        label{
            font-size:13px;
            display:block;
            margin-bottom:6px;
            color:#374151;
        }

        .field{
            display:flex;
            flex-direction:column;
        }

        input[type="email"],
        input[type="password"]{
            padding:10px 12px;
            border-radius:8px;
            border:1px solid #e6e9ef;
            outline:none;
            font-size:14px;
            background:transparent;
        }

        input[type="email"]:focus,
        input[type="password"]:focus{
            box-shadow:0 0 0 4px rgba(37,99,235,0.08);
            border-color:var(--accent);
        }

        .actions{
            display:flex;
            gap:10px;
            align-items:center;
            margin-top:6px;
        }

        button[type="submit"]{
            appearance:none;
            border:0;
            padding:10px 14px;
            border-radius:10px;
            background:var(--accent);
            color:#fff;
            font-weight:600;
            cursor:pointer;
            font-size:14px;
        }

        button[type="submit"]:active{transform:translateY(1px)}

        @media (max-width:420px){
            body{padding:16px}
            .card{padding:20px}
        }
    </style>
</head>
<body>
<main class="card" role="main">
    <h1>Create account</h1>

    <form method="post" action="/register" autocomplete="on" novalidate>
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required autocomplete="email" placeholder="you@example.com" />
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" placeholder="At least 8 characters" />
        </div>

        <div class="field">
            <label for="password2">Confirm password</label>
            <input id="password2" name="password2" type="password" required minlength="8" autocomplete="new-password" placeholder="Repeat your password" />
        </div>

        <div class="actions">
            <button type="submit">Register</button>
        </div>
    </form>
</main>
</body>
</html>
