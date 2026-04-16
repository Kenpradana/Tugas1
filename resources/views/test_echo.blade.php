<!DOCTYPE html>
<html>
<head>
    <title>Test WebSocket Mentah</title>
</head>
<body style="background: #222; color: white; padding: 20px; font-family: monospace;">
    <h1>HALAMAN TEST MENTAH WEBSOCKET</h1>
    <p>Buka Console (F12). Lihat apakah muncul tulisan: "BERHASIL SUBSCRIBE"</p>

    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0-rc2/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
        console.log('1. Mulai setup Echo...');

        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ config("broadcasting.connections.reverb.key") }}',
            wsHost: '127.0.0.1',
            wsPort: 8080,
            wssPort: 443,
            forceTLS: false,
            enabledTransports: ['ws'],
        });

        console.log('2. Mencoba subscribe ke channel...');

        window.Echo.channel('antrian-poliklinik')
            .subscribed(function() {
                console.log('✅ 3. BERHASIL SUBSCRIBE KE CHANNEL! (Reverb nyambung)');
            })
            .error(function(error) {
                console.error('❌ GAGAL SUBSCRIBE:', error);
            })
            .listen('.antrian-update', function(e) {
                console.log('🔥 4. DATA DITERIMA DARI DOKTER:', e);
                alert('HOREE! KEBACA NOMOR: ' + e.nomorSekarang);
            });
    </script>
</body>
</html>