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
            <p class="text-muted">Importe un fichier Excel/CSV et envoie des messages WhatsApp facilement</p>
        </div>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Carte Import -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Importer un fichier d'utilisateurs</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier Excel ou CSV</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">Fichier à envoyer par WhatsApp (PDF, Image,
                            etc.)</label>
                        <input type="file" name="attachment" id="attachment" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message WhatsApp</label>
                        <textarea name="message" id="message" rows="3" class="form-control"
                            placeholder="Bonjour, veuillez trouver le document ci-joint :"></textarea>
                    </div>

                    <button class="btn btn-primary">📥 Importer & Générer les liens</button>
                </form>

            </div>
        </div>

        <!-- Section tableau utilisateurs -->
        {{-- <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Liste des utilisateurs enregistrés</h5>
                <button class="btn btn-whatsapp" onclick="sendToAll()">📲 Envoyer un message à tous</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Téléphone</th>
                                <th>Action WhatsApp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ $user->phone }}?text={{ urlencode("Bonjour {$user->name}, bienvenue dans notre service !") }}"
                                            target="_blank" class="btn btn-sm btn-whatsapp">
                                            ✉️ Envoyer
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun utilisateur trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}

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
