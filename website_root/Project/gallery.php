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
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Nunito:wght@300;400;600;700&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet">
 
    <style>
        :root {
            --sky-deep:    #0a1628;
            --sky-mid:     #0d2240;
            --panel:       rgba(10, 22, 42, 0.75);
            --border:      rgba(255, 200, 66, 0.12);
            --gold:        #ffc842;
            --gold-glow:   rgba(255, 200, 66, 0.22);
            --gold-faint:  rgba(255, 200, 66, 0.07);
            --teal:        #3effd0;
            --teal-faint:  rgba(62, 255, 208, 0.06);
            --coral:       #ff7e5f;
            --text:        #e8f4ff;
            --text-dim:    #7a9bbf;
            --text-muted:  #334d6b;
        }
 
        * { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: 'Nunito', sans-serif;
            background: var(--sky-deep);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }
 
        /* === SKY BG === */
        .sky-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 50% at 50% 110%, rgba(255,140,50,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 70% 80%, rgba(255,80,60,0.1) 0%, transparent 50%),
                radial-gradient(ellipse 100% 60% at 50% 100%, rgba(45,27,14,0.6) 0%, transparent 55%),
                linear-gradient(180deg, #06101e 0%, #0a1a35 40%, #0f2545 70%, #1a2a18 100%);
            pointer-events: none;
        }
 
        .stars {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
 
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle var(--dur) ease-in-out infinite var(--delay);
        }
 
        @keyframes twinkle {
            0%, 100% { opacity: 0.15; }
            50%       { opacity: 0.85; }
        }
 
        .page {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
        }
 
        /* === HEADER === */
        .scene-header {
            position: relative;
            padding: 36px 24px 0;
            text-align: center;
        }
 
        .back-link {
            position: absolute;
            top: 40px;
            left: 24px;
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            color: var(--teal);
            text-decoration: none;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0.75;
            transition: opacity 0.2s;
            z-index: 2;
        }
 
        .back-link:hover { opacity: 1; }
 
        .title-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--teal);
            opacity: 0.8;
            margin-bottom: 8px;
        }
 
        h1 {
            font-family: 'Righteous', sans-serif;
            font-size: clamp(2.2rem, 6vw, 3.6rem);
            letter-spacing: 0.04em;
            line-height: 1;
            background: linear-gradient(160deg, #fff9e6 0%, var(--gold) 50%, var(--coral) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 24px rgba(255,200,66,0.35));
            margin-bottom: 4px;
        }
 
        .title-sub {
            font-size: 0.82rem;
            color: var(--text-dim);
            font-weight: 300;
            letter-spacing: 0.06em;
        }
 
        /* SVG branch — shorter version for gallery */
        .branch-scene {
            position: relative;
            width: 100%;
            height: 80px;
            margin-top: 8px;
        }
 
        /* === TOOLBAR === */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px 16px;
            flex-wrap: wrap;
            gap: 12px;
        }
 
        .toolbar-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 7px;
        }
 
        .dot-gold {
            width: 5px; height: 5px; border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 7px var(--gold);
        }
 
        .count-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--gold-faint);
            border: 1px solid rgba(255,200,66,0.2);
            border-radius: 99px;
            padding: 5px 14px;
            font-family: 'DM Mono', monospace;
            font-size: 0.68rem;
            color: var(--gold);
            letter-spacing: 0.1em;
        }
 
        .count-num {
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Righteous', sans-serif;
            color: var(--gold);
            text-shadow: 0 0 12px var(--gold);
        }
 
        /* === GALLERY GRID === */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 16px;
            padding: 0 24px 32px;
        }
 
        /* === VIDEO CARD === */
        .video-card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: relative;
            transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
            animation: fadeUp 0.45s ease both;
            opacity: 0;
        }
 
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
 
        .video-card::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.28;
            z-index: 1;
        }
 
        .video-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255,200,66,0.28);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4), 0 0 20px rgba(255,200,66,0.07);
        }
 
        .video-card video {
            width: 100%;
            display: block;
            background: #000;
            border-radius: 0;
        }
 
        /* card number badge */
        .card-num {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            background: rgba(10,22,42,0.7);
            border: 1px solid rgba(255,200,66,0.2);
            border-radius: 8px;
            padding: 3px 8px;
            font-family: 'DM Mono', monospace;
            font-size: 0.58rem;
            color: var(--gold);
            letter-spacing: 0.08em;
            backdrop-filter: blur(4px);
        }
 
        .card-footer {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
 
        .card-time {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'DM Mono', monospace;
            font-size: 0.68rem;
            color: var(--text-dim);
            letter-spacing: 0.05em;
        }
 
        /* cycling bird color dots per card */
        .bird-indicator {
            width: 7px; height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }
 
        .bird-indicator.gold  { background: var(--gold);  box-shadow: 0 0 7px var(--gold); }
        .bird-indicator.teal  { background: var(--teal);  box-shadow: 0 0 7px var(--teal); }
        .bird-indicator.coral { background: var(--coral); box-shadow: 0 0 7px var(--coral); }
 
        .card-tag {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            color: var(--text-muted);
            letter-spacing: 0.08em;
        }
 
        /* === EMPTY STATE === */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            color: var(--text-muted);
        }
 
        .empty-state .empty-icon { font-size: 3.5rem; display: block; margin-bottom: 14px; }
 
        .empty-state p {
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
        }
 
        /* === FOOTER === */
        .page-footer {
            text-align: center;
            padding: 8px 0 30px;
            font-family: 'DM Mono', monospace;
            font-size: 0.58rem;
            color: var(--text-muted);
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }
 
        @media (max-width: 500px) {
            .gallery { grid-template-columns: 1fr; padding: 0 14px 24px; }
            .toolbar { padding: 16px 14px 12px; }
        }
    </style>
