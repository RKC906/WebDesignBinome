<?php
/**
 * Fichier de test de connexion à la base de données
 * À SUPPRIMER en production
 */

// Inclure la configuration
require_once 'config/db.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Connexion BDD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .success {
            color: #155724;
            background: #d4edda;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .info {
            color: #004085;
            background: #d1ecf1;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
            margin-top: 20px;
        }
        .error {
            color: #721c24;
            background: #f8d7da;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #f5c6cb;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Test de Connexion à la Base de Données</h1>

        <?php
        try {
            // Tester la connexion
            $query = "SELECT version();";
            $result = $pdo->query($query);
            $version = $result->fetch();

            echo '<div class="success">
                    <strong>✅ Connexion réussie !</strong><br>
                    Version PostgreSQL : ' . $version['version'] . '
                  </div>';

            // Afficher les tables
            echo '<div class="info">
                    <strong>📊 Tables présentes :</strong>';

            $query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';";
            $result = $pdo->query($query);
            $tables = $result->fetchAll();

            if (!empty($tables)) {
                echo '<table>
                        <thead>
                            <tr>
                                <th>Table</th>
                                <th>Colonnes</th>
                            </tr>
                        </thead>
                        <tbody>';

                foreach ($tables as $table) {
                    $table_name = $table['table_name'];

                    // Compter les colonnes
                    $col_query = "SELECT COUNT(*) as count FROM information_schema.columns WHERE table_name = ?;";
                    $col_stmt = $pdo->prepare($col_query);
                    $col_stmt->execute([$table_name]);
                    $col_count = $col_stmt->fetch()['count'];

                    echo '<tr>
                            <td><code>' . htmlspecialchars($table_name) . '</code></td>
                            <td>' . $col_count . ' colonnes</td>
                          </tr>';
                }

                echo '</tbody>
                      </table>';
            } else {
                echo '<p style="color: #856404; background: #fff3cd; padding: 10px; border-radius: 3px; border-left: 4px solid #ffc107;">
                        Aucune table trouvée. Vérifiez que le script init SQL a été exécuté.
                      </p>';
            }

            echo '</div>';

            // Variables d'environnement
            echo '<div class="info">
                    <strong>🔧 Variables d\'environnement :</strong>
                    <table>
                        <tr>
                            <td><code>POSTGRES_HOST</code></td>
                            <td>' . htmlspecialchars(getenv('POSTGRES_HOST') ?: 'localhost') . '</td>
                        </tr>
                        <tr>
                            <td><code>POSTGRES_USER</code></td>
                            <td>' . htmlspecialchars(getenv('POSTGRES_USER') ?: 'webdesignuser') . '</td>
                        </tr>
                        <tr>
                            <td><code>POSTGRES_DB</code></td>
                            <td>' . htmlspecialchars(getenv('POSTGRES_DB') ?: 'webdesigndb') . '</td>
                        </tr>
                    </table>
                  </div>';

        } catch (Exception $e) {
            echo '<div class="error">
                    <strong>❌ Erreur :</strong><br>
                    ' . htmlspecialchars($e->getMessage()) . '
                  </div>';
        }
        ?>
    </div>
</body>
</html>
