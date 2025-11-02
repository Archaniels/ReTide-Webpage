// Data akun dummy (simulasi JSON yang sudah ada) - DIGUNAKAN SEBAGAI TEMPLATE AWAL
const DUMMY_DATA = {
    username: "Bagaskara",
    email: "Bagaskara@gmail.com",
    notelp: ""
};

// Data ini akan hilang ketika halaman di-refresh.
let CURRENT_USER_DATA = { ...DUMMY_DATA }; 

function resetForm() {
    document.getElementById('username').value = '';
    document.getElementById('email').value = '';
    document.getElementById('notelp').value = '';
}

// Memuat data saat halaman dimuat
function loadData() {
    // Data dimuat langsung dari objek CURRENT_USER_DATA (in-memory JSON object)
    const data = CURRENT_USER_DATA; 

    // Isi formulir
    document.getElementById('username').value = data.username;
    document.getElementById('email').value = data.email;
    document.getElementById('notelp').value = data.notelp;
}

// Menyimpan data saat formulir disubmit
function saveData(event) {
    event.preventDefault(); // Mencegah refresh halaman
    
    // Ambil semua nilai dari formulir
    const updatedData = {
        username: document.getElementById('username').value,
        email: document.getElementById('email').value,
        notelp: document.getElementById('notelp').value
    };
    
    // 💾 SIMPAN: Perbarui objek CURRENT_USER_DATA secara langsung
    CURRENT_USER_DATA = updatedData;
    
    alert('Pengaturan berhasil disimpan!');
}

// Setup event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Panggil loadData agar formulir terisi data JSON yang sudah ada
    loadData();

    // Tambahkan event submit ke formulir
    const form = document.querySelector('.account-form');
    if (form) {
        form.addEventListener('submit', saveData);
    }

    // Ambil tombol delete
    const deleteButton = document.getElementById('delete-btn');

    // Tambahkan event listener 'click' ke tombol tersebut
    if (deleteButton) {
        deleteButton.addEventListener('click', deleteData);
    }
});

// Menghapus data akun
function deleteData() {
    // Tampilkan konfirmasi kepada pengguna
    const isConfirmed = confirm("Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.");

    if (isConfirmed) {
        // 🗑️ HAPUS: Reset objek CURRENT_USER_DATA menjadi objek kosong (atau nilai default)
        CURRENT_USER_DATA = {
            username: "",
            email: "",
            notelp: ""
        }; 
        
        // Kosongkan formulir di tampilan
        resetForm();

        alert('Akun berhasil dihapus.');
    }
}