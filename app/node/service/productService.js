const productRepository = require("../repository/productRepository");
const getAllProducts = async () => {
    return await productRepository.findAll();
};
const getProductById = async (id) => {
    return await productRepository.findById(id);
};
const createProduct = async (data) => {
    if (!data.name) throw new Error("Name wajib diisi");
    return await productRepository.create(data);
};
const updateProduct = async (id, data) => {
    if (!data.name) throw new Error("Name wajib diisi");
    return await productRepository.update(id, data);
};
const deleteProduct = async (id) => {
    return await productRepository.destroy(id);
};
module.exports = {
    getAllProducts,
    getProductById,
    createProduct,
    updateProduct,
    deleteProduct,
};
