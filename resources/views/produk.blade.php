<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $var_produk['Nama'] }} — Official Store</title>

    <!-- Tipografi: Fraunces (Serif Editorial), DM Sans (UI), JetBrains Mono (Harga/SKU) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=Fraunces:opsz,wght@9..144,500;9..144,600&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #f6f5f1;
            --bg-surface: #ffffff;
            --bg-subtle: #eceae3;
            --text-primary: #191817;
            --text-secondary: #686662;
            --border-line: #dedbd2;
            --accent: #c84b31;
            --accent-dark: #191817;
            --success: #2a6f48;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Navbar Atas */
        .navbar {
            border-bottom: 1px solid var(--border-line);
            background-color: var(--bg-main);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .nav-container {
            max-width: 1160px;
            margin: 0 auto;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-family: 'Fraunces', serif;
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            text-decoration: none;
            color: var(--text-primary);
        }

        .nav-meta {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Layout Utama Halaman Produk */
        .page-wrapper {
            max-width: 1160px;
            margin: 48px auto;
            padding: 0 24px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 56px;
            align-items: start;
        }

        /* Galeri Foto Produk (Kiri) */
        .gallery-column {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .main-photo-box {
            position: relative;
            background-color: var(--bg-subtle);
            border: 1px solid var(--border-line);
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 4 / 3.6;
        }

        .main-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .main-photo-box:hover img {
            transform: scale(1.03);
        }

        .status-pill {
            position: absolute;
            top: 16px;
            left: 16px;
            background-color: var(--bg-surface);
            border: 1px solid var(--border-line);
            padding: 6px 12px;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            background-color: var(--success);
            border-radius: 50%;
        }

        .thumb-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .thumb-item {
            aspect-ratio: 4 / 3;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            background-color: var(--bg-subtle);
            opacity: 0.65;
            transition: all 0.2s ease;
        }

        .thumb-item.active,
        .thumb-item:hover {
            opacity: 1;
            border-color: var(--text-primary);
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Informasi Produk (Kanan) */
        .details-column {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-line);
            border-radius: 14px;
            padding: 36px;
        }

        .breadcrumb {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .product-name {
            font-family: 'Fraunces', serif;
            font-size: 2.25rem;
            font-weight: 500;
            line-height: 1.15;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .price-box {
            background-color: var(--bg-main);
            border: 1px solid var(--border-line);
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .price-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .price-nominal {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.55rem;
            font-weight: 600;
            color: var(--accent);
        }

        .description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin-bottom: 28px;
            line-height: 1.65;
        }

        /* Spesifikasi Ringkas */
        .spec-list {
            border-top: 1px solid var(--border-line);
            border-bottom: 1px solid var(--border-line);
            padding: 16px 0;
            margin-bottom: 28px;
            display: grid;
            gap: 10px;
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.88rem;
        }

        .spec-key {
            color: var(--text-secondary);
        }

        .spec-val {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Baris Aksi & Kuantitas */
        .purchase-controls {
            display: flex;
            gap: 12px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-line);
            border-radius: 8px;
            background-color: var(--bg-main);
        }

        .qty-btn {
            width: 40px;
            height: 48px;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            cursor: pointer;
            color: var(--text-primary);
        }

        .qty-input {
            width: 36px;
            text-align: center;
            border: none;
            background: transparent;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .btn-checkout {
            flex: 1;
            background-color: var(--accent-dark);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0 24px;
            height: 50px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-checkout:hover {
            background-color: var(--accent);
        }

        /* Responsif untuk Layar HP/Tablet */
        @media (max-width: 860px) {
            .product-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .page-wrapper {
                margin: 24px auto;
            }

            .details-column {
                padding: 24px;
            }

            .product-name {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Toko -->
    <header class="navbar">
        <div class="nav-container">
            <a href="#" class="brand">ATELIER KARYA.</a>
            <span class="nav-meta">KATALOG RESMI / {{ date('Y') }}</span>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="page-wrapper">
        <section class="product-grid">

            <!-- Kolom Kiri: Foto Produk -->
            <div class="gallery-column">
                <div class="main-photo-box">
                    <div class="status-pill">
                        <span class="status-dot"></span>
                        Stok Tersedia
                    </div>
                    <!-- Mengambil $var_produk['Foto'] jika ada, atau memakai foto kamera studio sebagai default -->
                    <img 
                        id="mainProductImage"
                        src="{{ $var_produk['Foto'] ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1200&q=85' }}" 
                        alt="{{ $var_produk['Nama'] }}"
                    >
                </div>

                <!-- Pilihan Sudut Foto (Klik untuk mengganti gambar utama) -->
                <div class="thumb-list">
                    <div class="thumb-item active" onclick="changePhoto(this, '{{ $var_produk['Foto'] ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1200&q=85' }}')">
                        <img src="{{ $var_produk['Foto'] ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=400&q=80' }}" alt="Tampak Depan">
                    </div>
                    <div class="thumb-item" onclick="changePhoto(this, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=85')">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=400&q=80" alt="Tampak Samping">
                    </div>
                    <div class="thumb-item" onclick="changePhoto(this, 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=1200&q=85')">
                        <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=400&q=80" alt="Detail Produk">
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Detail & Harga -->
            <div class="details-column">
                <p class="breadcrumb">Halaman Produk &bull; Edisi Reguler</p>
                
                <!-- Nama Produk dari Controller -->
                <h1 class="product-name">{{ $var_produk['Nama'] }}</h1>

                <!-- Harga Produk dari Controller -->
                <div class="price-box">
                    <span class="price-label">Harga Satuan</span>
                    <span class="price-nominal">
                        Rp {{ is_numeric($var_produk['Harga']) ? number_format($var_produk['Harga'], 0, ',', '.') : $var_produk['Harga'] }}
                    </span>
                </div>

                <p class="description">
                    Dirancang dengan material pilihan dan standar pengerjaan presisi. Produk <strong>{{ $var_produk['Nama'] }}</strong> dikurasi khusus untuk pemakaian jangka panjang dengan jaminan keaslian resmi.
                </p>

                <div class="spec-list">
                    <div class="spec-row">
                        <span class="spec-key">Kondisi</span>
                        <span class="spec-val">Baru &amp; Bersegel</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-key">Pengiriman</span>
                        <span class="spec-val">Siap Kirim Hari Ini</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-key">Garansi</span>
                        <span class="spec-val">1 Tahun Garansi Toko</span>
                    </div>
                </div>

                <!-- Kontrol Pembelian -->
                <div class="purchase-controls">
                    <div class="qty-control">
                        <button type="button" class="qty-btn" onclick="updateQty(-1)">&minus;</button>
                        <input type="text" id="qtyInput" class="qty-input" value="1" readonly>
                        <button type="button" class="qty-btn" onclick="updateQty(1)">&plus;</button>
                    </div>
                    <button type="button" class="btn-checkout">Beli Sekarang</button>
                </div>
            </div>

        </section>
    </main>

    <!-- Script Interaksi Galeri & Kuantitas -->
    <script>
        function changePhoto(element, srcUrl) {
            document.getElementById('mainProductImage').src = srcUrl;
            document.querySelectorAll('.thumb-item').forEach(item => item.classList.remove('active'));
            element.classList.add('active');
        }

        function updateQty(change) {
            const input = document.getElementById('qtyInput');
            let current = parseInt(input.value) || 1;
            if (current + change >= 1) {
                input.value = current + change;
            }
        }
    </script>

</body>
</html>