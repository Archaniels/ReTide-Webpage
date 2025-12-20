const blogService = require("../service/blogService");
const getAllBlogs = async (req, res) => {
    try {
        const blogs = await blogService.getAllBlogs();
        res.status(200).json(blogs);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};
const getBlogById = async (req, res) => {
    try {
        const blog = await blogService.getBlogById(req.params.id);
        if (!blog) {
            return res.status(404).json({ message: "Blog tidak ditemukan" });
        }
        res.status(200).json(blog);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
};
const createBlog = async (req, res) => {
    try {
        await blogService.createBlog(req.body);
        res.status(201).json({ message: "Blog berhasil ditambahkan" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};
const updateBlog = async (req, res) => {
    try {
        await blogService.updateBlog(req.params.id, req.body);
        res.status(200).json({ message: "Blog berhasil diperbarui" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};
const deleteBlog = async (req, res) => {
    try {
        await blogService.deleteBlog(req.params.id);
        res.status(200).json({ message: "Blog berhasil dihapus!" });
    } catch (err) {
        res.status(400).json({ message: err.message });
    }
};
module.exports = {
    getAllBlogs,
    getBlogById,
    createBlog,
    updateBlog,
    deleteBlog,
};
