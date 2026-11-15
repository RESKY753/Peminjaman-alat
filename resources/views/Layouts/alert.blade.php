@if (session('success'))
    <script>
        window.addEventListener('load', function () {
            const pesan = @json(session('success'));
            if (typeof MyAlert !== 'undefined') {
                MyAlert.show({
                    type: 'success',
                    title: 'Berhasil!',
                    message: pesan,
                    autoClose: 3000
                });
            } else {
                alert(pesan);
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        window.addEventListener('load', function () {
            const pesan = @json(session('error'));
            if (typeof MyAlert !== 'undefined') {
                MyAlert.show({
                    type: 'error',
                    title: 'Gagal!',
                    message: pesan
                });
            } else {
                alert(pesan);
            }
        });
    </script>
@endif

<script>
    let sedangSubmit = false; // cegah submit ganda

    function konfirmasiProses(formId, pesan) {
        const form = document.getElementById(formId);
        if (!form || sedangSubmit) return;

        const kirim = function () {
            sedangSubmit = true;
            form.submit();
        };

        if (typeof MyAlert !== 'undefined') {
            MyAlert.show({
                type: 'warning',
                title: 'Konfirmasi',
                message: pesan,
                showCancel: true,
                confirmText: 'Ya',
                cancelText: 'Batal',
                onConfirm: kirim
            });
        } else if (confirm(pesan)) {
            kirim();
        }
    }
</script>
<script>
    function konfirmasiForm(el, pesan) {
        var form = el.closest('form');
        if (!form) {
            console.error('konfirmasiForm: elemen tidak berada di dalam <form>');
            return false;
        }

        // Sudah dikonfirmasi: biarkan submit berjalan
        if (form.dataset.sudahKonfirmasi) return true;

        if (typeof MyAlert !== 'undefined') {
            MyAlert.show({
                type: 'warning',
                title: 'Konfirmasi',
                message: pesan,
                showCancel: true,
                confirmText: 'Ya',
                cancelText: 'Batal',
                onConfirm: function () {
                    form.dataset.sudahKonfirmasi = '1'; // cegah submit ganda
                    form.submit(); // tidak memicu onsubmit lagi
                }
            });
            return false; // tahan submit sampai user menekan "Ya"
        }

        return confirm(pesan); // fallback kalau MyAlert tidak ter-load
    }
</script>
<script>
    function konfirmasiForm1(el, pesan) {
        var form = el.closest('form');
        if (!form) {
            console.error('konfirmasiForm: elemen tidak berada di dalam <form>');
            return false;
        }

        // Sudah dikonfirmasi: biarkan submit berjalan
        if (form.dataset.sudahKonfirmasi) return true;

        if (typeof MyAlert !== 'undefined') {
            MyAlert.show({
                type: 'warning',
                title: 'Konfirmasi',
                message: pesan,
                showCancel: true,
                confirmText: 'Ya',
                cancelText: 'Batal',
                onConfirm: function () {
                    form.dataset.sudahKonfirmasi = '1'; // cegah submit ganda
                    form.submit(); // tidak memicu onsubmit lagi
                }
            });
            return false; // tahan submit sampai user menekan "Ya"
        }

        return confirm(pesan); // fallback kalau MyAlert tidak ter-load
    }
</script>
<script>
    function konfirmasiSubmit(form, pesan) {
        if (form.dataset.sudahKonfirmasi) return true;

        if (typeof MyAlert !== 'undefined') {
            MyAlert.show({
                type: 'warning',
                title: 'Konfirmasi',
                message: pesan,
                showCancel: true,
                confirmText: 'Ya',
                cancelText: 'Batal',
                onConfirm: function () {
                    form.dataset.sudahKonfirmasi = '1'; // cegah submit ganda
                    form.submit();
                }
            });
            return false; // batalkan submit sekarang, tunggu konfirmasi
        }

        return confirm(pesan); // fallback kalau MyAlert tidak ter-load
    }
</script>