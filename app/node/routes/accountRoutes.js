const express = require('express');
const router = express.Router();
const accountController = require('../controller/accountController');
const authMiddleware = require('../middleware/auth'); // Pastikan Anda memiliki middleware ini

router.put('/account', authMiddleware, accountController.updateAccount);
router.delete('/account', authMiddleware, accountController.deleteAccount);

module.exports = router;