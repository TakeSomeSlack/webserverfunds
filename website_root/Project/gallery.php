<?php
 
$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");
 
$result = mysqli_query($conn, "SELECT * FROM system_logs WHERE filename LIKE '%.mp4' ORDER BY id DESC");
 
$total = mysqli_num_rows($result);
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bird Feeder · Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
 
    <style>
        :root {
            --bg:        #0b1120;
            --bg2:       #111927;
            --card:      #141e2e;
            --border:    rgba(255,255,255,0.07);
            --gold:      #f5c842;
            --teal:      #3edfc0;
            --coral:     #ff6b55;
            --text:      #dce8f0;
            --text-dim:  #6b88a0;
            --text-faint:#2e4a5e;
        }
 
        * { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
 
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 40% at 50% 105%, rgba(255,130,40,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 20% 50%, rgba(20,60,80,0.3) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }
 
        .page {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }
 
        /* ── HEADER ── */
        .header {
            padding: 36px 0 20px;
            text-align: center;
            position: relative;
        }
 
        .back-link {
            position: absolute;
            top: 40px;
            left: 0;
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            color: var(--teal);
            text-decoration: none;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
 
        .back-link:hover { opacity: 1; }
 
        .header-icon {
            font-size: 2.4rem;
            display: block;
            margin-bottom: 8px;
            filter: drop-shadow(0 0 10px rgba(245,200,66,0.35));
        }
 
        .header h1 {
            font-size: 1.9rem;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.02em;
            margin-bottom: 4px;
        }
 
        .header-sub {
            font-size: 0.78rem;
            color: var(--text-dim);
            font-family: 'Space Mono', monospace;
            letter-spacing: 0.1em;
        }
 
        /* ── TOOLBAR ── */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0 14px;
            flex-wrap: wrap;
            gap: 10px;
        }
 
        .toolbar-label {
            font-family: 'Space Mono', monospace;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--text-faint);
            display: flex;
            align-items: center;
            gap: 6px;
        }
 
        .label-dot {
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 5px var(--gold);
        }
 
        .count-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245,200,66,0.07);
            border: 1px solid rgba(245,200,66,0.18);
            border-radius: 99px;
            padding: 5px 14px;
            font-family: 'Space Mono', monospace;
            font-size: 0.65rem;
            color: var(--gold);
            letter-spacing: 0.08em;
        }
 
        .count-num {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gold);
        }
 
        /* ── GALLERY GRID ── */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 14px;
            padding-bottom: 32px;
        }
 
        /* ── VIDEO CARD ── */
        .video-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            position: relative;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            animation: fadeUp 0.4s ease both;
            opacity: 0;
        }
 
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
 
        .video-card:hover {
            transform: translateY(-4px);
            border-color: rgba(245,200,66,0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
        }
 
        .video-card video {
            width: 100%;
            display: block;
            background: #000;
        }
 
        .card-num {
            position: absolute;
            top: 9px;
            left: 9px;
            z-index: 2;
            background: rgba(11,17,32,0.75);
            border: 1px solid rgba(245,200,66,0.2);
            border-radius: 6px;
            padding: 3px 8px;
            font-family: 'Space Mono', monospace;
            font-size: 0.55rem;
            color: var(--gold);
            letter-spacing: 0.08em;
        }
 
        .card-footer {
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            border-top: 1px solid var(--border);
        }
 
        .card-time {
            display: flex;
            align-items: center;
            gap: 7px;
            font-family: 'Space Mono', monospace;
            font-size: 0.62rem;
            color: var(--text-dim);
        }
 
        .bird-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
 
        .bird-dot.gold  { background: var(--gold);  box-shadow: 0 0 5px var(--gold); }
        .bird-dot.teal  { background: var(--teal);  box-shadow: 0 0 5px var(--teal); }
        .bird-dot.coral { background: var(--coral); box-shadow: 0 0 5px var(--coral); }
 
        .card-tag {
            font-family: 'Space Mono', monospace;
            font-size: 0.55rem;
            color: var(--text-faint);
        }
 
        /* ── CARD BUTTONS ── */
        .card-actions {
            display: flex;
            gap: 8px;
            padding: 0 12px 12px;
        }
 
        .card-btn {
            flex: 1;
            padding: 8px 10px;
            border: none;
            border-radius: 8px;
            font-family: 'Space Mono', monospace;
            font-size: 0.62rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: transform 0.12s, filter 0.15s;
            text-decoration: none;
            letter-spacing: 0.04em;
        }
 
        .card-btn:hover  { transform: translateY(-1px); filter: brightness(1.1); }
        .card-btn:active { transform: scale(0.97); }
 
        .btn-download {
            background: linear-gradient(135deg, #1a4d6e, #2476a6);
            color: #b0daf0;
        }
 
        .btn-delete {
            background: linear-gradient(135deg, #5a1010, #a02020);
            color: #ffb5b5;
        }
 
        /* ── CONFIRM OVERLAY ── */
        .confirm-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(6,14,26,0.85);
            backdrop-filter: blur(6px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
 
        .confirm-overlay.active { display: flex; }
 
        .confirm-box {
            background: var(--card);
            border: 1px solid rgba(255,107,85,0.3);
            border-radius: 16px;
            padding: 28px 24px;
            max-width: 320px;
            width: 90%;
            text-align: center;
            animation: popIn 0.18s ease;
        }
 
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.93); }
            to   { opacity: 1; transform: scale(1); }
        }
 
        .confirm-icon { font-size: 2rem; margin-bottom: 10px; display: block; }
 
        .confirm-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--coral);
            margin-bottom: 6px;
        }
 
        .confirm-msg {
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            color: var(--text-dim);
            margin-bottom: 20px;
            line-height: 1.6;
        }
 
        .confirm-btns { display: flex; gap: 8px; }
 
        .confirm-btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 9px;
            font-family: 'Space Mono', monospace;
            font-size: 0.7rem;
            cursor: pointer;
            transition: filter 0.15s, transform 0.12s;
        }
 
        .confirm-btn:hover  { filter: brightness(1.1); transform: translateY(-1px); }
        .confirm-btn:active { transform: scale(0.97); }
 
        .confirm-cancel {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: var(--text-dim);
        }
 
        .confirm-yes {
            background: linear-gradient(135deg, #7a1010, #c02828);
            color: #ffcccc;
        }
 
        /* ── TOAST ── */
        .toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(16px);
            background: var(--card);
            border: 1px solid rgba(62,223,192,0.2);
            border-radius: 10px;
            padding: 9px 18px;
            font-family: 'Space Mono', monospace;
            font-size: 0.68rem;
            color: var(--teal);
            letter-spacing: 0.06em;
            opacity: 0;
            transition: opacity 0.3s, transform 0.3s;
            z-index: 200;
            white-space: nowrap;
        }
 
        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
 
        .toast.error {
            border-color: rgba(255,107,85,0.25);
            color: var(--coral);
        }
 
        /* ── EMPTY STATE ── */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 70px 20px;
            color: var(--text-faint);
        }
 
        .empty-state span { font-size: 3rem; display: block; margin-bottom: 12px; }
 
        .empty-state p {
            font-family: 'Space Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
        }
 
        /* ── FOOTER ── */
        .footer {
            text-align: center;
            padding: 8px 0 28px;
            font-family: 'Space Mono', monospace;
            font-size: 0.55rem;
            color: var(--text-faint);
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
 
        @media (max-width: 500px) {
            .gallery { grid-template-columns: 1fr; }
        }
    </style>
</head>
 
<body>
 
<div class="page">
 
    <!-- HEADER -->
    <div class="header">
        <a href="index.html" class="back-link">← Dashboard</a>
        <span class="header-icon">🎥</span>
        <h1>Bird Gallery</h1>
        <p class="header-sub">All captured feeder visits</p>
    </div>
 
    <!-- TOOLBAR -->
    <div class="toolbar">
        <div class="toolbar-label"><span class="label-dot"></span> All recordings</div>
        <div class="count-pill">
            <span class="count-num"><?php echo $total; ?></span>
            clip<?php echo $total !== 1 ? 's' : ''; ?> captured
        </div>
    </div>
 
    <!-- GALLERY -->
    <div class="gallery">
    <?php
    $colors = ['gold', 'teal', 'coral'];
 
    if ($total === 0) {
        echo "
        <div class='empty-state'>
            <span>🐦</span>
            <p>No visitors captured yet — check back soon!</p>
        </div>
        ";
    } else {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $file       = htmlspecialchars($row['filename']);
            $time       = htmlspecialchars($row['timestamp']);
            $thumb_name = pathinfo($file, PATHINFO_FILENAME) . ".jpg";
            $thumb_path = "/home/Sikander/uploads/" . $thumb_name;
            $thumb_src  = file_exists($thumb_path) ? "/uploads/$thumb_name" : "";
            $delay      = round(min($i * 0.06, 0.6), 2);
            $color      = $colors[$i % 3];
            $num        = str_pad($total - $i, 3, '0', STR_PAD_LEFT);
            $poster     = $thumb_src ? "poster='$thumb_src'" : "";
 
            echo "
            <div class='video-card' id='card-$file' style='animation-delay:{$delay}s'>
                <div class='card-num'>#$num</div>
                <video controls preload='none' $poster>
                    <source src='/uploads/$file' type='video/mp4'>
                </video>
                <div class='card-footer'>
                    <div class='card-time'>
                        <span class='bird-dot $color'></span>
                        🕐 $time
                    </div>
                    <span class='card-tag'>🐦 visit</span>
                </div>
                <div class='card-actions'>
                    <a class='card-btn btn-download' href='/uploads/$file' download='$file'>⬇ Download</a>
                    <button class='card-btn btn-delete' onclick='confirmDelete(\"$file\")'>🗑 Delete</button>
                </div>
            </div>
            ";
            $i++;
        }
    }
    ?>
    </div>
 
    <div class="footer">🐦 Bird Feeder Station · Video Archive · <?php echo $total; ?> recordings</div>
 
