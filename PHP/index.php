<?php
include_once 'Produk.php';
session_start();

if (!isset($_SESSION['produk_list'])) {
    $_SESSION['produk_list'] = [];
}

$uploadDir = __DIR__ . '/uploads';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$MAX = 10;

function handleUpload($fileInputName) {
    global $uploadDir;
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] === UPLOAD_ERR_NO_FILE) {
        return "";
    }

    $f = $_FILES[$fileInputName];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $orig = basename($f['name']);
    $ext = pathinfo($orig, PATHINFO_EXTENSION);
    $uniq = time() . '_' . bin2hex(random_bytes(4));
    $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $uniq . ($ext ? '.' . $ext : ''));
    $target = $uploadDir . '/' . $safeName;

    if (move_uploaded_file($f['tmp_name'], $target)) {
        return 'uploads/' . $safeName;
    }
    return "";
}

$action = $_REQUEST['action'] ?? '';

if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (count($_SESSION['produk_list']) < $MAX) {
        $nama = trim($_POST['nama'] ?? '');
        $merek = trim($_POST['merek'] ?? '');
        $harga = intval($_POST['harga'] ?? 0);
        $stok = intval($_POST['stok'] ?? 0);
        $gambar = handleUpload('gambar');

        $p = new Produk($nama, $merek, $harga, $stok, $gambar);
        $_SESSION['produk_list'][] = $p->toArray();
        $msg = "Produk berhasil ditambahkan.";
    } else {
        $msg = "Kapasitas penuh (maks $MAX produk).";
    }
    header("Location: index.php?msg=" . urlencode($msg));
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $idx = isset($_POST['index']) ? intval($_POST['index']) : -1;
    if ($idx >= 0 && $idx < count($_SESSION['produk_list'])) {
        $nama = trim($_POST['nama'] ?? '');
        $merek = trim($_POST['merek'] ?? '');
        $harga = intval($_POST['harga'] ?? 0);
        $stok = intval($_POST['stok'] ?? 0);

        $gambarBaru = handleUpload('gambar');
        if ($gambarBaru !== "") {
            $gambarPath = $gambarBaru;
        } else {
            $gambarPath = $_SESSION['produk_list'][$idx]['gambarPath'] ?? '';
        }

        $p = new Produk($nama, $merek, $harga, $stok, $gambarPath);
        $_SESSION['produk_list'][$idx] = $p->toArray();
        $msg = "Produk berhasil diupdate.";
    } else {
        $msg = "Index produk tidak valid.";
    }
    header("Location: index.php?msg=" . urlencode($msg));
    exit;
}

if ($action === 'hapus') {
    $idx = isset($_GET['index']) ? intval($_GET['index']) : -1;
    if ($idx >= 0 && $idx < count($_SESSION['produk_list'])) {
        $gp = $_SESSION['produk_list'][$idx]['gambarPath'] ?? '';
        if ($gp) {
            $fp = __DIR__ . '/' . $gp;
            if (file_exists($fp)) {
                @unlink($fp);
            }
        }
        array_splice($_SESSION['produk_list'], $idx, 1);
        $msg = "Produk berhasil dihapus.";
    } else {
        $msg = "Index produk tidak valid.";
    }
    header("Location: index.php?msg=" . urlencode($msg));
    exit;
}

$editIndex = isset($_GET['edit']) ? intval($_GET['edit']) : -1;
$editData = null;
if ($editIndex >= 0 && $editIndex < count($_SESSION['produk_list'])) {
    $editData = $_SESSION['produk_list'][$editIndex];
}

