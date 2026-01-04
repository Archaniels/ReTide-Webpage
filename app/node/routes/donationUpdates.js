const express = require('express');
const router = express.Router();
const donationController = require('../controller/donationController');

router.get('/', donationController.getAllUpdates);
router.get('/:donation_id', donationController.getUpdatesByDonationId);
router.post('/', donationController.createUpdate);
router.delete('/:id', donationController.deleteUpdate);

module.exports = router;
