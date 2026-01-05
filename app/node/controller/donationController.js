const donationService = require("../service/donationService");
const getAllUpdates = async (req, res) => {
    try {
        const updates = await donationService.getAllUpdates();
        res.status(200).json(updates);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};

const getUpdatesByDonationId = async (req, res) => {
    try {
        const updates = await donationService.getUpdatesByDonationId(req.params.donation_id);
        res.status(200).json(updates);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};

const createUpdate = async (req, res) => {
    try {
        await donationService.createUpdate(req.body);
        res.status(201).json({ message: 'Update berhasil ditambahkan' });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};

const getUpdateById = async (req, res) => {
    try {
        const update = await donationService.getUpdateById(req.params.id);
        if (!update) {
            return res.status(404).json({ message: 'Update tidak ditemukan' });
        }
        res.status(200).json(update);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};

const updateUpdate = async (req, res) => {
    try {
        await donationService.updateUpdate(req.params.id, req.body);
        res.status(200).json({ message: 'Update berhasil diperbarui' });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};

module.exports = {
    getAllUpdates,
    getUpdatesByDonationId,
    getUpdateById,
    createUpdate,
    updateUpdate,
    deleteUpdate,
};