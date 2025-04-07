<?php
require __DIR__ . '/vendor/autoload.php';
use App\BookSearch;

// Initialize search
$apiKey = ''; // Your API key here if you have one
$search = new BookSearch($apiKey);

// Get search parameters
$search_query = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$max_results = 10;
$start_index = ($page - 1) * $max_results;

// Perform search if query is provided
$books = [];
$total_items = 0;
if (!empty($search_query)) {
    $result = $search->search($search_query, $start_index, $max_results);
    $books = $result['items'] ?? [];
    $total_items = $result['totalItems'] ?? 0;
}

// Calculate pagination
$total_pages = ceil($total_items / $max_results);
$total_pages = min($total_pages, 10); // Limit to 10 pages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Google Books Search - e-Library BRIDA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .navbar-brand img {
            height: 40px;
        }
        
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
        }
        
        .book-cover {
            max-width: 100px;
            max-height: 150px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 0.25rem;
        }
        
        .book-title {
            font-weight: bold;
            font-size: 1.1em;
            color: #003366;
        }
        
        .book-author {
            font-style: italic;
            color: #6c757d;
        }
        
        .book-description {
            margin-top: 5px;
            font-size: 0.9em;
            color: #495057;
        }
        
        .btn-clear {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-clear:hover {
            background-color: #c82333;
            color: white;
        }
        
        .search-container {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 2rem;
        }
        
        .search-title {
            color: #003366;
            margin-bottom: 1.5rem;
        }
        
        .pagination .page-link {
            color: #003366;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #003366;
            border-color: #003366;
        }
        
        .footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/img/instansi-logo.png" alt="Logo BRIDA" class="me-2">
                <span class="fw-bold">E-Library BRIDA</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header text-center py-3" style="background-color: #003366; color: white;">
                        <i class="fas fa-book me-1"></i>
                        <i class="fas fa-search me-1"></i>
                        <span>Pencarian Buku Google</span>
                        <i class="fas fa-search ms-1"></i>
                        <i class="fas fa-book ms-1"></i>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <div class="search-container">
                            <h4 class="search-title text-center">Cari Buku dari Google Books</h4>
                            <form method="GET" action="" class="row g-3" id="searchForm">
                                <div class="col-lg-10 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-search text-primary"></i>
                                        </span>
                                        <input class="form-control" type="text" id="search" name="search" 
                                            placeholder="Cari Judul Buku, Penulis, atau ISBN" 
                                            value="<?php echo htmlspecialchars($search_query); ?>"
                                            aria-label="Cari Judul Buku, Penulis, atau ISBN">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-clear me-2" id="clearSearch">
                                        <i class="fas fa-times"></i> Clear
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        <?php if (!empty($search_query)): ?>
                            <div class="mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0">Hasil Pencarian: "<?php echo htmlspecialchars($search_query); ?>"</h4>
                                    <div>
                                        <span class="badge bg-primary me-2"><?php echo number_format($total_items); ?> total buku</span>
                                        <span class="badge bg-secondary"><?php echo count($books); ?> buku di halaman ini</span>
                                    </div>
                                </div>
                                
                                <?php if (empty($books)): ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Tidak ada hasil yang ditemukan. Silakan coba dengan kata kunci lain.
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($books as $book): ?>
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <?php if (isset($book['volumeInfo']['imageLinks']['thumbnail'])): ?>
                                                                    <img src="<?php echo htmlspecialchars($book['volumeInfo']['imageLinks']['thumbnail']); ?>" 
                                                                         alt="Book Cover" class="book-cover img-fluid">
                                                                <?php else: ?>
                                                                    <div class="book-cover bg-light d-flex align-items-center justify-content-center">
                                                                        <i class="fas fa-book fa-3x text-muted"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="book-details">
                                                                    <div class="book-title">
                                                                        <?php echo htmlspecialchars($book['volumeInfo']['title']); ?>
                                                                    </div>
                                                                    <div class="book-author">
                                                                        <?php 
                                                                        if (isset($book['volumeInfo']['authors'])) {
                                                                            echo htmlspecialchars(implode(', ', $book['volumeInfo']['authors']));
                                                                        } else {
                                                                            echo "Penulis tidak diketahui";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="book-description">
                                                                        <?php 
                                                                        if (isset($book['volumeInfo']['description'])) {
                                                                            $description = $book['volumeInfo']['description'];
                                                                            if (strlen($description) > 150) {
                                                                                $description = substr($description, 0, 150) . '...';
                                                                            }
                                                                            echo htmlspecialchars($description);
                                                                        } else {
                                                                            echo "Deskripsi tidak tersedia";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="book-link mt-2">
                                                                        <a href="<?php echo htmlspecialchars($book['volumeInfo']['infoLink'] ?? '#'); ?>" 
                                                                           class="btn btn-sm btn-primary" target="_blank">
                                                                            <i class="fas fa-external-link-alt"></i> Detail
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Pagination -->
                                    <?php if ($total_pages > 1): ?>
                                        <nav aria-label="Page navigation" class="mt-4">
                                            <ul class="pagination justify-content-center">
                                                <?php if ($page > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search_query); ?>&page=<?php echo $page - 1; ?>">
                                                            <i class="fas fa-chevron-left"></i> Previous
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                
                                                <?php
                                                $start_page = max(1, $page - 2);
                                                $end_page = min($total_pages, $page + 2);
                                                
                                                if ($start_page > 1) {
                                                    echo '<li class="page-item"><a class="page-link" href="?search=' . urlencode($search_query) . '&page=1">1</a></li>';
                                                    if ($start_page > 2) {
                                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                    }
                                                }
                                                
                                                for ($i = $start_page; $i <= $end_page; $i++) {
                                                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">';
                                                    echo '<a class="page-link" href="?search=' . urlencode($search_query) . '&page=' . $i . '">' . $i . '</a>';
                                                    echo '</li>';
                                                }
                                                
                                                if ($end_page < $total_pages) {
                                                    if ($end_page < $total_pages - 1) {
                                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                    }
                                                    echo '<li class="page-item"><a class="page-link" href="?search=' . urlencode($search_query) . '&page=' . $total_pages . '">' . $total_pages . '</a></li>';
                                                }
                                                ?>
                                                
                                                <?php if ($page < $total_pages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search_query); ?>&page=<?php echo $page + 1; ?>">
                                                            Next <i class="fas fa-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-3 mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted"> &copy; KKP Ilmu Komputer UHO 2025</div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            // Cek apakah reload terjadi karena tombol search
            if (!sessionStorage.getItem("searchReload")) {
                localStorage.removeItem("search");
            }

            // Reset indikator setelah halaman dimuat
            sessionStorage.removeItem("searchReload");

            // Tambahkan event listener pada form
            document.getElementById("searchForm").addEventListener("submit", function () {
                sessionStorage.setItem("searchReload", "1");
            });

            // Ambil nilai pencarian dari localStorage dan isi kembali form pencarian
            if (localStorage.getItem('search')) {
                $('#search').val(localStorage.getItem('search'));
            }

            // Simpan nilai pencarian di localStorage sebelum halaman di-reload
            $('#searchForm').on('submit', function(e) {
                localStorage.setItem('search', $('#search').val());
            });

            // Tambahkan fungsi untuk tombol "Clear" untuk menghapus pencarian
            $('#clearSearch').on('click', function() {
                $('#search').val('');
                localStorage.removeItem('search');
                window.location.href = 'books-api.php';
            });
        });
    </script>
</body>
</html>