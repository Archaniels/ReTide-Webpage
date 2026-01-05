const express = require('express');
const router = express.Router();
const donationController = require('../controller/donationController');

router.get('/', donationController.getAllUpdates);
router.get('/:donation_id', donationController.getUpdatesByDonationId);
router.get('/single/:id', donationController.getUpdateById);
router.post('/', donationController.createUpdate);
router.put('/:id', donationController.updateUpdate);
router.delete('/:id', donationController.deleteUpdate);

module.exports = router;