</div>
 
<!-- CONFIRM DELETE OVERLAY -->
<div class="confirm-overlay" id="confirmOverlay">
    <div class="confirm-box">
        <span class="confirm-icon">🗑️</span>
        <div class="confirm-title">Delete Recording?</div>
        <div class="confirm-msg" id="confirmMsg">This will permanently remove the video<br>and cannot be undone.</div>
        <div class="confirm-btns">
            <button class="confirm-btn confirm-cancel" onclick="closeConfirm()">Cancel</button>
            <button class="confirm-btn confirm-yes" onclick="doDelete()">Delete</button>
        </div>
    </div>
</div>
 
<!-- TOAST -->
<div class="toast" id="toast"></div>
 
<script>
// ==========================
// TOAST
// ==========================
function showToast(msg, isError=false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.toggle('error', isError);
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}
 
// ==========================
// DELETE CONFIRM
// ==========================
let pendingDelete = null;
 
function confirmDelete(filename) {
    pendingDelete = filename;
    document.getElementById('confirmMsg').innerHTML =
        `This will permanently delete:<br><strong style="color:var(--gold)">${filename}</strong>`;
    document.getElementById('confirmOverlay').classList.add('active');
}
 
function closeConfirm() {
    pendingDelete = null;
    document.getElementById('confirmOverlay').classList.remove('active');
}
 
document.getElementById('confirmOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});
 
async function doDelete() {
    if (!pendingDelete) return;
 
    const filename = pendingDelete;
    closeConfirm();
 
    try {
        const res  = await fetch('delete_video.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'filename=' + encodeURIComponent(filename)
        });
        const data = await res.json();
 
        if (data.success) {
            const card = document.getElementById('card-' + filename);
            if (card) {
                card.style.transition = 'opacity 0.4s, transform 0.4s';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.92)';
                setTimeout(() => card.remove(), 400);
            }
            showToast('✓ Recording deleted');
        } else {
            showToast('⚠ Could not delete: ' + (data.error || 'unknown error'), true);
        }
    } catch (err) {
        showToast('⚠ Network error — try again', true);
    }
}
</script>
 
</body>
</html>