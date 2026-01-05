const donationRepository = require("../repository/donationRepository");

const getAllUpdates = async () => {
    return await donationRepository.findAll();
};

const getUpdatesByDonationId = async (donationId) => {
    return await donationRepository.findByDonationId(donationId);
};

const createUpdate = async (data) => {
    if (!data.donation_id || !data.title) {
        throw new Error("Donation ID dan title wajib diisi");
    }
    return await donationRepository.create(data);
};

const getUpdateById = async (id) => {
    return await donationRepository.findById(id);
};

const updateUpdate = async (id, data) => {
    if (!data.title) throw new Error("Title wajib diisi");
    return await donationRepository.update(id, data);
};

module.exports = {
    getAllUpdates,
    getUpdatesByDonationId,
    getUpdateById,
    createUpdate,
    updateUpdate,
    deleteUpdate,
};