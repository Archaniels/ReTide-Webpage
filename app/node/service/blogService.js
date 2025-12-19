const blogRepository = require("../repository/blogRepository");
const getAllBlogs = async () => {
    return await blogRepository.findAll();
};
const getBlogById = async (id) => {
    return await blogRepository.findById(id);
};
const createBlog = async (data) => {
    if (!data.title) throw new Error("Title wajib diisi");
    return await blogRepository.create(data);
};
const updateBlog = async (id, data) => {
    if (!data.title) throw new Error("Title wajib diisi");
    return await blogRepository.update(id, data);
};
const deleteBlog = async (id) => {
    return await blogRepository.destroy(id);
};
module.exports = {
    getAllBlogs,
    getBlogById,
    createBlog,
    updateBlog,
    deleteBlog,
};
