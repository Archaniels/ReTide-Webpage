const accountService = require("../service/accountService");

const updateAccount = async (req, res) => {
    try {
        // userId didapat dari middleware autentikasi (Auth::user() di Laravel)
        await accountService.updateAccount(req.user.id, req.body);
        res.status(200).json({ message: "Profil berhasil diperbarui!" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};

const deleteAccount = async (req, res) => {
    try {
        await accountService.deleteAccount(req.user.id);
        res.status(200).json({ message: "Akun berhasil dihapus!" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};

module.exports = { updateAccount, deleteAccount };