const { User } = require("../models");
const bcrypt = require('bcrypt');
const { Op } = require("sequelize");

const updateAccount = async (userId, data) => {
    // 1. Validasi Keunikan: Pastikan 'name' tidak dipakai orang lain
    const duplicate = await User.findOne({
        where: {
            name: data.username,
            id: { [Op.ne]: userId } // Kecuali ID user saat ini
        }
    });

    if (duplicate) throw new Error("Username sudah digunakan oleh orang lain!");

    // 2. Cari User
    const user = await User.findByPk(userId);
    if (!user) throw new Error("User tidak ditemukan");

    let updateData = {
        name: data.username,
        email: data.email,
        phone_number: data.notelp
    };

    // 3. Logika Password (Sama dengan Hash::check di Laravel)
    if (data.new_password) {
        const isMatch = await bcrypt.compare(data.current_password, user.password);
        if (!isMatch) throw new Error("Password lama salah!");

        updateData.password = await bcrypt.hash(data.new_password, 10);
    }

    return await user.update(updateData);
};

const deleteAccount = async (userId) => {
    return await User.destroy({ where: { id: userId } });
};

module.exports = { updateAccount, deleteAccount };