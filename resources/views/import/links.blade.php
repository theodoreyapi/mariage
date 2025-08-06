<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Importation des utilisateurs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts (optionnel pour une belle typo) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: white;
        }

        .btn-whatsapp:hover {
            background-color: #1ebe5d;
            color: white;
        }
    </style>
</head>

<body class="py-5">

    <div class="container">

        <!-- Titre principal -->
        <div class="text-center mb-5">
            <h1 class="fw-bold">Gestion des utilisateurs WhatsApp</h1>
            {{-- <p class="text-muted">Importe un fichier Excel/CSV et envoie des messages WhatsApp facilement</p> --}}
        </div>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <a href="{{ route('home') }}" class="btn btn-info mb-3">⬅️ Retour à la page principale</a>

        <!-- Section tableau utilisateurs -->
        <div class="card">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Liste des utilisateurs enregistrés</h5>
                {{-- <button class="btn btn-whatsapp" onclick="sendToAll()">📲 Envoyer un message à tous</button> --}}
            </div>
            <div class="container mt-4">
                <h2>Liens WhatsApp avec le fichier</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Lien WhatsApp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td class="d-flex gap-2">
                                    <a target="_blank"
                                        href="https://wa.me/{{ $user->phone }}?text={{ urlencode($message . ' ' . $user->name) }}"
                                        class="btn btn-success">📲 Envoyer à {{ $user->name }}
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">🗑️ Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour envoyer à tous -->
    <script>
        function sendToAll() {
            const contacts = @json($users);

            contacts.forEach(user => {
                const message = `Bonjour ${user.name}, bienvenue dans notre service !`;
                const url = `https://wa.me/${user.phone}?text=${encodeURIComponent(message)}`;
                window.open(url, '_blank');
            });
        }
    </script>

</body>

</html>
