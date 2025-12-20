const productService = require("../service/productService");
const getAllProducts = async (req, res) => {
    try {
        const products = await productService.getAllProducts();
        res.status(200).json(products);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};
const getProductById = async (req, res) => {
    try {
        const product = await productService.getProductById(req.params.id);
        if (!product) {
            return res.status(404).json({ message: "Product tidak ditemukan" });
        }
        res.status(200).json(product);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};
const createProduct = async (req, res) => {
    try {
        await productService.createProduct(req.body);
        res.status(201).json({ message: "Product berhasil ditambahkan" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};
const updateProduct = async (req, res) => {
    try {
        await productService.updateProduct(req.params.id, req.body);
        res.status(200).json({ message: "Product berhasil diperbarui" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};
const deleteProduct = async (req, res) => {
    try {
        await productService.deleteProduct(req.params.id);
        res.status(200).json({ message: "Product berhasil dihapus" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};
module.exports = {
    getAllProducts,
    getProductById,
    createProduct,
    updateProduct,
    deleteProduct,
};
