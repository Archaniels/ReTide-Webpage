let STORAGE_KEY = 'donationData'; // localStorage key

// Ambil data dari localStorage
function getDonations() {
  return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
}

// Simpan data ke localStorage
function saveDonations(data) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
}

// Render daftar donasi (READ)
function renderDonations() {
  const listContainer = document.getElementById('donation-list');
  const donations = getDonations();
  listContainer.innerHTML = '';

  if (donations.length === 0) {
    listContainer.innerHTML = '<p>Belum ada donasi yang tercatat.</p>';
    return;
  }

  donations.forEach((donation, index) => {
    const card = document.createElement('div');
    card.classList.add('donation-card');
    card.innerHTML = `
      <h3>${donation.donorName}</h3>
      <p><strong>Email:</strong> ${donation.email}</p>
      <p><strong>Nominal:</strong> Rp ${donation.amount}</p>
      <p><strong>Pesan:</strong> ${donation.message || '-'}</p>
      <div class="card-buttons">
        <button class="btn" onclick="editDonation(${index})">Edit</button>
        <button class="btn delete-btn" onclick="deleteDonation(${index})">Hapus</button>
      </div>
    `;
    listContainer.appendChild(card);
  });
}

// Create & Update
function handleFormSubmit(event) {
  event.preventDefault();

  const donorName = document.getElementById('donorName').value;
  const email = document.getElementById('email').value;
  const amount = document.getElementById('amount').value;
  const message = document.getElementById('message').value;
  const editIndex = document.getElementById('editIndex').value;

  const donations = getDonations();

  const donationData = { donorName, email, amount, message };

  if (editIndex === '') {
    // CREATE
    donations.push(donationData);
    alert('Donasi berhasil ditambahkan!');
  } else {
    // UPDATE
    donations[editIndex] = donationData;
    alert('Donasi berhasil diperbarui!');
  }

  saveDonations(donations);
  resetForm();
  renderDonations();
}

// Edit (READ + UPDATE)
function editDonation(index) {
  const donation = getDonations()[index];
  document.getElementById('donorName').value = donation.donorName;
  document.getElementById('email').value = donation.email;
  document.getElementById('amount').value = donation.amount;
  document.getElementById('message').value = donation.message;
  document.getElementById('editIndex').value = index;
}

// Delete
function deleteDonation(index) {
  const isConfirmed = confirm('Apakah Anda yakin ingin menghapus donasi ini?');
  if (isConfirmed) {
    const donations = getDonations();
    donations.splice(index, 1);
    saveDonations(donations);
    renderDonations();
    alert('Data donasi telah dihapus.');
  }
}

// Reset form
function resetForm() {
  document.getElementById('donation-form').reset();
  document.getElementById('editIndex').value = '';
}

// Setup saat halaman siap
document.addEventListener('DOMContentLoaded', () => {
  renderDonations();
  document.getElementById('donation-form').addEventListener('submit', handleFormSubmit);
  document.getElementById('reset-btn').addEventListener('click', resetForm);
});
