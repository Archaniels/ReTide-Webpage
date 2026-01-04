// Simulasi database (nanti bisa MySQL)
let donationUpdates = [];

const findAll = () => {
    return new Promise((resolve, reject) => {
        resolve(donationUpdates);
    });
};

const findByDonationId = (donationId) => {
    return new Promise((resolve, reject) => {
        const updates = donationUpdates.filter(
            d => d.donation_id == donationId
        );
        resolve(updates);
    });
};

const create = (data) => {
    return new Promise((resolve, reject) => {
        const newUpdate = {
            id: donationUpdates.length + 1,
            ...data,
            created_at: new Date()
        };
        donationUpdates.push(newUpdate);
        resolve(newUpdate);
    });
};

const destroy = (id) => {
    return new Promise((resolve, reject) => {
        const initialLength = donationUpdates.length;
        donationUpdates = donationUpdates.filter(
            d => d.id != id
        );
        if (donationUpdates.length < initialLength) {
            resolve(true);
        } else {
            reject(new Error("Update tidak ditemukan"));
        }
    });
};

module.exports = {
    findAll,
    findByDonationId,
    create,
    destroy,
};