</head>
 
<body>
 
<div class="sky-bg"></div>
<div class="stars" id="stars"></div>
 
<div class="page">
 
    <!-- HEADER -->
    <div class="scene-header">
        <a href="index.html" class="back-link">← Dashboard</a>
 
        <p class="title-eyebrow">📼 Recordings</p>
        <h1>Bird Gallery</h1>
        <p class="title-sub">All captured feeder visits</p>
 
        <!-- smaller branch scene for gallery -->
        <div class="branch-scene">
            <svg viewBox="0 0 1100 80" preserveAspectRatio="xMidYMax meet"
                 xmlns="http://www.w3.org/2000/svg"
                 style="position:absolute;bottom:0;left:0;width:100%;height:100%">
                <defs>
                    <radialGradient id="sg2" cx="50%" cy="100%" r="50%">
                        <stop offset="0%" stop-color="#ff8c30" stop-opacity="0.25"/>
                        <stop offset="100%" stop-color="#ff8c30" stop-opacity="0"/>
                    </radialGradient>
                    <filter id="glow2">
                        <feGaussianBlur stdDeviation="2" result="b"/>
                        <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
                    </filter>
                </defs>
                <ellipse cx="550" cy="80" rx="500" ry="60" fill="url(#sg2)"/>
 
                <!-- main branch — wider for gallery page -->
                <path d="M0,62 Q150,50 280,54 Q440,58 550,48 Q700,38 860,44 Q980,50 1100,42"
                      stroke="#2a1a0a" stroke-width="6" fill="none" stroke-linecap="round"/>
 
                <!-- sub branches -->
                <path d="M240,53 Q232,34 224,16" stroke="#2a1a0a" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                <path d="M820,43 Q830,26 840,10" stroke="#2a1a0a" stroke-width="3.5" fill="none" stroke-linecap="round"/>
 
                <!-- leaves -->
                <ellipse cx="222" cy="13" rx="15" ry="9" fill="#1a3a10" opacity="0.8" transform="rotate(-18,222,13)"/>
                <ellipse cx="232" cy="6" rx="10" ry="6" fill="#1f4a14" opacity="0.65" transform="rotate(8,232,6)"/>
                <ellipse cx="842" cy="7" rx="14" ry="8" fill="#1a3a10" opacity="0.8" transform="rotate(14,842,7)"/>
                <ellipse cx="830" cy="2" rx="9" ry="6" fill="#1f4a14" opacity="0.6" transform="rotate(-8,830,2)"/>
 
                <!-- Gold bird left -->
                <g filter="url(#glow2)" transform="translate(310, 40)" opacity="0.9">
                    <ellipse cx="0" cy="0" rx="10" ry="6" fill="#ffc842"/>
                    <circle cx="8" cy="-4" r="5.5" fill="#ffc842"/>
                    <polygon points="13,-4 17,-2 13,-1" fill="#ff8c30"/>
                    <circle cx="10" cy="-5" r="1.1" fill="#0a1628"/>
                    <path d="M-7,0 Q-3,-5 3,-3" stroke="#e6a500" stroke-width="1.5" fill="none" opacity="0.6"/>
                    <path d="M-10,0 L-15,3 M-10,1 L-15,6" stroke="#e6a500" stroke-width="2" stroke-linecap="round"/>
                    <line x1="-1" y1="6" x2="-2" y2="11" stroke="#cc8800" stroke-width="1.5"/>
                    <line x1="3" y1="6" x2="3" y2="11" stroke="#cc8800" stroke-width="1.5"/>
                </g>
 
                <!-- Teal bird center -->
                <g filter="url(#glow2)" transform="translate(550, 36)" opacity="0.9">
                    <ellipse cx="0" cy="0" rx="10" ry="6" fill="#3effd0"/>
                    <circle cx="8" cy="-4" r="5.5" fill="#3effd0"/>
                    <polygon points="13,-4 17,-2 13,-1" fill="#00c49a"/>
                    <circle cx="10" cy="-5" r="1.1" fill="#0a1628"/>
                    <path d="M-7,0 Q-3,-5 3,-3" stroke="#00c49a" stroke-width="1.5" fill="none" opacity="0.6"/>
                    <path d="M-10,0 L-15,3 M-10,1 L-15,6" stroke="#00c49a" stroke-width="2" stroke-linecap="round"/>
                    <line x1="-1" y1="6" x2="-2" y2="11" stroke="#009977" stroke-width="1.5"/>
                    <line x1="3" y1="6" x2="3" y2="11" stroke="#009977" stroke-width="1.5"/>
                </g>
 
                <!-- Coral bird right, facing left -->
                <g filter="url(#glow2)" transform="translate(750, 32) scale(-1,1)" opacity="0.88">
                    <ellipse cx="0" cy="0" rx="10" ry="6" fill="#ff7e5f"/>
                    <circle cx="8" cy="-4" r="5.5" fill="#ff7e5f"/>
                    <polygon points="13,-4 17,-2 13,-1" fill="#d45a30"/>
                    <circle cx="10" cy="-5" r="1.1" fill="#0a1628"/>
                    <path d="M-7,0 Q-3,-5 3,-3" stroke="#d45a30" stroke-width="1.5" fill="none" opacity="0.6"/>
                    <path d="M-10,0 L-15,3 M-10,1 L-15,6" stroke="#d45a30" stroke-width="2" stroke-linecap="round"/>
                    <line x1="-1" y1="6" x2="-2" y2="11" stroke="#aa4020" stroke-width="1.5"/>
                    <line x1="3" y1="6" x2="3" y2="11" stroke="#aa4020" stroke-width="1.5"/>
                </g>
 
                <!-- two tiny birds in flight -->
                <g transform="translate(70, 18)" opacity="0.45">
                    <path d="M0,0 Q5,-4 10,0" stroke="#ffc842" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <path d="M0,0 Q5,4 10,0" stroke="#ffc842" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <circle cx="5" cy="0" r="2" fill="#ffc842"/>
                </g>
                <g transform="translate(1010, 12)" opacity="0.4">
                    <path d="M0,0 Q5,-4 10,0" stroke="#3effd0" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <path d="M0,0 Q5,4 10,0" stroke="#3effd0" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <circle cx="5" cy="0" r="2" fill="#3effd0"/>
                </g>
            </svg>
        </div>
    </div>
 
    <!-- TOOLBAR -->
    <div class="toolbar">
        <div class="toolbar-label"><span class="dot-gold"></span> All recordings</div>
        <div class="count-pill">
            <span class="count-num"><?php echo $total; ?></span>
            clip<?php echo $total !== 1 ? 's' : ''; ?> captured
        </div>
    </div>
 
    <!-- GALLERY GRID -->
    <div class="gallery">
    <?php
    $colors = ['gold', 'teal', 'coral'];
 
    if ($total === 0) {
        echo "
        <div class='empty-state'>
            <span class='empty-icon'>🐦</span>
            <p>No visitors captured yet — check back soon!</p>
        </div>
        ";
    } else {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $file    = htmlspecialchars($row['filename']);
            $time    = htmlspecialchars($row['timestamp']);
            $delay   = round(min($i * 0.06, 0.6), 2);
            $color   = $colors[$i % 3];
            $num     = str_pad($total - $i, 3, '0', STR_PAD_LEFT);
 
            echo "
            <div class='video-card' style='animation-delay:{$delay}s'>
                <div class='card-num'>#$num</div>
                <video controls preload='none'>
                    <source src='/uploads/$file' type='video/mp4'>
                </video>
                <div class='card-footer'>
                    <div class='card-time'>
                        <span class='bird-indicator $color'></span>
                        🕐 $time
                    </div>
                    <span class='card-tag'>🐦 visit</span>
                </div>
            </div>
            ";
            $i++;
        }
    }
    ?>
    </div>
 
    <div class="page-footer">🐦 Bird Feeder Station · Video Archive · <?php echo $total; ?> recordings</div>
 
</div>
 
<script>
// generate stars — same as dashboard
(function() {
    const c = document.getElementById('stars');
    for (let i = 0; i < 80; i++) {
        const s = document.createElement('div');
        s.className = 'star';
        const size = Math.random() > 0.8 ? 3 : 2;
        s.style.cssText = `
            left: ${Math.random()*100}%;
            top:  ${Math.random()*60}%;
            width: ${size}px; height: ${size}px;
            --dur:   ${2 + Math.random()*4}s;
            --delay: ${-Math.random()*5}s;
        `;
        c.appendChild(s);
    }
})();
</script>
 
</body>
</html>
 