$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ektronik — Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        
        :root{
            --bg: #f4f7fb;
            --panel: #ffffff;
            --muted: #6b7280;
            --accent: #0f6fff;
            --accent-2:#06b6d4;
            --danger: #ef4444;
            --table-border: #e6eef6;
            --radius:12px;
            --glass: rgba(255,255,255,0.6);
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: linear-gradient(180deg,#f8fbff 0%,var(--bg) 100%);
            color:#0f172a;
            -webkit-font-smoothing:antialiased;
            padding:28px;
        }
        .wrap{max-width:1100px;margin:0 auto}
        header.appbar{
            display:flex;align-items:center;justify-content:space-between;
            gap:12px;margin-bottom:18px;
        }
        .brand{
            display:flex;align-items:center;gap:12px;
        }
        .logo{
            width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent-2));
            display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;box-shadow:0 6px 18px rgba(15,23,42,0.08)
        }
        .brand h1{font-size:18px;margin:0}
        .lead{color:var(--muted);font-size:13px;margin-top:3px}

        
        .grid { display:grid; grid-template-columns: 360px 1fr; gap:18px; align-items:start; }
        @media (max-width:900px){ .grid{grid-template-columns:1fr} .side{order:2} .main{order:1} }

        
        .card{
            background:var(--panel); border-radius:var(--radius); padding:18px; box-shadow:0 6px 20px rgba(15,23,42,0.06);
        }
        .card h3{margin:0 0 10px 0;font-size:16px}
        label.field{display:block;margin:8px 0;font-size:13px;color:#111827}
        input[type="text"], input[type="number"], input[type="file"], textarea, select{
            width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e6edf6; background:transparent;
            outline:none;font-size:14px;color:#0f172a;
        }
        input[type="text"]:focus, input[type="number"]:focus{box-shadow:0 6px 18px rgba(15,23,42,0.04);border-color:var(--accent)}
        .form-row{display:flex;gap:8px}
        .form-row .col{flex:1}

        .btn{
            display:inline-flex;align-items:center;gap:8px;padding:10px 12px;border-radius:10px;border:none;cursor:pointer;
            background:var(--accent);color:#fff;font-weight:600;
            box-shadow:0 8px 20px rgba(15,23,42,0.08);
        }
        .btn.ghost{background:transparent;color:var(--accent);border:1px solid rgba(15,111,255,0.12);box-shadow:none}
        .muted{color:var(--muted);font-size:13px}
        .small{font-size:13px;color:var(--muted)}

        .preview{
            margin-top:8px;border-radius:8px;overflow:hidden;width:100%;height:120px;border:1px dashed #e6eef6;display:flex;align-items:center;justify-content:center;background:#fbfdff;
            color:var(--muted);
        }
        .preview img{max-width:100%;max-height:100%;object-fit:cover;display:block}

        
        .topbar{display:flex;align-items:center;gap:12px;margin-bottom:12px}
        .search{
            flex:1; display:flex;align-items:center;gap:8px;padding:10px 12px;border-radius:999px;background:linear-gradient(180deg,#fff,#fbfdff);
            border:1px solid #e9f0fb
        }
        .search input{border:none;outline:none;background:transparent;width:100%;font-size:14px}
        .badge{background:#eef2ff;color:var(--accent);padding:6px 10px;border-radius:999px;font-weight:700}

        .table-wrap{overflow:auto;border-radius:10px}
        table{width:100%;border-collapse:collapse;background:linear-gradient(180deg,#fff,#fcfdff);border:1px solid var(--table-border)}
        thead th{font-size:13px;text-align:left;padding:12px;border-bottom:1px solid var(--table-border);background:#fbfdff}
        td, th{padding:12px;border-bottom:1px solid var(--table-border);font-size:14px;vertical-align:middle}
        tbody tr:hover{background:linear-gradient(90deg, rgba(6,182,212,0.03), rgba(15,111,255,0.02));}
        td.center{text-align:center}

        img.thumb{width:120px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #eef7ff}

        .actions a{display:inline-block;margin-right:6px;padding:8px 10px;border-radius:8px;text-decoration:none;font-weight:600}
        .actions a.edit{background:#ecfeff;color:#055160;border:1px solid #c9fbf5}
        .actions a.del{background:#fff5f5;color:var(--danger);border:1px solid #ffdede}

        footer.note{margin-top:18px;color:var(--muted);font-size:13px;text-align:center}

        
        .modal-backdrop{position:fixed;inset:0;background:rgba(2,6,23,0.45);display:none;align-items:center;justify-content:center;z-index:60}
        .modal{background:var(--panel);padding:18px;border-radius:12px;max-width:420px;width:94%;box-shadow:0 20px 40px rgba(2,6,23,0.2)}
        .modal h4{margin:0 0 12px 0}
        .modal .buttons{display:flex;gap:8px;justify-content:flex-end;margin-top:12px}
    </style>
</head>
<body>
<div class="wrap">
<header class="appbar">
    <div class="brand">
        <div class="logo">TE</div>
        <div>
            <h1>Toko Elektronik</h1>
        </div>
    </div>
    <div style="text-align:right">
        <div class="small muted">Jumlah produk</div>
        <div class="badge"><?= count($_SESSION['produk_list']) ?>/<?= $MAX ?></div>
    </div>
</header>

<div class="grid">
    <!-- LEFT: form -->
    <aside class="side">
        <div class="card" id="formCard">
            <?php if ($editData): ?>
                <h3>Edit Produk #<?= $editIndex + 1 ?></h3>
                <form id="editForm" method="post" enctype="multipart/form-data" action="index.php?action=update">
                    <input type="hidden" name="index" value="<?= $editIndex ?>">
                    <label class="field">Nama:
                        <input type="text" name="nama" required value="<?= htmlspecialchars($editData['nama']) ?>">
                    </label>
                    <label class="field">Merek:
                        <input type="text" name="merek" required value="<?= htmlspecialchars($editData['merek']) ?>">
                    </label>
                    <div class="form-row">
                        <label class="field col">Harga:
                            <input type="number" name="harga" required value="<?= htmlspecialchars($editData['harga']) ?>">
                        </label>
                        <label class="field col">Stok:
                            <input type="number" name="stok" required value="<?= htmlspecialchars($editData['stok']) ?>">
                        </label>
                    </div>

                    <label class="field">Gambar (upload baru untuk ganti):
                        <input id="editGambarInput" type="file" name="gambar" accept="image/*">
                    </label>
                    <div id="editPreview" class="preview">
                        <?php if (!empty($editData['gambarPath'])): ?>
                            <img src="<?= htmlspecialchars($editData['gambarPath']) ?>" alt="preview">
                        <?php else: ?>
                            <span class="small muted">Tidak ada gambar</span>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top:12px;display:flex;gap:8px">
                        <button class="btn" type="submit">Simpan Update</button>
                        <a class="btn ghost" href="index.php">Batal</a>
                    </div>
                </form>
            <?php else: ?>
                <h3>Tambah Produk</h3>
                <form id="addForm" method="post" enctype="multipart/form-data" action="index.php?action=tambah">
                    <label class="field">Nama:
                        <input id="addNama" type="text" name="nama" required>
                    </label>
                    <label class="field">Merek:
                        <input id="addMerek" type="text" name="merek" required>
                    </label>
                    <div class="form-row">
                        <label class="field col">Harga:
                            <input id="addHarga" type="number" name="harga" required>
                        </label>
                        <label class="field col">Stok:
                            <input id="addStok" type="number" name="stok" required>
                        </label>
                    </div>

                    <label class="field">Gambar (upload file lokal):
                        <input id="addGambarInput" type="file" name="gambar" accept="image/*">
                    </label>
                    <div id="addPreview" class="preview"><span class="small muted">Preview gambar</span></div>

                    <div style="margin-top:12px;display:flex;gap:8px;align-items:center">
                        <button class="btn" type="submit">Tambah</button>
                        <button type="button" id="resetForm" class="btn ghost">Reset form</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </aside>

    <!-- RIGHT: table -->
    <main class="main">
        <div class="card">
            <div class="topbar">
                <div class="search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="opacity:.7"><path d="M21 21l-4.35-4.35" stroke="#2b3a67" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="11" cy="11" r="6" stroke="#2b3a67" stroke-linecap="round" stroke-linejoin="round"></circle></svg>
                    <input id="tableSearch" placeholder="Cari berdasarkan nama atau merek..." type="search" aria-label="Cari">
                </div>
                <div>
                    <?php if (count($_SESSION['produk_list']) > 0): ?>
                        <button class="btn ghost" id="exportBtn" onclick="alert('Export tidak tersedia di versi ini — session only')">Export</button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (count($_SESSION['produk_list']) === 0): ?>
                <p class="small muted">Belum ada produk.</p>
            <?php else: ?>
                <div class="table-wrap">
                <table id="produkTable" role="table" aria-label="Daftar Produk">
                    <thead>
                        <tr>
                            <th style="width:48px">#</th>
                            <th style="width:140px">Gambar</th>
                            <th>Nama</th>
                            <th>Merek</th>
                            <th style="width:110px">Harga</th>
                            <th style="width:80px">Stok</th>
                            <th style="width:160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['produk_list'] as $i => $p): ?>
                            <tr data-nama="<?= htmlspecialchars(strtolower($p['nama'])) ?>" data-merek="<?= htmlspecialchars(strtolower($p['merek'])) ?>">
                                <td class="center"><?= $i + 1 ?></td>
                                <td>
                                    <?php if (!empty($p['gambarPath'])): ?>
                                        <a href="<?= htmlspecialchars($p['gambarPath']) ?>" target="_blank" title="Buka gambar di tab baru">
                                            <img src="<?= htmlspecialchars($p['gambarPath']) ?>" class="thumb" alt="gambar">
                                        </a>
                                    <?php else: ?>
                                        <span class="small muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($p['nama']) ?></td>
                                <td><?= htmlspecialchars($p['merek']) ?></td>
                                <td><?= htmlspecialchars($p['harga']) ?></td>
                                <td class="center"><?= htmlspecialchars($p['stok']) ?></td>
                                <td class="actions">
                                    <a class="edit" href="index.php?edit=<?= $i ?>">Edit</a>
                                    <a class="del" href="index.php?action=hapus&index=<?= $i ?>" data-index="<?= $i ?>">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

</div>

<!-- Modal delete -->
<div id="modalBackdrop" class="modal-backdrop" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <h4 id="modalTitle">Konfirmasi Hapus</h4>
        <div class="small muted">Apakah Anda yakin ingin menghapus produk ini? Tindakan tidak bisa dibatalkan.</div>
        <div class="buttons">
            <button id="modalCancel" class="btn ghost">Batal</button>
            <a id="modalConfirm" class="btn" href="#">Hapus</a>
        </div>
    </div>
</div>

<script>



function setupImagePreview(inputSelector, previewSelector) {
    const input = document.querySelector(inputSelector);
    const preview = document.querySelector(previewSelector);
    if (!input || !preview) return;
    input.addEventListener('change', function() {
        const f = this.files && this.files[0];
        if (!f) {
            preview.innerHTML = '<span class="small muted">Preview gambar</span>';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'preview';
            img.style.cursor='pointer';
            img.addEventListener('click', ()=> window.open(e.target.result, '_blank'));
            preview.appendChild(img);
        }
        reader.readAsDataURL(f);
    });
}
setupImagePreview('#addGambarInput', '#addPreview');
setupImagePreview('#editGambarInput', '#editPreview');

const resetBtn = document.getElementById('resetForm');
if (resetBtn) {
    resetBtn.addEventListener('click', function(){
        const form = document.getElementById('addForm');
        if (!form) return;
        form.reset();
        const p = document.getElementById('addPreview');
        if (p) p.innerHTML = '<span class="small muted">Preview gambar</span>';
    });
}

const searchInput = document.getElementById('tableSearch');
if (searchInput) {
    searchInput.addEventListener('input', function(){
        const q = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#produkTable tbody tr');
        rows.forEach(r => {
            const nama = r.dataset.nama || '';
            const merek = r.dataset.merek || '';
            const visible = (!q) || nama.includes(q) || merek.includes(q);
            r.style.display = visible ? '' : 'none';
        });
    });
}

const modalBackdrop = document.getElementById('modalBackdrop');
const modalConfirm = document.getElementById('modalConfirm');
const modalCancel = document.getElementById('modalCancel');

document.querySelectorAll('.actions a.del').forEach(a => {
    a.addEventListener('click', function(e){
        e.preventDefault();
        const href = this.getAttribute('href');
        modalConfirm.setAttribute('href', href);
        modalBackdrop.style.display = 'flex';
        modalBackdrop.setAttribute('aria-hidden','false');
    });
});

if (modalCancel) {
    modalCancel.addEventListener('click', function(){
        modalBackdrop.style.display = 'none';
        modalBackdrop.setAttribute('aria-hidden','true');
    });
}

document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') {
        modalBackdrop.style.display = 'none';
    }
});
</script>
</body>
</html>
