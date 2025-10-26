// Data akun dummy (simulasi JSON yang sudah ada)
let DUMMY_DATA = {
    username: "Bagaskara",
    email: "Bagaskara@gmail.com",
    notelp: ""
};

let STORAGE_KEY = 'userData';

function resetForm() {
    document.getElementById('username').value = '';
    document.getElementById('email').value = '';
    document.getElementById('notelp').value = '';
}

// Memuat data saat halaman dimuat
function loadData() {
    // Coba ambil data dari localStorage
    const savedData = localStorage.getItem(STORAGE_KEY);
    const data = savedData ? JSON.parse(savedData) : DUMMY_DATA;

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
    
    // Simpan objek data ke localStorage sebagai JSON string
    localStorage.setItem(STORAGE_KEY, JSON.stringify(updatedData));
    
    alert('Pengaturan berhasil disimpan!');
}

// Setup event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Panggil loadData agar formulir terisi data JSON yang sudah ada
    loadData();

    // Tambahkan event submit ke formulir
    const form = document.querySelector('.account-form');
    form.addEventListener('submit', saveData);

    // Ambil tombol delete berdasarkan ID yang sudah Anda buat (asumsi ID-nya adalah 'delete-btn')
    const deleteButton = document.getElementById('delete-btn');

    // Tambahkan event listener 'click' ke tombol tersebut
    if (deleteButton) {
        deleteButton.addEventListener('click', deleteData);
    }
});

// Menghapus data akun (BARU)
function deleteData() {
    // Tampilkan konfirmasi kepada pengguna
    const isConfirmed = confirm("Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.");

    if (isConfirmed) {
        // Hapus data JSON dari localStorage
        localStorage.removeItem(STORAGE_KEY);
        
        // Kosongkan formulir di tampilan
        resetForm();

        alert('Akun berhasil dihapus.');
        
        // Opsional: Muat ulang halaman untuk mencerminkan status akun yang dihapus
        // window.location.reload(); 
    }
}