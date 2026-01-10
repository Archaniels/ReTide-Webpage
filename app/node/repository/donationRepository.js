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
            created_at: new Date().toISOString(),
            updated_at: new Date().toISOString()
        };
        donationUpdates.push(newUpdate);
        console.log('All stored updates:', donationUpdates);
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

const findById = (id) => {
    return new Promise((resolve, reject) => {
        const update = donationUpdates.find(d => d.id == id);
        resolve(update);
    });
};

const update = (id, data) => {
    return new Promise((resolve, reject) => {
        const index = donationUpdates.findIndex(d => d.id == id);
        if (index !== -1) {
            donationUpdates[index] = { ...donationUpdates[index], ...data, updated_at: new Date() };
            resolve(donationUpdates[index]);
        } else {
            reject(new Error("Update tidak ditemukan"));
        }
    });
};

module.exports = {
    findAll,
    findByDonationId,
    findById,
    create,
    update,
    destroy,
};