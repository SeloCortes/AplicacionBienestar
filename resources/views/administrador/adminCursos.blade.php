<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Administrador Cursos</title>
</head>
<body>
    <div style="padding: 20px; font-family: sans-serif;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom: 20px;">
            <h1 style="margin: 0;">Vista Administrador Cursos</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="cursor: pointer; padding: 8px 16px; background: #ef4444; color: white; border: none; border-radius: 4px; font-weight: bold;">
                    Cerrar sesión
                </button>
            </form>
        </div>
        
        {{-- Aquí iría la lista de cursos del administrador --}}
        <ul>

        </ul>
    </div>
</body>
</html>