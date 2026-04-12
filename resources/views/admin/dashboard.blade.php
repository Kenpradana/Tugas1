<x-layouts.app title="admin dashboard">
    <div>
        <h1>Selamat Datang Admin</h1>
        
        @if(auth()->user()->role == 'admin')
            <p>Anda adalah admin</p>
        @endif <!-- PASTIKAN ADA INI -->
    </div>
</x-layouts.app>