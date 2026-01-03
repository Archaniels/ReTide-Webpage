const express = require('express');
const router = express.Router();

// Simulasi database (nanti bisa MySQL)
let donationUpdates = [];

// GET semua update (untuk user)
router.get('/', (req, res) => {
  res.json(donationUpdates);
});

// GET update berdasarkan donation_id
router.get('/:donation_id', (req, res) => {
  const { donation_id } = req.params;
  const updates = donationUpdates.filter(
    d => d.donation_id == donation_id
  );
  res.json(updates);
});

// POST update (ADMIN)
router.post('/', (req, res) => {
  const { donation_id, title, description, status } = req.body;

  donationUpdates.push({
    id: donationUpdates.length + 1,
    donation_id,
    title,
    description,
    status,
    created_at: new Date()
  });

  res.json({ message: 'Update berhasil ditambahkan' });
});

// DELETE update (ADMIN)
router.delete('/:id', (req, res) => {
  donationUpdates = donationUpdates.filter(
    d => d.id != req.params.id
  );
  res.json({ message: 'Update dihapus' });
});

module.exports = router;
